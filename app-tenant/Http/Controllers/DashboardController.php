<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\Activity;
use AppTenant\Models\Contract;
use AppTenant\Models\EarlyWarning;
use AppTenant\Models\Status\EarlyWarningStatus;
use AppTenant\Models\Profile;
use AppTenant\Models\Programme;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contracts_count = Contract::count();
        $programmes_count = Programme::count();
        $projects_count = 0;
        $team_accounts = Profile::where('email', '<>', env('SUPPORT_PROFILE_EMAIL'))
                                ->where('id', '<>', t_profile()->id)
                                ->take(4)
                                ->get();

        $early_warnings = EarlyWarning::orderBy('id', 'desc')->get();
        $early_warnings_count = EarlyWarning::notDrafted()->count();
        $early_warnings_open_count = EarlyWarning::where('status', EarlyWarningStatus::NOTIFIED_ID)->count();
      

        $compensation_events_count = 0;
        $compensation_events_open_count = 0;

        $snags_and_defects_count = 0;
        $snags_and_defects_open_count = 0;

        $risk_profiles_count = $early_warnings_count;
        $risk_profiles_open_count = $early_warnings_open_count;
        $risk_profiles_chart_arr = $this->getRiskProfilesChartArr();

        $activities = Activity::with('profile')
                                ->visibleForCurrentUser()
                                ->orderBy('id', 'desc')
                                ->take(15)
                                ->get();

        $projects = Programme::orderBy('id', 'desc')->take(4)->get();
        $contracts = Contract::orderBy('id', 'desc')->get();

        return t_view('dashboard.index', [
            'contract_count'                    => $contracts_count,
            'programme_count'                   => $programmes_count,
            'project_count'                     => $projects_count,
            'team_accounts'                     => $team_accounts,
            'early_warnings'                    => $early_warnings,
            'early_warning_count'               => $early_warnings_count,
            'early_warning_open_count'          => $early_warnings_open_count,
            'compensation_events_count'         => $compensation_events_count,
            'compensation_events_open_count'    => $compensation_events_open_count,
            'snags_and_defects_count'           => $snags_and_defects_count,
            'snags_and_defects_open_count'      => $snags_and_defects_open_count,
            'risk_profiles_count'               => $risk_profiles_count,
            'risk_profiles_open_count'          => $risk_profiles_open_count,
            'risk_profiles_chart_arr'           => $risk_profiles_chart_arr,
            'activities'                        => $activities,
            'contracts'                         => $contracts,
            'projects'                          => $projects,
            'profile'                           => t_profile()
        ]);
    }

    protected function getRiskProfilesChartArr()
    {
        $days_total = 11;
        $ew_per_date = DB::select("select count(*) as count, date(date_notified) as date 
            from early_warnings 
            where 
                date_notified >= date_sub(curdate(), interval $days_total day)
                AND status NOT IN (" . EarlyWarningStatus::DRAFT_ID . ")
            group by date");
        $result = [];
        
        for ($i = $days_total - 1; $i >= 0; $i--) {
            $date = Carbon::now();
            $week_date = $date->subDays($i)->format('Y-m-d');
            
            if (!empty($ew_per_date)) {
                $count_ew = array_filter($ew_per_date, function($item) use($week_date) {
                    return $item->date == $week_date;
                });
                $result[] = !empty($count_ew) ? current($count_ew)->count : 0;
            } else {
                $result[] = 0;
            }
        }

        return $result;
    }
}
