<?php

declare(strict_types=1);

/**
 * Routes accessible only for Paid subscription accessible here
 */

use AppTenant\Custom\Route as CustomRoute;
use AppTenant\Http\Controllers\ApplicationsController;
use AppTenant\Http\Controllers\AssessmentsController;
use AppTenant\Http\Controllers\InstructionsController;
use AppTenant\Http\Controllers\MeasuresController;
use AppTenant\Http\Controllers\PaymentsController;
use AppTenant\Http\Controllers\QualityAndDefectsController;
use AppTenant\Http\Controllers\RateCardsController;
use AppTenant\Http\Controllers\SnagsAndDefectsController;
use AppTenant\Http\Controllers\TestsAndInspectionsController;
use AppTenant\Http\Controllers\CompensationEventNoticesController;
use AppTenant\Http\Controllers\DailyWorkRecordController;
use AppTenant\Http\Controllers\DirectPersonnelController;
use AppTenant\Http\Controllers\SubcontractPersonnelController;
use AppTenant\Http\Controllers\DirectVehiclesAndPlantsController;
use AppTenant\Http\Controllers\SubcontractVehicleAndPlantsController;
use AppTenant\Http\Controllers\MaterialsController;
use AppTenant\Http\Controllers\NotificationSettingsController;
use AppTenant\Http\Controllers\OperationsController;
use AppTenant\Http\Controllers\RateCardPinsController;
use AppTenant\Http\Controllers\ResourceRecordsController;
use AppTenant\Http\Controllers\SettingsController;
use AppTenant\Http\Controllers\SubcontractOperationsController;
use AppTenant\Http\Controllers\TaskController;
use AppTenant\Models\Statical\WorkflowCategory;
use Illuminate\Support\Facades\Route;

CustomRoute::CRUD('applications', ApplicationsController::class, false);
Route::post('/applications/{id}/update-status', [ApplicationsController::class, 'updateStatus'])->name('applications.update-status')->middleware('tenant.can:applications.update-status');

CustomRoute::CRUD('assessments', AssessmentsController::class, false);
Route::post('/assessments/{id}/update-status', [AssessmentsController::class, 'updateStatus'])->name('assessments.update-status')->middleware('tenant.can:assessments.update-status');

Route::get('/compensation-events-notification', [CompensationEventNoticesController::class, 'index'])->name('compensation-events-notification')->middleware('tenant.can:compensation-events-notification.read');
Route::post('/compensation-events-notification/create', [CompensationEventNoticesController::class, "create"])->name('compensation-events-notification.create')->middleware('tenant.can:compensation-events-notification.create');
Route::get('/compensation-events-notification/pending', [CompensationEventNoticesController::class, "pending"])->name('compensation-events-notification.pending')->middleware('tenant.can:compensation-events-notification.read');

Route::get('/daily-work-records', [DailyWorkRecordController::class, 'index'])->name('daily-work-records')->middleware('tenant.can:work-records.browse');
Route::get('/daily-work-records/create', [DailyWorkRecordController::class, 'create'])->name('daily-work-records.create')->middleware('tenant.can:work-records.create');
Route::post('/daily-work-records/store', [DailyWorkRecordController::class, 'store'])->name('daily-work-records.store')->middleware('tenant.can:work-records.store');
Route::get('/daily-work-records/{id}/edit', [DailyWorkRecordController::class, 'edit'])->name('daily-work-records.edit')->middleware('tenant.can:work-records.edit');

Route::middleware('tenant.can:work-records.show')->group(function () {
    Route::get('/daily-work-records/{id}', [DailyWorkRecordController::class, 'show'])->name('daily-work-records.show');
    Route::get('/daily-work-records/{id}/step2', [DailyWorkRecordController::class, 'step2'])->name('daily-work-records.step2');
    Route::get('/daily-work-records/{id}/step3', [DailyWorkRecordController::class, 'step3'])->name('daily-work-records.step3');
    Route::get('/daily-work-records/{id}/step4', [DailyWorkRecordController::class, 'step4'])->name('daily-work-records.step4');
    Route::get('/daily-work-records/{id}/step5', [DailyWorkRecordController::class, 'step5'])->name('daily-work-records.step5');
});

Route::middleware('tenant.can:work-records.update')->group(function () {
    Route::put('/daily-work-records/{id}/update', [DailyWorkRecordController::class, 'update'])->name('daily-work-records.update');
    Route::put('/daily-work-records/{id}/updateStep2', [DailyWorkRecordController::class, 'updateStep2'])->name('daily-work-records.updateStep2');
    Route::put('/daily-work-records/{id}/updateStep3', [DailyWorkRecordController::class, 'updateStep3'])->name('daily-work-records.updateStep3');
    Route::put('/daily-work-records/{id}/updateStep4', [DailyWorkRecordController::class, 'updateStep4'])->name('daily-work-records.updateStep4');
    Route::put('/daily-work-records/{id}/updateStep5', [DailyWorkRecordController::class, 'updateStep5'])->name('daily-work-records.updateStep5');
});

