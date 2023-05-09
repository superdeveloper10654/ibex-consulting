<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\Statical\WorkflowCategory;
use AppTenant\Models\Workflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class WorkflowController extends BaseController
{
    public function index($category_id)
    {
        if (!in_array($category_id, array_keys(WorkflowCategory::getArray(true)))) {
            abort(404);
        }

        $category = WorkflowCategory::get($category_id);
        $rows = Workflow::where('category', $category_id)->latest()->get();
        $route_prefix = Route::currentRouteName();

        return t_view('workflow.list', [
            'category'      => $category,
            'workflows'     => $rows,
            'route_prefix'  => $route_prefix,
        ]);
    }

    public function edit(Request $request, $category_id = '')
    {
        $categories_ids = implode(',', array_keys(WorkflowCategory::getArray(true)));
        $request->validate([
            'id'            => 'integer',
            'category_id'   => 'in:' . $categories_ids,
        ]);

        $route_prefix = str_replace('.edit', '', Route::currentRouteName());
        $row = Workflow::find($request->id);
        $name = '';
        $data = '';
        $id = 0;

        if ($row) {
            $id = $request->id;
            $name = $row->name;
            $data = $row->data;
        }

        return t_view('workflow.edit', [
            'id'            => $id,
            'name'          => $name,
            'data'          => $data,
            'category'      => $category_id,
            'route_prefix'  => $route_prefix
        ]);
    }

    public function show(Request $request, $id)
    {
        $workflow = Workflow::findOrFail($id);
        $route_prefix = str_replace('.show', '', Route::currentRouteName());

        return t_view('workflow.show', compact('workflow', 'route_prefix'));
    }

    public function store(Request $request)
    {
        $this->validateStoreRequest($request);

        $params  = $request->all();
        $where = Workflow::where('id', '=', $params['id']);
        $id = $params['id'];

        if ($where->exists()) {
            $where->update(['name' => $params['name'], 'data' => json_encode($params['data'])]);
        } else {
            $workflow = new Workflow;
            $workflow->name = $params['name'];
            $workflow->category = !empty($params['category']) ? $params['category'] : WorkflowCategory::OPERATIONS_ID;
            $workflow->data = json_encode($params['data']);
            $workflow->save();
            $id = $workflow->id;
        }
        return $id;
    }

    public function destroy(Request $request, $id)
    {
        Workflow::findOrFail($id)->delete();

        return redirect()->back();
    }

    protected function validateStoreRequest(Request $request)
    {
        $categories_ids = implode(',', array_keys(WorkflowCategory::getArray(true)));
        Validator::make($request->all(), [
            'id'        => 'integer',
            'name'      => 'required|string|max:191',
            'category'  => "required|in:$categories_ids",
            'data'      => 'required|required_array_keys:class,nodeDataArray',
        ], [
            'data.required_array_keys'  => 'Please place at least one element'
        ])->validate();
    }
}
