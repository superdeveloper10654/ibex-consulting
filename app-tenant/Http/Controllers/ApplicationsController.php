<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Http\Controllers\Resource\Traits\HasComments;
use AppTenant\Models\Activity;
use AppTenant\Models\Application;
use AppTenant\Models\Status\ApplicationStatus;
use AppTenant\Models\Assessment;
use AppTenant\Models\Status\AssessmentStatus;
use AppTenant\Models\Measure;
use AppTenant\Models\Notification;
use AppTenant\Models\RateCard;
use AppTenant\Models\Statical\MediaCollection;
use AppTenant\Models\Statical\Role;
use AppTenant\Models\Contract;
use AppTenant\Models\NotificationSetting;
use AppTenant\Notifications\TeamsNotification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ApplicationsController extends BaseController
{
    use HasComments;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = Application::with(['contract'])->paginate(config('app.pagination_size'));

        return t_view('applications.index', [
            'applications'  => $applications
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
        $measures = Measure::all();
        $rate_cards = RateCard::all();

        return t_view('applications.create', [
            'contracts'     => $contracts,
            'measures'      => $measures,
            'rate_cards'    => $rate_cards,
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
        $this->validateApplication($request);

        $data = [
            'contract_id'   => $request->get('contract_id'),
            'measure_id'    => $request->get('measure_id'),
            'title'         => $request->get('title'),
            'description'   => $request->get('description'),
            'net'           => $request->get('application_net'),
            'items'         => $request->get('items'),
            'period_from'   => $request->get('period_from'),
            'period_to'     => $request->get('period_to'),
            'status'        => $request->get('status_draft', false) ? ApplicationStatus::DRAFT_ID : ApplicationStatus::SUBMITTED_ID,
        ];
        $application = Application::create($data);

        if ($application->status == ApplicationStatus::SUBMITTED_ID) {
            $this->submitAplicationNotifications($application);
            $this->createAssessmentPerApplication($application);
        }

        return $this->jsonSuccess('Application successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $application = Application::with(['contract', 'profile', 'comments.commentator'])->findOrFail($id);
        $files = Media::where('collection_name', MediaCollection::COLLECTION_APPLICATIONS)
            ->where('custom_properties->resource_id', $id)
            ->get();

        return t_view('applications.show', [
            'application'   => $application,
            'files'         => $files,
        ]);
    }

    /**
     * @deprecated
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $application = Application::with(['contract', 'measure'])->findOrFail($id);

        if (!$application->isDraft()) {
            abort(404);
        }

        $contracts = Contract::all();
        $measures = Measure::all();
        $rate_cards = RateCard::all();

        return t_view('applications.edit', [
            'application'   => $application,
            'contracts'     => $contracts,
            'measures'      => $measures,
            'rate_cards'    => $rate_cards,
        ]);
    }

    /**
     * @deprecated
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateApplication($request, 'update');

        $application = Application::findOrFail($request->get('application_id'));

        if (!$application->isDraft()) {
            abort(404);
        }

        $application->contract_id   = $request->get('contract_id');
        $application->net           = $request->get('application_net');
        $application->title         = $request->get('title');
        $application->description   = $request->get('description');
        $application->items         = $request->get('items');
        $application->period_from   = $request->get('period_from');
        $application->period_to     = $request->get('period_to');

        $application->save();

        return $application ? $this->jsonSuccess('Application successfully edited') : $this->jsonError();
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
        $application = Application::findOrFail($id);

        if ($application->isDraft()) {
            $application->status = ApplicationStatus::SUBMITTED_ID;
            $application->update();
            $this->submitAplicationNotifications($application);

            return $this->jsonSuccess('Application status successfully updated');
        }

        return $this->jsonError('Action denied', 403);
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
     * Validates application store/update data
     *
     * @param string $action store|update
     */
    protected function validateApplication(Request $request, $action = 'store')
    {
        if ($action == 'update') {
            $request->validate(['application_id' => 'required|integer|exists:applications,id']);
        }

        $request->validate([
            'contract_id'           => 'required|integer|exists:contracts,id',
            'measure_id'            => 'required|integer|exists:measures,id',
            'title'                 => 'required|string|max:255',
            'description'           => 'required|string|max:5000',
            'period_from'           => 'required|date',
            'period_to'             => 'required|date',
            'application_net'       => [
                'required',
                'numeric',
                'min:0.01',
                'max:99999999',
                function ($attr, $net, $fail) use ($request) {
                    $items = $request->get("items");
                    $net_backend = array_reduce($items, function ($net_backend, $item) {
                        return $net_backend + $item['sum'];
                    }, 0);
                    if ($net_backend != $net) {
                        $fail(__('Application net is not correct'));
                    }
                }
            ],
            'items'                 => 'required|array',
            'items.*.rate_card_id'  => 'required|integer|exists:rate_cards,id',
            'items.*.qty'           => 'required|numeric|min:1|max:999999',
            'items.*.unit'          => 'required|string|max:255',
            'items.*.rate'          => 'required|numeric|min:0.01|max:99999999',
            'items.*.sum'           => [
                'required',
                'numeric',
                'min:0.01',
                'max:99999999',
                function ($attr, $sum, $fail) use ($request) {
                    $i = explode('.', $attr)[1];

                    $rate_card_id = $request->get("items")[$i]['rate_card_id'];
                    $qty = $request->get("items")[$i]['qty'];

                    $rate_card = RateCard::find($rate_card_id);
                    $correct_sum = $rate_card->rate * $qty;

                    if ($correct_sum != $sum) {
                        $fail(__('Sum is not correct'));
                    }
                }
            ]
        ]);
    }

    /**
     * Create notifications about submitted application
     * @param Application $application
     */
    protected function submitAplicationNotifications($application)
    {
        Activity::resource('Submitted', $application, Role::CONTRACTOR_ID);
        Notification::resource('Submitted', $application, Role::CONTRACTOR_ID);

        $notificationSetting =  NotificationSetting::where('name', 'MS Teams Applications Notifications Webhook URL')->whereNotNull('value')->where('status', 1)->first();

        if ($notificationSetting) {
            $user = t_profile();
            $details['content'] = t_profile()->first_name . " " . t_profile()->last_name . " submitted <a href='" . t_route('applications.show', $application->id) . "'>application {$application->id}</a> for {$application->contract->contract_name}";
            $details['webhook_url'] = $notificationSetting->value;
            $details['title'] = 'Applications';
            $details['type'] = 'warning';
            $user->notify(new TeamsNotification($details));
        }
        return;
    }

    /**
     * Create an assessment after submittion application
     * @param Application $application
     * @return Assessment
     */
    protected function createAssessmentPerApplication($application)
    {
        $data = [
            'application_id'    => $application->id,
            'contract_id'       => $application->contract_id,
            'profile_id'        => t_profile()->id,
            'measure_id'        => $application->measure_id,
            'title'             => $application->title,
            'description'       => $application->description,
            'items'             => $application->items,
            'net'               => $application->net,
            'period_from'       => $application->period_from,
            'period_to'         => $application->period_to,
            'status'            => AssessmentStatus::PRIMED_ID,
        ];
        $assessment = Assessment::create($data);

        Activity::resource('Submitted assessment', $assessment, Role::CONTRACTOR_ID);
        Notification::resource('Submitted assessment', $assessment, Role::CONTRACTOR_ID);

        return $assessment;
    }
}
