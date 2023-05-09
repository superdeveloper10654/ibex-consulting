<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Http\Controllers\Resource\Traits\HasComments;
use AppTenant\Http\Controllers\Resource\Traits\HasDeletionsAndDrafts;
use AppTenant\Mail\MitigationNotified;
use AppTenant\Models\Activity;
use AppTenant\Models\EarlyWarning;
use AppTenant\Models\Notification;
use AppTenant\Models\Statical\MediaCollection;
use AppTenant\Models\Mitigation;
use App\Models\Statical\Constant;
use AppTenant\Models\Status\MitigationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MitigationsController extends BaseController
{
    use HasComments, HasDeletionsAndDrafts;
    
    public function index()
    {
        $mitigations = Mitigation::notDraftedOrMine()
                        ->with(['early_warning', 'early_warning.compensation_event'])
                        ->latest()
                        ->paginate(config('app.pagination_size'));

        return t_view('mitigations.index', [
            'mitigations'    => $mitigations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $early_warnings = EarlyWarning::whereDoesntHave('mitigation')->get();

        return t_view('mitigations.create', [
            'early_warnings'    => $early_warnings
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
        $status = $request->get('is_draft', false) ? MitigationStatus::DRAFT_ID : MitigationStatus::NOTIFIED_ID;

        $mitigation = Mitigation::create([
            'name'              => $request->get('name'),
            'description'       => $request->get('description'),
            'status'            => $status,
            'early_warning_id'  => $request->get('early_warning'),
            'created_by'        => t_profile()->id,
        ]);

        if (!$mitigation) {
            $this->jsonError();
        }

        if (!$mitigation->isDraft()) {
            Activity::resource('notified', $mitigation);

            if (isProductionOrStaging()) {
                Mail::to(admin_profile()->email)->queue(new MitigationNotified($mitigation));
            }
        }

        return $this->jsonSuccess('Mitigation successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mitigation = Mitigation::with(['early_warning', 'comments.commentator'])->findOrFail($id);

        if (!$mitigation->isDraft() && $mitigation->created_by != t_profile()->id) {
            abort(404);
        }

        $files = Media::where('collection_name', MediaCollection::COLLECTION_MITIGATIONS)
            ->where('custom_properties->resource_id', $id)
            ->get();

        return t_view('mitigations.show', [
            'mitigation'    => $mitigation,
            'files'         => $files
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
        $mitigation = Mitigation::with(['early_warning', 'comments.commentator'])->findOrFail($id);

        if (empty($mitigation) || !$mitigation->canBeUpdated()) {
            abort(404);
        }

        $early_warnings = EarlyWarning::whereDoesntHave('mitigation')->get();
        $early_warnings->add($mitigation->early_warning);

        return t_view('mitigations.edit', [
            'mitigation'        => $mitigation,
            'early_warnings'    => $early_warnings,
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
        $mitigation = Mitigation::findOrFail($id);

        if (empty($mitigation) || !$mitigation->canBeUpdated()) {
            abort(404);
        }
        
        $this->validateRequest($request, Constant::ACTION_UPDATE, $mitigation);

        $mitigation->name = $request->get('name');
        $mitigation->description = $request->get('description');
        $mitigation->early_warning_id = $request->get('early_warning');
        $mitigation->update();
        
        if (!$mitigation->isDraft()) {
            Activity::resource('Updated', $mitigation);
        }

        return $this->jsonSuccess('Updated successfully');
    }

    /**
     * Update Mitigation status to Submitted
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function notify($id)
    {
        $mitigation = Mitigation::findMineDraftedOrFail($id);
        $mitigation->status = MitigationStatus::NOTIFIED_ID;
        $mitigation->save();
        Activity::resource('notified', $mitigation);
        Notification::resource('notified', $mitigation);
        
        if (isProductionOrStaging()) {
            Mail::to(admin_profile()->email)->queue(new MitigationNotified($mitigation));
        }

        return redirect( t_route('mitigations.show', $id));
    }

    /**
     * Update Mitigation status to Closed
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function close($id)
    {
        $mitigation = Mitigation::findOrFail($id);

        if (!$mitigation->isNotified()) {
            abort(404);
        }

        $mitigation->status = MitigationStatus::CLOSED_ID;
        $mitigation->save();
        Activity::resource('closed', $mitigation);

        return redirect( t_route('mitigations.show', $id));
    }

    /**
     * Validate request depending from action
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $action store|update
     * @param Mitigation $mitigation to update
     */
    protected function validateRequest($request, $action = Constant::ACTION_STORE, $mitigation = null)
    {
        $early_warning_ids = EarlyWarning::whereDoesntHave('mitigation')->get()->pluck('id')->toArray();

        if ($action == Constant::ACTION_UPDATE) {
            $early_warning_ids[] = $mitigation->early_warning_id;
        }

        $rules = [
            'name'          => 'required|string|max:255',
            'description'   => 'required|string|max:5000',
            'early_warning' => 'required|integer|in:' . implode(',', $early_warning_ids),
        ];

        $request->validate($rules);
    }
}
