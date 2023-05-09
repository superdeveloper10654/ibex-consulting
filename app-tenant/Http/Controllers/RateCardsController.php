<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\Contract;
use AppTenant\Models\RateCard;
use AppTenant\Models\RateCardPin;
use AppTenant\Models\Statical\RateCardUnit;
use Illuminate\Http\Request;

class RateCardsController extends BaseController
{
    /**
     * Return specific data by action in json format
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function ajax(Request $request)
    {
        $action = $request->get('action');

        if ($action == 'getList') {
            $contract_id = (int) $request->get('contract_id');
            $rate_cards = RateCard::where('contract_id', $contract_id)->with('pin:id,rate_card_unit,icon,line_color,line_type,fill_color')->get();

            return $this->jsonSuccess('Success', $rate_cards);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rateCards = RateCard::with('pin')->paginate(config('app.pagination_size'));

        return t_view('rate-cards.index', [
            'rateCards'  => $rateCards
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $contracts = Contract::all()->pluck('contract_name', 'id');
        $units = RateCardUnit::getAll();
        $pins = $this->getRateCardPins();
        
        return t_view('rate-cards.create', compact('contracts', 'units', 'pins'));
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
            'contract_id'            => 'required|exists:contracts,id',
            'ref'             => 'required|string|max:255',
            'unit'                 => ('required|in:' . implode(',', array_keys(RateCardUnit::getArray()))),
            'item_desc'                 => 'required',
            'rate' => 'required|numeric',
            'pin_id' => 'required|exists:rate_card_pins,id',
        ]);

        RateCard::create($request->all());

        return $this->jsonSuccess('Rate card created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rateCard = RateCard::findOrFail($id);
        return t_view('rate-cards.show', compact('rateCard'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rateCard = RateCard::with('pin')->findOrFail($id);
        $contracts = Contract::all()->pluck('contract_name', 'id');
        $units = RateCardUnit::getAll();
        $pins = $this->getRateCardPins();

        return t_view('rate-cards.edit', compact('rateCard', 'contracts', 'units', 'pins'));
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
        // @todo add validation here
        $rateCard = RateCard::with('pin')->findOrFail($id);
        $rateCard->update($request->all());
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
        $rateCard = RateCard::with('pin')->findOrFail($id);
        $rateCard->delete();
        return redirect()->route('rate-cards');
    }

    /**
     * Rate Card pins array for create/edit page select dropdown
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
