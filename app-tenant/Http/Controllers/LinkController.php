<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use Illuminate\Http\Request;
use DB;

class LinkController extends BaseController
{
    //
    public function generateGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((float)microtime() * 10000);
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $uuid = substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);
            return $uuid;
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'type'      => 'required|int|in:0,1,2,3',
            'source'    => 'required|int|exists:gantt_tasks,id',
            'target'    => 'required|int|exists:gantt_tasks,id',
        ]);

        $insertData = array(
            "type"          => $request->type,
            "source"        => $request->source,
            "target"        => $request->target,
            "created_at"    => date('Y-m-d h:i:s'),
            "updated_at"    => date('Y-m-d h:i:s'),
        );
        $linkId = DB::table('links')->insertGetId($insertData);
        $created = time();
//        $to_finalise = "0";
//        $task_ui_primary = DB::table('gantt_tasks')->where('id',$request->source)->first();
//        $task_ui_secondary = DB::table('gantt_tasks')->where('id',$request->target)->first();
//        $ui_string = "added" . " a dependency between <span>'" . $task_ui_primary->text . "'<span> and <span>'" . $task_ui_secondary->text . "'<span>";
//        $aux_data = "Finish to Start with no lead or lag";
//
//        $values = array('programme_id' => $request->programme_id,'gantt_data'=>$request->gantt_data,'user_id'=>$request->user_id,'created'=>$created,'action'=>'added','type'=>'link','primary_object_guid'=>$task_ui_primary->guid,'secondary_object_guid'=>$task_ui_secondary->guid,'aux_data'=>$aux_data,'guid'=>$this->generateGUID(),'ui_string'=>$ui_string,'to_finalise'=>$to_finalise);
//        $version_id = DB::table('gantt_versions')->insertGetId($values);

        return response()->json([
            "action"=> "inserted",
            "tid" => $linkId,
            "processed" => true,
//            "version_id" => $version_id,
            "save_time" => $created
        ]);
    }


    public function update($id, Request $request)
    {
        $request->validate([
            'type'      => 'required|int|in:0,1,2,3',
            'source'    => 'required|int|exists:gantt_tasks,id',
            'target'    => 'required|int|exists:gantt_tasks,id',
        ]);

        $insertData = array(
            "type"          => $request->type,
            "source"        => $request->source,
            "target"        => $request->target,
            "lag"           => $request->has("lag") ? $request->lag : 0,
            "updated_at"    => date('Y-m-d h:i:s'),
        );

        $linkId = DB::table('links') ->where('id', $id) ->limit(1) ->update($insertData);

        return response()->json([
            "action"=> "updated"
        ]);
    }


    public function destroy($id)
    {
        // $link = \DB::find($id);
        // $link->delete();
        $reqData = DB::table('links')
        ->where('id','=',$id)
        ->delete();

        return response()->json([
            "action"=> "deleted"
        ]);


    }

}
