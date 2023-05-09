<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Http\Controllers\Resource\Traits\HasComments;
use AppTenant\Models\Activity;
use AppTenant\Models\Measure;
use AppTenant\Models\Status\MeasureStatus;
use AppTenant\Models\Statical\MediaCollection;
use AppTenant\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MeasuresController extends BaseController
{
    use HasComments;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $measures = Measure::paginate(config('app.pagination_size'));

        return t_view('measures.index', [
            'measures'   => $measures
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

        return t_view('measures.create', [
            'contracts'    => $contracts,
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
        $request->validate([
            'contract_id'                       => 'required|integer|exists:contracts,id',
            'site_name'                         => 'required|string|max:255',
            'description'                       => 'required|string|max:5000',
            'quantified_items'                  => 'array',
            'quantified_items.*.item'           => 'required|string|max:255',
            'quantified_items.*.rate_card_id'   => 'required|integer|exists:rate_cards,id',
            'quantified_items.*.lat'            => 'required|numeric',
            'quantified_items.*.lng'            => 'required|numeric',
            'quantified_items.*.qty'            => 'required|integer',
            'linear_items'                      => 'array',
            'linear_items.*.description'        => 'required|string|max:255',
            'linear_items.*.rate_card_id'       => 'required|integer|exists:rate_cards,id',
            'linear_items.*.length'             => 'required|numeric',
            'linear_items.*.width'              => 'required|numeric',
            'linear_items.*.depth'              => 'required|numeric',
        ]);

        $measure = Measure::create([
            'contract_id'       => $request->get('contract_id'),
            'profile_id'        => t_profile()->id,
            'site_name'         => $request->get('site_name'),
            'description'       => $request->get('description'),
            'quantified_items'  => $request->get('quantified_items', []),
            'linear_items'      => $request->get('linear_items', []),
            'status'            => MeasureStatus::SAVED_ID,
        ]);

        Activity::resource("Submitted", $measure);

        return $measure ? $this->jsonSuccess('Measure successfully created') : $this->jsonError();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $measure = Measure::with(['contract', 'profile', 'comments.commentator'])->findOrFail($id);
        $files = Media::where('collection_name', MediaCollection::COLLECTION_MEASURES)
                            ->where('custom_properties->resource_id', $id)
                            ->get();
        $quantified_items_json = array_map([$this, 'formatQuantLinerItemJson'], $measure->quantified_items);
        $linear_items_json = array_map([$this, 'formatQuantLinerItemJson'], $measure->linear_items);

        return t_view('measures.show', [
            'measure'               => $measure,
            'files'                 => $files,
            'quantified_items_json' => $quantified_items_json,
            'linear_items_json'     => $linear_items_json,
        ]);
    }

    protected function formatQuantLinerItemJson($item)
    {
        $item->rate_card = $item->rate_card->only(['item_desc', 'unit', 'pin']);
        $item->rate_card['pin'] = $item->rate_card['pin']->only(['icon_url', 'line_color', 'line_type', 'fill_color']);
        return $item;
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
        // Activity::add( replace with ::resource()
        //     "Updated <a href='" . t_route('measures.show', $measure->id) ."'>measure {$measure->id}</a>",
        //     Measure::$activity_icon
        // );
    }

    /**
     * Update status
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $measure = Measure::findOrFail($id);

        if ($measure->isDraft()) {
            $measure->status = MeasureStatus::SUBMITTED_ID;
            $measure->update();

            Activity::resource("Submitted", $measure);

            return $this->jsonSuccess('Measure status successfully updated');
        } else {
            return $this->jsonError();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $measure = Measure::with('applications')->findOrFail($id);

        if (!$measure->applications->isEmpty()) {
            return $this->jsonError('You cannot delete the measure as it is used in application(s)');
        }

        $measure->delete();

        return $this->jsonSuccess('Successfully removed');
    }

    /**
     * Return specific data by action in json format
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function ajax(Request $request)
    {
        $action = $request->get('action');

        if ($action == 'getById') {
            $measure_id = (int) $request->get('id');
            $measure = Measure::findOrFail($measure_id);

            return $this->jsonSuccess('Success', $measure);
        }
    }
}
