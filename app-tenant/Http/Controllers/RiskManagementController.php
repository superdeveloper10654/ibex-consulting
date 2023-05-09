<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Http\Controllers\Resource\Traits\HasComments;
use AppTenant\Models\Activity;
use AppTenant\Models\RiskManagement;
use App\Models\Statical\Constant;
use AppTenant\Models\Statical\MediaCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use AppTenant\Models\Statical\RiskManagementType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RiskManagementController extends BaseController
{
    use HasComments;

    public function index()
    {
        $contracts = t_profile()->contracts()->get();
       
        if($contracts->isNotEmpty()) {
            $probability = RiskManagement::withTrashed()
                            ->where('risk_type', RiskManagementType::PLACEHOLDER_FOR_FILES_AND_COMMENTS)
                            ->where('probability', 'DO NOT DELETE')
                            ->first();

            if (empty($probability)) {
                // crunch for files/comments functional
                $probability = RiskManagement::create([
                    'risk_type'     => RiskManagementType::PLACEHOLDER_FOR_FILES_AND_COMMENTS,
                    'probability'   => 'DO NOT DELETE',
                    'from'          => 0,
                    'to'            => 0,
                    'score'         => 0,
                    'impact'        => '',
                    'color'         => '',
                    'severity'      => '',
                ]);
            }

            $files = Media::where('collection_name', MediaCollection::COLLECTION_RISK_MANAGEMENT)
                ->where('custom_properties->resource_id', $probability->id)
                ->get();
                        
            return t_view('risk-management.index', [
                'noData'    => 'no',
                'contracts' => $contracts,
                'files'     => $files,
                'resource'  => $probability
            ]);
        } else {
            return t_view ('risk-management.index',[
                'noData' => 'yes'
            ]);
        }
    }

    public function change(Request $req){
        $req->validate([
            'contract' => 'required'
        ]) ;
        $probability = DB::table('riskmanagement')->where('contract_id',$req->contract)->where('risk_type',0)->select("id","probability","from","to","score")->get();
        $impact = DB::table('riskmanagement')->where('contract_id',$req->contract)->where('risk_type',1)->select("id","impact","score","color")->get();
        $severity = DB::table('riskmanagement')->where('contract_id',$req->contract)->where('risk_type',2)->select("id","severity","score")->get();
        $data = [
            'probability' => $probability,
            'impact' => $impact,
            'severity' => $severity
        ];

        return $this->jsonSuccess('', $data) ;
    }

    public function create(Request $request)
    {
        $this->validatePost($request->all());

        $risk_management = RiskManagement::create([
                'profile_id'    => t_profile()->id,
                "contract_id"   => $request->input('contract'),
                "risk_type"     => $request->input('risk_type'),
                'probability'   => $request->input('probability', ''),
                'from'          => $request->input('from', 1),
                'to'            => $request->input('to', 1),
                'score'         => $request->input('score', 1),
                'impact'        => $request->input('impact', ''),
                'color'         => $request->input('color', ''),
                'severity'      => $request->input('severity', ''),
            ]);

        Activity::add('Initiated Risk Management', t_route('risk-management', [], false), RiskManagement::$activity_icon);

        return $this->jsonSuccess('', [
            'id'    => $risk_management->id,
        ]);
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function update(Request $request)
    {
        $this->validatePost([
            'id'            => $request->id,
            $request->name  => $request->value
        ], Constant::ACTION_UPDATE);

        $risk_management = RiskManagement::findOrFail($request->id);
        $previously_updated_at = $risk_management->updated_at;
        $risk_management->update([$request->name => $request->value]);

        // do not show activity on each update request but only if record was updated more than 3 mins ago
        if ($previously_updated_at->addMinutes(3)->lt(now())) {
            Activity::add('Updated Risks', t_route('risk-management', [], false), RiskManagement::$activity_icon);
        }

        return $this->jsonSuccess();
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy(Request $req)
    {
        $req->validate([
            'id' => 'required|int|exists:riskmanagement,id'
        ]);
        RiskManagement::findOrFail($req->id)->delete();

        return $this->jsonSuccess('Deleted');
    }

    public function validatePost($post, $action = Constant::ACTION_STORE)
    {
        $risk_management_type_ids = implode(',', array_keys(RiskManagementType::getArray(true)));
        $rules = [
            'probability'   => 'string|max:191',
            'from'          => 'int|max:999999',
            'to'            => 'int|max:999999',
            'score'         => 'int|max:999999',
            'impact'        => 'string|max:191',
            'color'         => 'string|max:191',
            'severity'      => 'string|max:191',
        ];

        if ($action == Constant::ACTION_STORE) {
            $rules = array_merge($rules, [
                'contract'  => 'required|exists:contracts,id',
                'risk_type' => 'required|int|in:' . $risk_management_type_ids,
            ]);
        } else if ($action == Constant::ACTION_UPDATE) {
            $rules = array_merge($rules, [
                'id'   => 'required|int|exists:riskmanagement,id',
            ]);
        }

        Validator::make($post, $rules)->validate();
    }
}
