<?php

declare(strict_types=1);

/**
 * Routes accessible for both Demo and Paid subscription accessible here
 */

use AppTenant\Custom\Route as CustomRoute;
use AppTenant\Http\Controllers\ActivitiesController;
use AppTenant\Http\Controllers\ContractsController;
use AppTenant\Http\Controllers\DashboardController;
use AppTenant\Http\Controllers\EarlyWarningsController;
use AppTenant\Http\Controllers\ProfilesController;
use AppTenant\Http\Controllers\UploadsController;
use AppTenant\Http\Controllers\GanttController;
use AppTenant\Http\Controllers\UserProgrammeLinkController;
use AppTenant\Http\Controllers\GanttColumnController;
use AppTenant\Http\Controllers\CalendarController;
use AppTenant\Http\Controllers\CalendarOverrideController;
use AppTenant\Http\Controllers\CompensationEventsController;
use AppTenant\Http\Controllers\ContractApplicationController;
use AppTenant\Http\Controllers\ProgrammesController;
use AppTenant\Http\Controllers\MitigationsController;
use AppTenant\Http\Controllers\NotificationsController;
use AppTenant\Http\Controllers\QuotationsController;
use AppTenant\Http\Controllers\TaskController;
use AppTenant\Http\Controllers\WorkflowController;
use AppTenant\Http\Controllers\RiskManagementController;
use App\Models\Statical\Constant;
use AppTenant\Models\Statical\WorkflowCategory;
use AppTenant\Http\Controllers\UsersController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Redirect::route('dashboard');
})->name('root');

Route::get('/terms', function(){
    return view('auth.terms');
})->name('page.terms');

Route::post('/activities/load-previous', [ActivitiesController::class, 'loadPrevious'])->name('activities.load-previous');

CustomRoute::workflowRoutes('compensation-events', WorkflowCategory::COMPENSATION_EVENTS_ID);
CustomRoute::CRUD('compensation-events', CompensationEventsController::class);
Route::get('/compensation-events/{id}/notify', [CompensationEventsController::class, 'notify'])->name('compensation-events.notify')->middleware('tenant.can:compensation-events.create');

