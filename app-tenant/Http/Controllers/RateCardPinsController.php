<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\RateCardPin;
use AppTenant\Models\Statical\RateCardUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RateCardPinsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pins = RateCardPin::paginate(config('app.pagination_size'));

        return t_view('rate-card-pins.index', compact('pins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $units = RateCardUnit::getAll();
        $line_types = RateCardUnit::lineTypesArr();
        
        return t_view('rate-card-pins.create', compact('units', 'line_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateStoreUpdate($request);
        $data = array_merge($request->all(), ['rate_card_unit' => $request->get('unit')]);

        if ($request->file('icon')) {
            $data['icon'] = $this->storeIcon($request->file('icon'));
        }

        RateCardPin::create($data);

        return $this->jsonSuccess('Rate card pin created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pin = RateCardPin::findOrFail($id);
        $units = RateCardUnit::getAll();
        $line_types = RateCardUnit::lineTypesArr();

        return t_view('rate-card-pins.edit', compact('pin', 'units', 'line_types'));
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
        $pin = RateCardPin::findOrFail($id);
        $this->validateStoreUpdate($request, 'update', $pin);

        $data = $request->all();
        $data['rate_card_unit'] = $request->get('unit');

        if ($request->file('icon') || ($pin->rate_card_unit == RateCardUnit::ITEM_ID && $data['rate_card_unit'] != RateCardUnit::ITEM_ID)) {
            if (!empty($pin->icon)) {
                $icon_path = config('path.images.rate_cards.pins') . "/{$pin->icon}";
                Storage::disk('public')->delete($icon_path);
                $data['icon'] = null;
            }
            if ($request->file('icon')) {
                $data['icon'] = $this->storeIcon($request->file('icon'));
            }
        }

        $pin->update($data);

        return $this->jsonSuccess('Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pin = RateCardPin::with('rate_cards')->findOrFail($id);

        if (!$pin->rate_cards->isEmpty()) {
            return $this->jsonError('This marker can\'t be removed, as it\'s in use on a rate card ');
        }

        $pin->delete();

        return $this->jsonSuccess('Successfully removed');
    }

    /**
     * Validates data on store/update requests
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  string $type of the validation: store|update
     * @param  AppTenant\Models\RateCardPin $initial_pin
     * @return void
     */
    protected function validateStoreUpdate(Request $request, $type = 'store', $initial_pin = '')
    {
        $data = [
            'name'          => 'required|string|max:255',
            'unit'          => ('required|in:' . implode(',', array_keys(RateCardUnit::getArray()))),
            'icon'          => 'file|image|max:512',
            'line_type'     => ('required_if:unit,' . RateCardUnit::LINE_ID . '|in:' . implode(',', array_keys(RateCardUnit::lineTypesArr()))),
            'line_color'    => ('required_if:unit,' . RateCardUnit::LINE_ID . '|size:7|regex:/#[a-zA-Z0-9]{6}/i'),
            'fill_color'    => ('required_if:unit,' . RateCardUnit::POLYGON_ID . '|size:7|regex:/#[a-zA-Z0-9]{6}/i'),
        ];

        if ($type == 'store' || ($request->get('unit') != $initial_pin->rate_card_unit)) {
            $data['icon'] .= '|required_if:unit,' . RateCardUnit::ITEM_ID;
        }

        $request->validate($data);
    }

    /**
     * Save icon on disk
     * 
     * @param \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile $icon
     * @return string icon name
     */
    protected function storeIcon($icon)
    {
        $icon_name = Str::random() . '.' . $icon->getClientOriginalExtension();
        $icon_path = config('path.images.rate_cards.pins') . "/$icon_name";
        Storage::disk('public')->put($icon_path, $icon->get());

        return $icon_name;
    }

    /**
     * Rate Card pins array for create/edit page select dropdown
     * 
     * @return object
     */
    protected function getRateCardPins()
    {
        return RateCardPin::all()->map(function($pin) {
            return (object) [
                'id'            => $pin->id,
                'text'          => $pin->name,
                'icon'          => $pin->html,
                'visible_for'   => ['unit' => $pin->rate_card_unit],
            ];
        });
    }
}
