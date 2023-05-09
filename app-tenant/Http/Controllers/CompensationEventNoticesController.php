<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Mail\CompensationEventNotificationNotified;
use Illuminate\Http\Request;
use AppTenant\Models\Contract;
use AppTenant\Models\Profile ;
use AppTenant\Models\CompensationEvent;
use AppTenant\Models\EarlyWarning;
use AppTenant\Models\Status\CompensationEventStatus;
use Illuminate\Support\Facades\Auth ;
use AppTenant\Models\Activity;
use AppTenant\Models\Notification;
use Illuminate\Support\Facades\Mail;

class CompensationEventNoticesController extends BaseController
{
    // use HasComments;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile_id = t_profile()->id;
        $role = Profile::where('id',$profile_id)->select('role')->get();
        $contracts = Contract::where("profile_id",$profile_id)->select('id','contract_name')->orderBy('order_ref','desc')->get();
        $i = 0 ;
        $sources = collect([]);
        foreach ( $contracts as $contract){
            $i ++ ;
            if ( $i != count($contracts)) continue ;
            $sources = EarlyWarning::where('profile_id',$profile_id)->where('contract_id',$contract->id)->select('id','title')->orderBy('score_order','desc')->get();
        }
        // $compensationEvents = CompensationEvent::notDraftedOrMine()->paginate(config('app.pagination_size'));

        return t_view('compensation-event-notices.index',[
            "contracts" => $contracts,
            "sources" => $sources,
            "role" => $role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $this->validateRequest($req);
        $status = $req->get('is_draft', false) ? CompensationEventStatus::DRAFT_ID : CompensationEventStatus::NOTIFIED_ID;
        $event = CompensationEvent::create([
            "programme_id"              => $req->get('early_warning_id'),
            'title'                     => $req->get('title'),
            'description'               => $req->get('description'),
            'status'                    => $status,
            'early_warning_notified'    => $req->get('early_warning_notified', 0),
            'early_warning_id'          => $req->get('early_warning_id'),
            'created_by'                => t_profile()->id,
        ]);
        if (!$event) {
            $this->jsonError();
        }

        if ($event->status != CompensationEventStatus::DRAFT_ID) {
            $this->addActivityAndNotificatonByStatus($event);

            if (isProductionOrStaging()) {
                Mail::to(admin_profile()->email)->queue(new CompensationEventNotificationNotified($event));
            }
        }
        
        return $this->jsonSuccess('Compensation Event successfully created');
        
    }

    public function pending(Request $req){
        $compensationEvents = CompensationEvent::all()->last();
        $name = Profile::where("id",$compensationEvents->created_by)->select('first_name','last_name')->first();
        $compensationEvents->first_name = $name->first_name ;
        $compensationEvents->last_name = $name->last_name ;
        return t_view('compensation-event-notices.pending',[
            'pending' => $compensationEvents,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function validateRequest($request)
    {
        $rules = [
            'title'                     => 'required|string|max:255',
            'description'               => 'required|string|max:60000'
        ];

        $request->validate($rules);
    }
    protected function addActivityAndNotificatonByStatus($event, $old_status_id = null)
    {
        $status = CompensationEventStatus::get($event->status);

        if ($old_status_id) {
            $old_status = CompensationEventStatus::get($old_status_id);
            $action = 'Updated status ' . $old_status->name . ' to ' . $status->name . ' for';
        } else {
            $action = $status->name;
        }

        Activity::resource("$action", $event);
        Notification::resource("$action", $event);
    }
}