/* Gantt Kanban START */
Route::get('/addkanbantask/{id}', [TaskController::class, 'addNewKanbanTask'])->name('addkanbantask')->middleware('tenant.can:programmes.create');
Route::get('/sub-tasks/{id}', [TaskController::class, 'getTaskDetails'])->name('getSubTasks')->middleware('tenant.can:programmes.read');
Route::post('/tasks-kanban/{id}/update-assignees', [TaskController::class, 'updateAssignees'])->name('update-assignees')->middleware('tenant.can:programmes.update');
Route::post('/tasks-kanban/{id}/update-attribute', [TaskController::class, 'updateTaskAttribute'])->name('updateTaskAttribute')->middleware('tenant.can:programmes.update');
Route::post('/tasks-kanban/{id}/delete', [TaskController::class, 'destroy'])->name('task.delete')->middleware('tenant.can:programmes.delete');
/* Gantt Kanban END */

CustomRoute::CRUD('instructions', InstructionsController::class, false);

CustomRoute::CRUD('measures', MeasuresController::class, false);
Route::post('/measures/{id}/update-status', [MeasuresController::class, 'updateStatus'])->name('measures.update-status')->middleware('tenant.can:measures.update-status');
Route::post('/measures/ajax', [MeasuresController::class, 'ajax'])->name('measures.ajax')->middleware('tenant.can:measures.ajax');

Route::get('/resource-records', [ResourceRecordsController::class, 'index'])->name('resource-records');

Route::middleware('tenant.can:resources.create')->group(function () {
    Route::get('/direct-personnel/create', [DirectPersonnelController::class, 'create'])->name('direct-personnel.create');
    Route::post('/direct-personnel/store', [DirectPersonnelController::class, 'store'])->name('direct-personnel.store');
    Route::get('/subcontract-personnel/create', [SubcontractPersonnelController::class, 'create'])->name('subcontract-personnel.create');
    Route::post('/subcontract-personnel/store', [SubcontractPersonnelController::class, 'store'])->name('subcontract-personnel.store');
    Route::get('/direct-vehicles-plants/create', [DirectVehiclesAndPlantsController::class, 'create'])->name('direct-vehicles-plants.create');
    Route::post('/direct-vehicles-plants/store', [DirectVehiclesAndPlantsController::class, 'store'])->name('direct-vehicles-plants.store');
    Route::get('/subcontract_or_hired-vehiles-plants/create', [SubcontractVehicleAndPlantsController::class, 'create'])->name('subcontract_or_hired-vehicles-plants.create');
    Route::post('/subcontract_or_hired-vehiles-plants/store', [SubcontractVehicleAndPlantsController::class, 'store'])->name('subcontract_or_hired-vehicles-plants.store');
    Route::get('/materials/create', [MaterialsController::class, 'create'])->name('materials.create');
    Route::post('/materials/store', [MaterialsController::class, 'store'])->name('materials.store');
    Route::get('/subcontract_or_client-operations/create', [SubcontractOperationsController::class, 'create'])->name('subcontract_or_client-operations.create');
    Route::post('/subcontract_or_client-operations/store', [SubcontractOperationsController::class, 'store'])->name('subcontract_or_client-operations.store');
});
Route::middleware('tenant.can:resources.update')->group(function () {
    Route::get('/direct-personnel/{id}/edit', [DirectPersonnelController::class, 'edit'])->name('direct-personnel.edit');
    Route::post('/direct-personnel/{id}/update', [DirectPersonnelController::class, 'update'])->name('direct-personnel.update');
    Route::get('/subcontract-personnel/{id}/edit', [SubcontractPersonnelController::class, 'edit'])->name('subcontract-personnel.edit');
    Route::post('/subcontract-personnel/{id}/update', [SubcontractPersonnelController::class, 'update'])->name('subcontract-personnel.update');
    Route::get('/direct-vehicles-plants/{id}/edit', [DirectVehiclesAndPlantsController::class, 'edit'])->name('direct-vehicles-plants.edit');
    Route::post('/direct-vehicles-plants/{id}/update', [DirectVehiclesAndPlantsController::class, 'update'])->name('direct-vehicles-plants.update');
    Route::get('/subcontract_or_hired-vehicles-plants/{id}/edit', [SubcontractVehicleAndPlantsController::class, 'edit'])->name('subcontract_or_hired-vehicles-plants.edit');
    Route::post('/subcontract_or_hired-vehicles-plants/{id}/update', [SubcontractVehicleAndPlantsController::class, 'update'])->name('subcontract_or_hired-vehicles-plants.update');
    Route::get('/materials/{id}/edit', [MaterialsController::class, 'edit'])->name('materials.edit');
    Route::post('/materials/{id}/update', [MaterialsController::class, 'update'])->name('materials.update');
    Route::get('/subcontract_or_client-operations/{id}/edit', [SubcontractOperationsController::class, 'edit'])->name('subcontract_or_client-operations.edit');
    Route::post('/subcontract_or_client-operations/{id}/update', [SubcontractOperationsController::class, 'update'])->name('subcontract_or_client-operations.update');
});
Route::middleware('tenant.can:resources.read')->group(function () {
    Route::get('/direct-personnel', [DirectPersonnelController::class, 'index'])->name('direct-personnel');
    Route::get('/direct-personnel/{id}', [DirectPersonnelController::class, 'show'])->name('direct-personnel.show');
    Route::get('/subcontract-personnel', [SubcontractPersonnelController::class, 'index'])->name('subcontract-personnel');
    Route::get('/subcontract-personnel/{id}', [SubcontractPersonnelController::class, 'show'])->name('subcontract-personnel.show');
    Route::get('/direct-vehicles-plants', [DirectVehiclesAndPlantsController::class, 'index'])->name('direct-vehicles-plants');
    Route::get('/direct-vehicles-plants/{id}', [DirectVehiclesAndPlantsController::class, 'show'])->name('direct-vehicles-plants.show');
    Route::get('/subcontract_or_hired-vehiles-plants', [SubcontractVehicleAndPlantsController::class, 'index'])->name('subcontract_or_hired-vehicles-plants');
    Route::get('/subcontract_or_hired-vehiles-plants/{id}', [SubcontractVehicleAndPlantsController::class, 'show'])->name('subcontract_or_hired-vehicles-plants.show');
    Route::get('/materials', [MaterialsController::class, 'index'])->name('materials');
    Route::get('/materials/{id}', [MaterialsController::class, 'show'])->name('materials.show');
    Route::get('/subcontract_or_client-operations', [SubcontractOperationsController::class, 'index'])->name('subcontract_or_client-operations');
    Route::get('/subcontract_or_client-operations/{id}', [SubcontractOperationsController::class, 'show'])->name('subcontract_or_client-operations.show');
});
Route::middleware('tenant.can:resources.delete')->group(function () {
});

