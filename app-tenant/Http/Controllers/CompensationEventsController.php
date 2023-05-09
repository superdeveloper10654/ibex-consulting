<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Http\Controllers\Resource\Traits\HasComments;
use AppTenant\Http\Controllers\Resource\Traits\HasDeletionsAndDrafts;
use AppTenant\Models\Activity;
use AppTenant\Models\CompensationEvent;
use AppTenant\Models\Contract;
use AppTenant\Models\EarlyWarning;
use AppTenant\Models\Mitigation;
use AppTenant\Models\Notification;
use AppTenant\Models\Programme;
use App\Models\Statical\Constant;
use AppTenant\Models\Statical\MediaCollection;
use AppTenant\Models\Status\CompensationEventStatus;
use AppTenant\Models\Status\EarlyWarningStatus;
use AppTenant\Models\Status\ProgrammeStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CompensationEventsController extends BaseController
{
    use HasComments, HasDeletionsAndDrafts;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = CompensationEvent::notDraftedOrMine()
                    ->latest()
                    ->paginate(config('app.pagination_size'));

        return t_view('compensation-events.index', [
            'events'    => $events
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'early_warning'  => 'exists:early_warnings,id',
            'mitigation'     => 'exists:mitigations,id'
        ]);

        $selected_ew_id = '';

        if (!empty($request->get('early_warning'))) {
            $selected_ew_id = $request->get('early_warning');

        } else if (!empty($request->get('mitigation_id'))) {
            $mitigation = Mitigation::whereHas('early_warning')->findOrFail($request->get('mitigation_id'));
            $selected_ew_id = $mitigation->early_warning->id;
        }

        return t_view('compensation-events.create', array_merge($this->dataForCreateEditPages(), [
            'selected_ew_id'    => $selected_ew_id
        ]));
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
        $status = $request->get('is_draft', false) ? CompensationEventStatus::DRAFT_ID : CompensationEventStatus::NOTIFIED_ID;

        $event = CompensationEvent::create([
            'programme_id'              => $request->get('programme'),
            'title'                     => $request->get('title'),
            'description'               => $request->get('description'),
            'status'                    => $status,
            'early_warning_notified'    => $request->get('early_warning_notified', 0),
            'early_warning_id'          => $request->get('early_warning'),
            'created_by'                => t_profile()->id,
        ]);

        if (!$event) {
            $this->jsonError();
        }

        if (!$event->isDraft()) {
            Activity::resource("notified", $event);
            Notification::resource("notified", $event);
        }

        return $this->jsonSuccess('Compensation Event successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = CompensationEvent::findOrFail($id);
        $files = Media::where('collection_name', MediaCollection::COLLECTION_COMPENSATION_EVENTS)
            ->where('custom_properties->resource_id', $id)
            ->get();

        return t_view('compensation-events.show', [
            'event' => $event,
            'files' => $files,
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
        $event = CompensationEvent::findOrFail($id);

        if (empty($event) || !$event->canBeUpdated()) {
            abort(404);
        }

        return t_view('compensation-events.edit', array_merge($this->dataForCreateEditPages($event), [
            'event' => $event,
        ]));
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
        $event = CompensationEvent::findOrFail($id);

        if (empty($event) || !$event->canBeUpdated()) {
            abort(404);
        }
        
        $this->validateRequest($request, Constant::ACTION_UPDATE, $event);

        $ew_notified = $request->get('early_warning') !== Constant::OPTION_NO_EARLY_WARNING_ID
            ? $request->get('early_warning')
            : 0;

        $res = $event->update([
            'programme_id'              => $request->get('programme'),
            'title'                     => $request->get('title'),
            'description'               => $request->get('description'),
            'early_warning_notified'    => $ew_notified,
            'early_warning_id'          => $request->get('early_warning'),
            'status'                    => CompensationEventStatus::NOTIFIED_ID,
        ]);

        if (!$res) {
            $this->jsonError();
        }

        if (!$event->isDraft()) {
            Activity::resource('updated', $event);
        }

        return $this->jsonSuccess('Compensation Event successfully updated');
    }

    /**
     * Update Compensation Event status to Notified
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function notify($id)
    {
        $event = CompensationEvent::findMineDraftedOrFail($id);
        $event->status = CompensationEventStatus::NOTIFIED_ID;
        $event->save();

        Activity::resource("notified", $event);
        Notification::resource("notified", $event);

        return redirect( t_route('compensation-events.show', $id));
    }

    /**
     * Validate request depending from action
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $action store|update
     * @param CompensationEvent $compensation_event to update
     */
    protected function validateRequest($request, $action = Constant::ACTION_STORE, $compensation_event = null)
    {
        $early_warning_ids = EarlyWarning::whereDoesntHave('compensation_event')->notDrafted()->get()
            ->pluck('id')->toArray();
        $early_warning_ids[] = Constant::OPTION_NO_EARLY_WARNING_ID;

        if ($action == Constant::ACTION_UPDATE) {
            $early_warning_ids[] = $compensation_event->early_warning_id;
        }

        $rules = [
            'programme'              => 'required|integer|exists:programmes,id',
            'title'                  => 'required|string|max:255',
            'description'            => 'required|string|max:60000',
            'early_warning'          => 'nullable|in:' . implode(',', $early_warning_ids),
            'early_warning_notified' => 'boolean|exclude_unless:early_warning,' . Constant::OPTION_NO_EARLY_WARNING_ID,
        ];

        $request->validate($rules);
    }

    /**
     * Get common between create/edit pages data
     * 
     * @param CompensationEvent $event
     * @return array
     */
    protected function dataForCreateEditPages($event = null)
    {
        $contracts = Contract::all()->pluck('contract_name', 'id');
        $programmes = Programme::notDrafted()
                        ->where('status', '!=', ProgrammeStatus::REJECTED_ID)
                        ->get()
                        ->map(function($programme) {
                            return (object) [
                                'id'            => $programme->id,
                                'name'          => $programme->name,
                                'visible_for'   => ['contract_id' => $programme->contract_id],
                            ];
                        });
        $early_warnings = EarlyWarning::whereDoesntHave('compensation_event')
                            ->notDrafted()
                            ->where('status', '!=', EarlyWarningStatus::CLOSED_ID)
                            ->get()
                            ->map(function($early_warning) {
                                return (object) [
                                    'id'            => $early_warning->id,
                                    'name'          => $early_warning->title,
                                    'visible_for'   => ['programme' => $early_warning->programme_id],
                                ];
                            });
        
        if ($event && $event->early_warning) {
            $early_warning = $event->early_warning;
            $early_warnings[] = (object) [
                'id'            => $early_warning->id,
                'name'          => $early_warning->title,
                'visible_for'   => ['programme' => $early_warning->programme_id],
            ];
        }

        $early_warnings[] = (object) [
            'id'        => Constant::OPTION_NO_EARLY_WARNING_ID,
            'name'      => Constant::OPTION_NO_EARLY_WARNING,
        ];

        return [
            'contracts'         => $contracts,
            'programmes'        => $programmes,
            'early_warnings'    => $early_warnings,
        ];
    }
}
