<?php

namespace AppTenant\Custom;

use AppTenant\Http\Controllers\WorkflowController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route as FacadesRoute;

class Route
{
    /**
     * Initiate workflow routes for specific resource
     * 
     * @param string $resource_name
     * @param int $category from WorkflowCategory
     */
    public static function workflowRoutes($resource_name, $category)
    {
        FacadesRoute::get("/$resource_name/workflow", function() use($category) {
            return App::call("AppTenant\Http\Controllers\WorkflowController@index", ["category_id" => $category]);
        })->name("$resource_name-workflow")->middleware("tenant.can:workflow.browse");
        FacadesRoute::get("/$resource_name/workflow/create", function() use($category) {
            return App::call("AppTenant\Http\Controllers\WorkflowController@edit", ["category_id" => $category]);
        })->name("$resource_name-workflow.create")->middleware("tenant.can:workflow.create");
        FacadesRoute::get("/$resource_name/workflow/edit/{id}", [WorkflowController::class, "edit"])->name("$resource_name-workflow.edit")->middleware("tenant.can:workflow.edit");
        FacadesRoute::get("/$resource_name/workflow/show/{id}", [WorkflowController::class, "show"])->name("$resource_name-workflow.show")->middleware("tenant.can:workflow.show");
        FacadesRoute::any("/$resource_name/workflow/delete/{id}", [WorkflowController::class, "destroy"])->name("$resource_name-workflow.delete")->middleware("tenant.can:workflow.delete");
    }

    /**
     * Create routes for standard CRUD operations + (optional) drafts and comments
     * 
     * @param string $resource_name
     * @param string $controller
     * @param bool $drafts - remove drafts route
     * @param bool $comments - add comments route
     */
    public static function CRUD($resource_name, $controller, $drafts = true, $comments = true)
    {
        FacadesRoute::get("/$resource_name", [$controller, "index"])->name("$resource_name")->middleware("tenant.can:$resource_name.read");
        FacadesRoute::get("/$resource_name/create", [$controller, "create"])->name("$resource_name.create")->middleware("tenant.can:$resource_name.create");
        FacadesRoute::post("/$resource_name/store", [$controller, "store"])->name("$resource_name.store")->middleware("tenant.can:$resource_name.create");
        FacadesRoute::get("/$resource_name/{id}", [$controller, "show"])->name("$resource_name.show")->middleware("tenant.can:$resource_name.read");
        FacadesRoute::get("/$resource_name/{id}/edit", [$controller, "edit"])->name("$resource_name.edit")->middleware("tenant.can:$resource_name.update");
        FacadesRoute::put("/$resource_name/{id}/update", [$controller, "update"])->name("$resource_name.update")->middleware("tenant.can:$resource_name.update");
        FacadesRoute::get("/$resource_name/{id}/remove", [$controller, "destroy"])->name("$resource_name.delete")->middleware("tenant.can:$resource_name.delete");
        
        if ($drafts) {
            FacadesRoute::get("/$resource_name/{id}/remove-draft", [$controller, "destroyDraft"])->name("$resource_name.delete-draft");
        }

        if ($comments) {
            FacadesRoute::post("/$resource_name/{id}/add-comment", [$controller, "addComment"])->name("$resource_name.add-comment")->middleware("tenant.can:$resource_name.read");
        }
    }
}