CustomRoute::CRUD('operations', OperationsController::class, false, false);

CustomRoute::workflowRoutes('payments', WorkflowCategory::PAYMENTS_ID);
CustomRoute::CRUD('payments', PaymentsController::class, false, false);
Route::get('/payment-certificates', [PaymentsController::class, 'index'])->name('payment-certificates')->middleware('tenant.can:payment-certificates.browse');

CustomRoute::workflowRoutes('quality-and-defects', WorkflowCategory::QUALITY_CONTROL_ID);
Route::get('/quality-and-defects', [QualityAndDefectsController::class, 'index'])->name('quality-and-defects')->middleware('tenant.can:quality-and-defects.browse');

Route::get('/snags-and-defects', [SnagsAndDefectsController::class, 'index'])->name('snags-and-defects')->middleware('tenant.can:snags-and-defects.browse');
Route::post('/snags-and-defects/{id}/add-comment', [SnagsAndDefectsController::class, 'addComment'])->name('snags-and-defects.add-comment')->middleware('tenant.can:snags-and-defects.add-comment');

Route::get('/tests-and-inspections', [TestsAndInspectionsController::class, 'index'])->name('tests-and-inspections')->middleware('tenant.can:tests-and-inspections.browse');
Route::get('/tests-and-inspections/{id}/add-comment', [TestsAndInspectionsController::class, 'addComment'])->name('tests-and-inspections.add-comment')->middleware('tenant.can:tests-and-inspections.add-comment');

CustomRoute::CRUD('rate-cards', RateCardsController::class, false, false);
Route::post('/rate-cards/ajax', [RateCardsController::class, 'ajax'])->name('rate-cards.ajax')->middleware('tenant.can:rate-cards.ajax');

Route::get('notification-settings', [NotificationSettingsController::class, 'index'])->name('notification-settings')->can('notification-settings.browse');
Route::get('notification-settings/{id}/edit', [NotificationSettingsController::class, 'edit'])->name('notification-settings.edit')->can('notification-settings.edit');
Route::put('notification-settings/{id}', [NotificationSettingsController::class, 'update'])->name('notification-settings.update')->can('notification-settings.update');

CustomRoute::CRUD('rate-card-pins', RateCardPinsController::class, false, false);

Route::get('settings', [SettingsController::class, 'index'])->name('settings')->can('settings-manage');
Route::put('settings/update', [SettingsController::class, 'update'])->name('settings.update')->can('settings-manage');