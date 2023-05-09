<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Http\Controllers\Resource\Traits\HasComments;
use AppTenant\Http\Controllers\Resource\Traits\HasDeletionsAndDrafts;
use AppTenant\Mail\EarlyWarningNotified;
use AppTenant\Models\Activity;
use AppTenant\Models\EarlyWarning;
use AppTenant\Models\Status\EarlyWarningStatus;
use AppTenant\Models\Notification;
use AppTenant\Models\Statical\MediaCollection;
use AppTenant\Models\Contract;
use AppTenant\Models\Programme;
use AppTenant\Models\NotificationSetting;
use App\Models\Statical\Constant;
use AppTenant\Models\Status\ProgrammeStatus;
use AppTenant\Notifications\TeamsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EarlyWarningsController extends BaseController
{
    use HasComments, HasDeletionsAndDrafts;

    public function index()
    {
        $early_warnings = EarlyWarning::notDraftedOrMine()
            ->latest()
            ->paginate(config('app.pagination_size'));

        return t_view('early-warnings.index', [
            'early_warnings'    => $early_warnings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contracts = Contract::all();
        $programmes = Programme::notDrafted()
                        ->where('status', '!=', ProgrammeStatus::REJECTED_ID)
                        ->get()
                        ->map(function($item) {
                            return (object) [
                                'id'            => $item->id,
                                'name'          => $item->name,
                                'visible_for'   => ['contract'   => $item->contract->id],
                            ];
                        });

        return t_view('early-warnings.create', [
            'contracts'     => $contracts,
            'programmes'    => $programmes,
            'table'         => $this->getScoreTable(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);
        $status = $request->get('is_draft', false) ? EarlyWarningStatus::DRAFT_ID : EarlyWarningStatus::NOTIFIED_ID;

        $warning = EarlyWarning::create([
            'contract_id'   => $request->get('contract'),
            'profile_id'    => t_profile()->id,
            'programme_id'  => $request->get('programme'),
            'title'         => $request->get('title'),
            'description'   => $request->get('description'),
            'effect1'       => $request->get('effect1'),
            'effect2'       => $request->get('effect2'),
            'effect3'       => $request->get('effect3'),
            'effect4'       => $request->get('effect4'),
            'risk_score'    => $request->get('risk_score'),
            'score_order'   => $request->get('score_order'),
            'status'        => $status,
        ]);

        if (!$warning) {
            $this->jsonError();
        }

        $this->addActivityAndNotificatonByStatus($warning);

        if ($warning->isNotified() && isProductionOrStaging()) {
            Mail::to(admin_profile()->email)->queue(new EarlyWarningNotified($warning));
        }

        return $this->jsonSuccess('Early warning successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $early_warning = EarlyWarning::with(['contract', 'programme', 'author_profile', 'mitigation', 'comments.commentator'])->notDraftedOrMine()->findOrFail($id);
        $files = Media::where('collection_name', MediaCollection::COLLECTION_EARLY_WARNINGS)
            ->where('custom_properties->resource_id', $id)
            ->get();

        return t_view('early-warnings.show', [
            'early_warning' => $early_warning,
            'files'         => $files,
            'table'         => $this->getScoreTable(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $early_warning = EarlyWarning::findOrFail($id);

        if (empty($early_warning) || !$early_warning->canBeUpdated()) {
            abort(404);
        }

        $contracts = Contract::all();
        $programmes = Programme::all()->map(function($item) {
            return (object) [
                'id'            => $item->id,
                'name'          => $item->name,
                'visible_for'   => ['contract' => $item->contract->id],
            ];
        });

        return t_view('early-warnings.edit', [
            'contracts'     => $contracts,
            'early_warning' => $early_warning,
            'programmes'    => $programmes,
            'table'         => $this->getScoreTable(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $early_warning = EarlyWarning::findOrFail($id);

        if (empty($early_warning) || !$early_warning->canBeUpdated()) {
            abort(404);
        }

        $this->validateRequest($request, Constant::ACTION_UPDATE, $early_warning);
        $early_warning->update([
            'contract_id'   => $request->get('contract'),
            'programme_id'  => $request->get('programme'),
            'title'         => $request->get('title'),
            'description'   => $request->get('description'),
            'effect1'       => $request->get('effect1'),
            'effect2'       => $request->get('effect2'),
            'effect3'       => $request->get('effect3'),
            'effect4'       => $request->get('effect4'),
            'risk_score'    => $request->get('risk_score'),
        ]);

        $this->addActivityAndNotificatonByStatus($early_warning, $early_warning->status);

        return $this->jsonSuccess('Updated');
    }

    /**
     * Update EW status to Closed
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function close($id)
    {
        $early_warning = EarlyWarning::findOrFail($id);

        if (!$early_warning->isNotified() || ($early_warning->isDraft() && !$early_warning->hasAuthor(t_profile()))) {
            abort(404);
        }

        if (in_array($early_warning->status, [EarlyWarningStatus::NOTIFIED_ID, EarlyWarningStatus::DRAFT_ID])) {
            $old_status_id = $early_warning->status;
            $early_warning->status = EarlyWarningStatus::CLOSED_ID;
            $early_warning->save();

            $this->addActivityAndNotificatonByStatus($early_warning, $old_status_id);
        }

        return redirect( t_route('early-warnings.show', $id));
    }

    /**
     * Update EW status to Escalated
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function escalate($id)
    {
        $early_warning = EarlyWarning::findOrFail($id);

        if (!$early_warning->isNotified()) {
            abort(404);
        }
        
        $old_status_id = $early_warning->status;
        $early_warning->status = EarlyWarningStatus::ESCALATED_ID;
        $early_warning->save();

        $this->addActivityAndNotificatonByStatus($early_warning, $old_status_id);

        // @todo some action to move EW data to Quotation Event Notice

        return redirect( t_route('early-warnings.show', $id));
    }

    /**
     * Update EW status to Notified
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function notify($id)
    {
        $early_warning = EarlyWarning::findMineDraftedOrFail($id);

        $old_status_id = $early_warning->status;
        $early_warning->status = EarlyWarningStatus::NOTIFIED_ID;
        $early_warning->save();

        $this->addActivityAndNotificatonByStatus($early_warning, $old_status_id);

        if (isProductionOrStaging()) {
            Mail::to(admin_profile()->email)->queue(new EarlyWarningNotified($early_warning));
        }

        // @todo some action to move EW data to Quotation Event Notice

        return redirect( t_route('early-warnings.show', $id));
    }

    protected function validateRequest(Request $request, $action = Constant::ACTION_STORE, $early_warning = null)
    {
        $request->validate([
            'contract'      => 'required|integer|exists:contracts,id',
            'programme'     => 'required|integer|exists:programmes,id',
            'title'         => 'required|string|max:191',
            'description'   => 'required|string|max:12000',
            'effect1'       => 'required|boolean',
            'effect2'       => 'required|boolean',
            'effect3'       => 'required|boolean',
            'effect4'       => 'required|boolean',
            'risk_score'    => 'required|integer|min:1|max:25',
            'score_order'   => 'required|integer|min:0|max:44',
            'is_draft'      => 'boolean',
        ]);

        $programme = Programme::notDrafted()
                        ->where('status', '!=', ProgrammeStatus::REJECTED_ID)
                        ->where('id', $request->get('programme'))
                        ->first();

        if (empty($programme)) {
            throw ValidationException::withMessages(['programme' => 'Programme is incorrect']);
        }
    }

    /**
     * Return array for score table generation
     *
     * @return array
     */
    protected function getScoreTable()
    {
        $colors = EarlyWarning::riskScoreColor();

        $table = [];
        $table[] = [5, 10, 15, 20, 25,];
        $table[] = [4, 8, 12, 16, 20,];
        $table[] = [3, 6, 9, 12, 15,];
        $table[] = [2, 4, 6, 8, 10,];
        $table[] = [1, 2, 3, 4, 5,];

        return array('table' => $table, 'colors' => $colors);
    }

    /**
     * Send activities and notifications by status
     * 
     * @param EarlyWarning $warning
     * @param EarlyWarningStatus $status_id
     * @param EarlyWarningStatus $old_status_id - in case if status was changed for existing EW
     */
    protected function addActivityAndNotificatonByStatus($warning, $old_status_id = null)
    {
        $status = $warning->status();

        if ($warning->status()->id == $old_status_id) {
            $action = 'updated';
        } else {
            $action = $status->name;
        }
        
        Activity::resource("$action", $warning);
        Notification::resource("$action", $warning);

        $notificationSetting =  NotificationSetting::where('name', 'MS Teams Early Warnings Notifications Webhook URL')->whereNotNull('value')->where('status', 1)->first();

        if ($notificationSetting) {
            $details['content'] = t_profile()->full_name() . " $action <a href='" . t_route('early-warnings.show', $warning->id) . "'>Early Warning #{$warning->id}</a> for {$warning->contract->contract_name}";
            $details['webhook_url'] = $notificationSetting->value;
            $details['title'] = 'Applications';
            $details['type'] = 'warning';
            //Invoke Teams Notifications
            t_profile()->notify(new TeamsNotification($details));
        }
    }
}
