@extends('tenant.layouts.master')
@section('title')
    @lang('Create Programme')
@endsection
@section('content')
    <x-resource.breadcrumb :resource="\AppTenant\Models\Programme::class" title="Create Programme" />

    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-8">
            <div class="card p-5">
                <div class="card-body">
                    <p class="card-title-desc">Please complete all fields below</p>
                    <form id="create-programme" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="is_draft" value='0' />

                        <div class="row">
                            <div class="col-sm-12">
                                <x-form.select label="Template" name="temp" :options="$programmes->pluck('name', 'id')" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.input label="Name" name="name" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Contract" name="contract" :options="$contracts->pluck('contract_name', 'id')" />
                            </div>
                        </div>
                        <div class="row" id="div_cal">
                            <div class="col-sm-12">
                                <x-form.select id="calendarSel" label="Calendar" name="calendar" :options="$calendars" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="accordion md-accordion" id="accordionTaskCalendarEditor" role="tablist" aria-multiselectable="true">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">General
                                </button>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="card-body pt-0">
                                    <input type="hidden" id="task_calendar_edit_id" value="0">
                                    <div class="form-group">
                                        <label for="calendar_name">Calendar name</label>
                                        <input type="text" name="calendar_name" class="form-control calendar-edit-name" id="task_calendar_edit_name" placeholder="Give this calendar a name" value="Default task calendar">
                                        <span class="text-danger" id="calendarnameErrorMsg" style="color: red"></span>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label for="task_calendar_edit_type">Type</label>
                                        <select class="form-control mdb-select dropdown-primary" id="">
                                            <option value="1" selected>Task calendar</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-3">
                                        <div class="col md-form">
                                            <table style="width: 200px" class="table table-sm">
                                                <tbody>
                                                <tr>
                                                    <td><span>Set as default</span></td>
                                                    <td><input class="form-check-input " type="checkbox" id="task_calendar_edit_default" name="task_calendar_edit_default">
                                                        <label class="form-check-label" for="task_calendar_edit_default" class="label-table"></label>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                Normal Working
                                </button>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                    <div class="card-body pt-0">
                                    <p class="text-muted">Select the normal working days with start and finish times below</p>
                                    <div class="row">
                                        <div class="col md-form">
                                            <label>Weekday</label>
                                            <table class="table table-sm" id="week_days">
                                                <tbody>
                                                <tr>
                                                    <td><span>Monday</span></td>
                                                    <td><input class="form-check-input" id="task_calendar_edit_working_day_monday" name="working_day_monday" type="checkbox">
                                                        <label class="form-check-label" for="task_calendar_edit_working_day_monday" class="label-table"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span>Tuesday</span></td>
                                                    <td><input class="form-check-input" id="task_calendar_edit_working_day_tuesday" name="working_day_tuesday" type="checkbox">
                                                        <label class="form-check-label" for="task_calendar_edit_working_day_tuesday" class="label-table"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span>Wednesday</span></td>
                                                    <td><input class="form-check-input" id="task_calendar_edit_working_day_wednesday" name="working_day_wednesday" type="checkbox">
                                                        <label class="form-check-label" for="task_calendar_edit_working_day_wednesday" class="label-table"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span>Thursday</span></td>
                                                    <td><input class="form-check-input" id="task_calendar_edit_working_day_thursday" name="working_day_thursday" type="checkbox">
                                                        <label class="form-check-label" for="task_calendar_edit_working_day_thursday" class="label-table"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span>Friday</span></td>
                                                    <td><input class="form-check-input" id="task_calendar_edit_working_day_friday" name="working_day_friday" type="checkbox">
                                                        <label class="form-check-label" for="task_calendar_edit_working_day_friday" class="label-table"></label>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col md-form">
                                            <label>Weekend</label>
                                            <table class="table table-sm" id="weekend_days">
                                                <tbody>
                                                <tr>
                                                    <td><span>Saturday</span></td>
                                                    <td><input class="form-check-input" id="task_calendar_edit_working_day_saturday" name="working_day_saturday" type="checkbox">
                                                        <label class="form-check-label" for="task_calendar_edit_working_day_saturday" class="label-table"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span>Sunday</span></td>
                                                    <td><input class="form-check-input" id="task_calendar_edit_working_day_sunday" name="working_day_sunday" type="checkbox">
                                                        <label class="form-check-label" for="task_calendar_edit_working_day_sunday" class="label-table"></label>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-form.timepicker label="Start time" name="task_calendar_edit_start_time" />
                                        </div>
                                        <div class="col-md-6">
                                            <x-form.timepicker label="Finish time" name="task_calendar_edit_end_time" />
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">Overrides  </button>
                                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                    <div class="card-body pt-0">
                                    <p class="text-muted">Select the overriding non-working periods below</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" style="width: 100%">
                                                <x-form.datepicker label="Start date" name="task_calendar_edit_override_start" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" style="width: 100%">
                                                <x-form.datepicker label="Finish date" name="task_calendar_edit_override_end" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" style="width: 100%">
                                                <x-form.datepicker label="Finish date" name="task_calendar_edit_override_end" />
                                            </div>
                                        </div>
{{--                                        <div class="col" style="flex: none; width: 20%;">--}}

                                        <div class="col-md-6">
                                            <div class="form-group mt-3">
                                                <button type="button" class="btn btn-light" onclick="taskAddCalendarOverride(this)">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <table id="table_task_calendar_overrides" class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th style="width: 80%">Dates</th>
                                                <th style="width: 20%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row float-end mt-5 pb-3">
                            <div class="col-6">
                                <button type="button" onclick="saveAsDraft(this)" class="btn btn-secondary btn-rounded w-md waves-effect waves-light">Save Draft</button>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $('#accordionTaskCalendarEditor').hide();
        });
        $('#calendarSel').change(function(){
            if($('#calendarSel').val()=="1"){
                $('#accordionTaskCalendarEditor').show();
            }else{
                $('#accordionTaskCalendarEditor').hide();
            }
        });
        $('#create-programme').on('submit', function(e) {
            e.preventDefault();
            removeFormErrors(this);

            form_ajax('{{ t_route("programmes.store") }}', this, {callback: (res) => {
                let url = "{{ t_route('gantt', '_replace-id_') }}";
                url = url.replace('_replace-id_', res.data);
                window.location.href = url;
            }});
        });

        $('#temp').change(function (e) {
            console.log($('#temp').val());
            if ($('#temp').val() == "") {
                $('#div_cal').show();
            } else {
                $('#div_cal').hide();
                $('#calendarSel').val(0);
            }
        });

    </script>
@endpush