Route::get('/contracts', [ContractsController::class, 'index'])->name('contracts')->middleware('tenant.can:contracts.read');
Route::get('/contracts/create', [ContractsController::class, 'create'])->name('contracts.create')->middleware('tenant.can:contracts.create');
Route::post('/contracts/store', [ContractsController::class, 'store'])->name('contracts.store')->middleware('tenant.can:contracts.create');
Route::get('/contracts/{id}/edit', [ContractsController::class, 'edit'])->name('contracts.edit')->middleware('tenant.can:contracts.update');
Route::post('/contracts/{id}/add-comment', [ContractsController::class, 'addComment'])->name('contracts.add-comment')->middleware('tenant.can:contracts.read');

 //contract step form routing
 Route::middleware('tenant.can:contracts.read')->group(function () {
    Route::get('/contracts/{id}', [ContractsController::class, 'show'])->name('contracts.show');
    Route::get('/contracts/{id}/step2', [ContractApplicationController::class, 'viewStep2'])->name('contracts-step2-view');
    Route::get('/contracts/{id}/step3', [ContractApplicationController::class, 'viewStep3'])->name('contracts-step3-view');
    Route::get('/contracts/{id}/step4', [ContractApplicationController::class, 'viewStep4'])->name('contracts-step4-view');
    Route::get('/contracts/{id}/step5', [ContractApplicationController::class, 'viewStep5'])->name('contracts-step5-view');
    Route::get('/contracts/{id}/step6', [ContractApplicationController::class, 'viewStep6'])->name('contracts-step6-view');
    Route::get('/contracts/{id}/step7', [ContractApplicationController::class, 'viewStep7'])->name('contracts-step7-view');
    Route::get('/contracts/{id}/step8', [ContractApplicationController::class, 'viewStep8'])->name('contracts-step8-view');
    Route::get('/contracts/{id}/step9', [ContractApplicationController::class, 'viewStep9'])->name('contracts-step9-view');
    Route::get('/contracts/{id}/step10', [ContractApplicationController::class, 'viewStep10'])->name('contracts-step10-view');
    Route::get('/contracts/{id}/step11', [ContractApplicationController::class, 'viewStep11'])->name('contracts-step11-view');
    Route::get('/contracts/{id}/dates-history-modal/{date_type}', [ContractsController::class, 'dates_history_modal'])->name('contracts.dates_history_modal');
});
Route::middleware('tenant.can:contracts.update')->group(function () {
    Route::put('/contracts/{id}/update', [ContractsController::class, 'update'])->name('contracts.update');
    Route::put('/contracts/{id}/step2/update', [ContractApplicationController::class, 'updateStep2'])->name('contracts-step2-update');
    Route::put('/contracts/{id}/step3/update', [ContractApplicationController::class, 'updateStep3'])->name('contracts-step3-update');
    Route::put('/contracts/{id}/step4/update', [ContractApplicationController::class, 'updateStep4'])->name('contracts-step4-update');
    Route::put('/contracts/{id}/step5/update', [ContractApplicationController::class, 'updateStep5'])->name('contracts-step5-update');
    Route::put('/contracts/{id}/step6/update', [ContractApplicationController::class, 'updateStep6'])->name('contracts-step6-update');
    Route::put('/contracts/{id}/step7/update', [ContractApplicationController::class, 'updateStep7'])->name('contracts-step7-update');
    Route::put('/contracts/{id}/step8/update', [ContractApplicationController::class, 'updateStep8'])->name('contracts-step8-update');
    Route::put('/contracts/{id}/step9/update', [ContractApplicationController::class, 'updateStep9'])->name('contracts-step9-update');
    Route::put('/contracts/{id}/step10/update', [ContractApplicationController::class, 'updateStep10'])->name('contracts-step10-update');
    Route::put('/contracts/{id}/step11/update', [ContractApplicationController::class, 'updateStep11'])->name('contracts-step11-update');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

CustomRoute::CRUD('early-warnings', EarlyWarningsController::class);
Route::get('/early-warnings/{id}/close', [EarlyWarningsController::class, 'close'])->name('early-warnings.close')->middleware('tenant.can:early-warnings.close');
Route::get('/early-warnings/{id}/escalate', [EarlyWarningsController::class, 'escalate'])->name('early-warnings.escalate')->middleware('tenant.can:early-warnings.escalate');
Route::get('/early-warnings/{id}/notify', [EarlyWarningsController::class, 'notify'])->name('early-warnings.notify')->middleware('tenant.can:early-warnings.notify');

CustomRoute::CRUD('mitigations', MitigationsController::class);
Route::get('/mitigations/{id}/close', [MitigationsController::class, 'close'])->name('mitigations.close')->middleware('tenant.can:mitigations.update');
Route::get('/mitigations/{id}/notify', [MitigationsController::class, 'notify'])->name('mitigations.notify')->middleware('tenant.can:mitigations.update');

Route::post('/notifications/dismiss', [NotificationsController::class, 'dismiss'])->name('notifications.dismiss');

Route::get('/profiles/' . Constant::ME . '/edit', function () {
    return App::call('AppTenant\Http\Controllers\ProfilesController@edit', ['id' => Constant::ME]);
})->name('profiles.edit.me');
Route::put('/profiles/' . Constant::ME . '/update', function () {
    return App::call('AppTenant\Http\Controllers\ProfilesController@update', ['id' => Constant::ME]);
})->name('profiles.update.me');
Route::get("/profiles/create-subcontractor/{contractor_id}", [ProfilesController::class, "createSubcontractor"])->name("profiles.create-subcontractor")->middleware("tenant.can:profiles.create");
Route::post('/profiles/' . Constant::ME . '/update-password', [ProfilesController::class, 'updatePassword'])->name('profiles.update-password');
CustomRoute::CRUD('profiles', ProfilesController::class, false, false);

CustomRoute::workflowRoutes('operations', WorkflowCategory::OPERATIONS_ID);

/* Gantt routes START */
CustomRoute::CRUD('programmes', ProgrammesController::class);
Route::get('/programmes/{id}/submit', [ProgrammesController::class, 'submit'])->name('programmes.submit')->middleware('tenant.can:programmes.update');
Route::get('/programmes/{id}/accept', [ProgrammesController::class, 'accept'])->name('programmes.accept')->middleware('tenant.can:programmes.accept-reject');
Route::get('/programmes/{id}/reject', [ProgrammesController::class, 'reject'])->name('programmes.reject')->middleware('tenant.can:programmes.accept-reject');

Route::middleware('tenant.can:programmes.read')->group(function() {
    Route::get('/programmes/gantt/{id}', [GanttController::class, 'show'])->name('gantt');
    Route::post('/GetResources', [GanttController::class, 'getresources'])->name('GetResources');
    Route::post('/get_activity', [GanttController::class, 'getactivity'])->name('get_activity');
    Route::get('/get-photos', [GanttController::class, 'GetPhotos'])->name('get-photos');
    Route::get('/get-date-range', [UserProgrammeLinkController::class, 'index'])->name('get-date-range');
    Route::post('/get_task_locks', [ProfilesController::class, 'get_task_locks'])->name('get_task_locks');
    Route::post('/reload_gantt', [CalendarController::class, 'reload_gantt'])->name('reload_gantt');
});

Route::middleware('tenant.can:programmes.update')->group(function() {
    Route::post('/task/{id}', [TaskController::class, 'save'])->name('task.save');
    Route::delete('/task/{id}', [TaskController::class, 'delete'])->name('task.remove');

    Route::post('/create-group', [GanttController::class, 'SaveGroup'])->name('create-group');
    Route::post('/edit-group', [GanttController::class, 'EditGroup'])->name('edit-group');
    Route::post('/delete-group', [GanttController::class, 'DeleteGroup'])->name('delete-group');
    Route::post('/photo-uploads', [GanttController::class, 'PhotoUpload'])->name("photo-uploads");
    Route::post('/delete-image', [GanttController::class, 'DeleteImage'])->name("delete-image");
    Route::post('/create-resources-item', [GanttController::class, 'createresourceitem'])->name('create-resources-item');
    Route::post('/edit-resource-item', [GanttController::class, 'Editresource'])->name('edit-resource-item');
    Route::post('/set-date-range', [UserProgrammeLinkController::class, 'store'])->name('set-date-range');
    Route::post('/save-task-columns', [GanttColumnController::class, 'store'])->name('save-task-columns');
    Route::post('/save_task_calendar', [CalendarController::class, 'store'])->name('save_task_calendar');
    Route::post('/add_task_calendar_override', [CalendarOverrideController::class, 'store'])->name('add_task_calendar_override');
    Route::post('/delete_calendar_override', [CalendarOverrideController::class, 'destroy'])->name('delete_calendar_override');
    Route::post('/save_resource_calendar', [CalendarController::class, 'save_resource_calendar'])->name('save_resource_calendar');
    Route::post('/delete_calendar', [CalendarController::class, 'destroy'])->name('delete_calendar');
    Route::post('/inflight_progress_update', [GanttController::class, 'inflight_progress_update'])->name('inflight_progress_update');
    Route::post('/snapshot_gantt', [GanttController::class, 'snapshot_gantt'])->name('snapshot_gantt');
    Route::post('/set_ui_order', [GanttController::class, 'set_ui_order'])->name('set_ui_order');
    Route::post('/save-resource-columns', [GanttColumnController::class, 'storeresourcecolumns'])->name('save-resource-columns');
    Route::post('/delete_task', [GanttController::class, 'deletetask'])->name('delete_task');
    Route::post('/rollbackActivity', [GanttController::class, 'rollbackactivity'])->name('rollbackActivity');
    Route::post('/programme/{id}/gantt/import-tasks-from-microsoft-project', [TaskController::class, 'importTasksFromMicrosoftProject'])->name('programmes.gantt.import-tasks-from-microsoft-project');
});
/* Gantt routes END */

CustomRoute::CRUD('quotations', QuotationsController::class);
Route::get('/quotations/{id}/notify', [QuotationsController::class, 'notify'])->name('quotations.notify')->middleware('tenant.can:quotations.update');
Route::get('/quotations/{id}/accept', [QuotationsController::class, 'accept'])->name('quotations.accept')->middleware('tenant.can:quotations.accept-reject');
Route::get('/quotations/{id}/reject', [QuotationsController::class, 'reject'])->name('quotations.reject')->middleware('tenant.can:quotations.accept-reject');

CustomRoute::workflowRoutes('risk-management', WorkflowCategory::RISK_MANAGEMENT_ID);
// CustomRoute::CRUD()
Route::get('/risk-management', [RiskManagementController::class, 'index'])->name('risk-management')->middleware('tenant.can:risk-management.read');
Route::post('/risk-management/change', [RiskManagementController::class, "change"])->name('risk-management.change')->middleware('tenant.can:risk-management.update');
Route::post('/risk-management/create', [RiskManagementController::class, 'create'])->name('risk-management.create')->middleware('tenant.can:risk-management.create');
Route::post('/risk-management/update', [RiskManagementController::class, 'update'])->name('risk-management.update')->middleware('tenant.can:risk-management.update');
Route::post('/risk-management/remove', [RiskManagementController::class, 'destroy'])->name('risk-management.remove')->middleware('tenant.can:risk-management.delete');
Route::post("/risk-management/{id}/add-comment", [RiskManagementController::class, "addComment"])->name("risk-management.add-comment")->middleware("tenant.can:risk-management.read");

Route::get('/uploads', [UploadsController::class, 'index'])->name('uploads')->middleware('tenant.can:uploads.browse');
Route::get('/uploads?folder={folder}', [UploadsController::class, 'index'])->name('uploads.folder')->middleware('tenant.can:uploads.browse');
Route::post('/uploads/files-ajax', [UploadsController::class, 'filesAjax'])->name('uploads.files-ajax')->middleware('tenant.can:uploads.files-ajax');
Route::post('/uploads/file-rename', [UploadsController::class, 'fileRename'])->name('uploads.file-rename')->middleware('tenant.can:uploads.file-rename');
Route::post('/uploads/store', [UploadsController::class, 'store'])->name('uploads.store')->middleware('tenant.can:uploads.store');
Route::post('/uploads/create-folder', [UploadsController::class, 'createFolder'])->name('uploads.create-folder')->middleware('tenant.can:uploads.create-folder');
Route::post('/uploads/remove-folder', [UploadsController::class, 'removeFolder'])->name('uploads.remove-folder')->middleware('tenant.can:uploads.remove-folder');
Route::post('/uploads/rename-folder', [UploadsController::class, 'renameFolder'])->name('uploads.rename-folder')->middleware('tenant.can:uploads.rename-folder');
Route::post('/uploads/remove', [UploadsController::class, 'destroy'])->name('uploads.remove')->middleware('tenant.can:uploads.remove');
Route::get('/uploads/{id}/download', [UploadsController::class, 'download'])->name('uploads.download')->middleware('tenant.can:uploads.download');

CustomRoute::CRUD('users', UsersController::class, false, false);
Route::get('/users/{id}/unsubscribe', [UsersController::class, 'unsubscribe'])->name('users.unsubscribe')->middleware('tenant.can:users.unsubscribe');

CustomRoute::CRUD('workflow', WorkflowController::class, false, false);