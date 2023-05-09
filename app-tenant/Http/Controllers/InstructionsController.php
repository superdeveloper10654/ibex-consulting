<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Http\Controllers\Resource\Traits\HasComments;
use AppTenant\Models\Activity;
use AppTenant\Models\Contract;
use AppTenant\Models\Instruction;
use AppTenant\Models\Notification;
use AppTenant\Models\Quotation;
use App\Models\Statical\Constant;
use AppTenant\Models\Statical\MediaCollection;
use AppTenant\Models\Status\InstructionStatus;
use AppTenant\Models\Status\QuotationStatus;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class InstructionsController extends BaseController
{
    use HasComments;
    
    /** @var array patterns */
    protected $patterns = [
        'Day'   => 'Day', 
        'Night' => 'Night'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instructions = Instruction::with('contract')->paginate(config('app.pagination_size'));

        return t_view('instructions.index', [
            'instructions'   => $instructions
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

        if (request()->get('quotation_id')) {
            $quotation = Quotation::findOrFail(request()->get('quotation_id'));
            $selected_contract_id = $quotation->contract->id;
        }

        return t_view('instructions.create', [
            'contracts'             => $contracts,
            'patterns'              => $this->patterns,
            'selected_contract_id'  => $selected_contract_id,
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

        $instruction = Instruction::create([
            'contract_id'   => $request->get('contract'),
            'profile_id'    => t_profile()->id,
            'title'         => $request->get('title'),
            'description'   => $request->get('description'),
            'location'      => '',
            'latitude'      => $request->get('latitude'),
            'longitude'     => $request->get('longitude'),
            'start'         => $request->get('start'),
            'finish'        => $request->get('finish'),
            'duration'      => $request->get('duration'),
            'pattern'       => $request->get('pattern'),
            'status'        => InstructionStatus::ACTIVE_ID,
        ]);

        if ($request->get('quotation_id')) {
            if (!t_profile()->can('quotations.accept-reject')) {
                abort(403);
            }

            $quotation = Quotation::findOrFail($request->quotation_id);
            $quotation->instruction_id = $instruction->id;
            $quotation->status = QuotationStatus::REJECTED_ID;
            $quotation->update();

            Activity::resource('Rejected', $quotation);
            Activity::resource('Submitted', $instruction);
            Notification::resource('Rejected', $quotation);
            Notification::resource('Submitted', $instruction);
        }

        Activity::resource('Submitted', $instruction);
        Notification::resource('Submitted', $instruction);

        return $instruction ? $this->jsonSuccess('Instruction successfully created') : $this->jsonError();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $instruction = Instruction::with(['contract', 'profile', 'comments.commentator'])->findOrFail($id);
        $files = Media::where('collection_name', MediaCollection::COLLECTION_INSTRUCTIONS)
                            ->where('custom_properties->resource_id', $id)
                            ->get();

        return t_view('instructions.show', [
            'instruction'   => $instruction,
            'files'         => $files,
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
        //     "Updated <a href='" . t_route('instructions.show', $instruction->id) ."'>instruction {$instruction->id}</a>", 
        //     Instruction::$activity_icon
        // );
        // Notification::add( replace with ::resource()
        //     "Updated <a href='" . t_route('instructions.show', $instruction->id) ."'>instruction {$instruction->id}</a>", 
        //     Instruction::$activity_icon
        // );
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

    /**
     * Validate request date (store/update)
     * 
     * @param Request $request
     * @param string $action Constant::ACTION_STORE|Constant::ACTION_UPDATE
     * @param Instruction $instruction
     */
    protected function validateRequest($request, $action = Constant::ACTION_STORE, $instruction = null)
    {
        $request->validate([
            'contract'              => 'required|integer|exists:contracts,id',
            'title'                 => 'required|string|max:255',
            'description'           => 'required|string|max:5000',
            'latitude'              => 'required|numeric:max:360',
            'longitude'             => 'required|numeric:max:360',
            'start'                 => 'required|date',
            'finish'                => 'required|date',
            'duration'              => 'required|integer|max:999999',
            'pattern'               => ['required', Rule::in(array_keys($this->patterns))],
        ]);

        if ($action == Constant::ACTION_STORE) {
            if ($request->get('quotation_id')) {
                $acceptable_quotation_ids = Quotation::where('status', QuotationStatus::NOTIFIED_ID)->get()->pluck('id')->implode(',');
                $request->validate(['quotation_id' => "nullable|integer|in:$acceptable_quotation_ids"]);

                // Quotation should have the same contract as the Instruction
                $contract = Contract::findOrFail($request->get('contract'));
                $quotation = Quotation::findOrFail($request->get('quotation_id'));
                
                if ($contract && $quotation && $contract->id != $quotation->contract->id) {
                    throw ValidationException::withMessages(['Quotation Contract and Instruction Contract can not be different']);
                }
            }
        }
    }
}