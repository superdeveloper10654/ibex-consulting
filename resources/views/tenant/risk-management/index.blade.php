@extends('tenant.layouts.master')

@section('title')
    @lang('Risk Management | Settings')
@endsection

@push('css')
    <style>
        .anolyze_table tr td {
            border: 1px solid #fff;
            height: 50px;
            text-align: center;
            width: 50px;
        }

        .add_probability {
            cursor: pointer;
        }

        .add_impact {
            cursor: pointer;
        }

        .add_severity {
            cursor: pointer;
        }

        .delete_icon {
            cursor: pointer;
        }

        .delete_icon:hover {
            font-size: small;
        }

        .text-transform {
            left: -20px;
            height: 0px;
            font-size: 12px;
            font-weight: 600;
            transform: rotate(-90deg);
            width: 5px;
            white-space: nowrap;
            display: flex;
            justify-content: center;
            top: 53px;
        }

        .card_head {
            box-sizing: border-box;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            font-size: 15px;
        }
    </style>
@endpush

@section('content')
    @component('components.breadcrumb')
        @slot('li_1_link') {{ t_route('risk-management') }} @endslot
        @slot('li_1') Risk Management @endslot
        @slot('title') Risk Settings @endslot
    @endcomponent

    <div class="row justify-content-center">
        <div class="left-col col-md-8">
            <div class="header-wrapper d-flex justify-content-between d-print-none">
                <x-resource-page.button.expand />
            </div>
            <div class="card p-2 p-xl-3 p-xxl-4 print-no-break">
                <div class="card-body">
                    <h4 class="card-title">Contract</h4>
                    <p class="card-title-desc mt-4 mb-2 d-print-none">Please select the contract</p>
                    <div class="row">
                        <div class="col-md-6">
                            <x-form.select name="contract"
                                :options="$contracts->pluck('contract_name', 'id')"
                            />
                        </div>
                        <div class="col-md-12 pt-5">
                            <h4 class="card-title">Risk Matrix</h4>
                            <div class="table-responsive">
                                <table class="table align-middle table-borderless">
                                    <tbody class="risk-matrix-body"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card p-2 p-xl-3 p-xxl-4">
                <div class="card-body">
                    <h6 class="card-subtitle font-14 text-muted mb-3">Risk Evaluation</h6>
                    <div class="col-md-12 pt-3 pb-3 mb-3 print-no-break">
                        <h4 class="card-title">Likelihood</h4>
                        <div class="table-responsive">
                            <table class="table align-middle table-hover table-borderless probability_table">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 50%">Title</th>
                                        <th scope="col">Min %</th>
                                        <th scope="col">Max %</th>
                                        <th scope="col">Value</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-sm btn-light add_probability d-print-none" style="width: 110px"><i
                                class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
                    </div>
                    <div class="col-md-12 pt-3 pb-3 mb-3 print-no-break">
                        <h4 class="card-title">Consequence</h4>
                        <div class="table-responsive">
                            <table class="table align-middle table-hover table-borderless severity_table">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 50%">Title</th>
                                        <th scope="col">Value</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-sm btn-light add_severity d-print-none" style="width: 110px">
                            <i class="mdi mdi-plus me-1"></i>&nbsp;Add Row
                        </button>
                    </div>
                    <div class="col-md-12 pt-3 pb-3 mb-3 print-no-break">
                        <h4 class="card-title">Impact</h4>
                        <div class="table-responsive">
                            <table class="table align-middle table-hover table-borderless impact_table">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 50%">Title</th>
                                        <th scope="col">Min Value</th>
                                        <th scope="col">Colour</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-sm btn-light add_impact d-print-none" style="width: 110px">
                            <i class="mdi mdi-plus me-1"></i>&nbsp;Add Row
                        </button>
                    </div>
                    <div class="d-print-none">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-secondary btn-rounded w-md waves-effect waves-light"><i class="fa fa-print me-1"></i>&nbsp;Print</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (!empty($resource))
            <x-resource-page.right-tabs
                :resource="$resource"
                :uploads-files="$files"
                :uploads-folder="AppTenant\Models\Statical\MediaCollection::COLLECTION_RISK_MANAGEMENT"
                :comments-request-url="t_route('risk-management.add-comment', $resource->id)"
            />
        @endif
    </div>
@endsection

@push('script')
    <script src="{{ URL::asset('assets/js/risk-overview.js') }}"></script>
    <script>
        var delete_row = (obj) => {
            swalConfirm("Do you really want to delete?", '', (confirmed) => {
                if (confirmed) {
                    obj = $(obj);
                    var obj_id = obj.closest("tr").data("id");
                    var new_data = {
                        "id": obj_id
                    };
                    myAjax("{{ t_route('risk-management.remove') }}", new_data)
                        .then(res => {
                            obj.parents('tr').remove();
                            Load_anolyze();
                        });
                }
            });
        }
        var update_row = (obj) => {
            var obj = $(obj);
            var obj_id = obj.parents("tr").data("id");
            var p_table = obj.parents('table');
            var new_data = {};
            new_data['id'] = obj_id;

            var num = obj.parent()[0].cellIndex;
            var text = "";
            if (p_table.hasClass('probability_table')) {
                if (num == 0) text = "probability";
                else if (num == 1) text = "from";
                else if (num == 2) text = "to";
                else if (num == 3) text = "score";
            } else if (p_table.hasClass('impact_table')) {
                if (num == 0) text = "impact";
                else if (num == 1) text = "score";
                else if (num == 2) text = "color";
            } else {
                if (num == 0) text = "severity";
                else if (num == 1) text = "score";
            }
            new_data["name"] = text;
            new_data["value"] = obj.val();

            myAjax("{{ t_route('risk-management.update') }}", new_data)
                .then(res => {
                    Load_anolyze();
                });
        }
        var re_load = (obj) => {
            var i;
            var context = "";
            var probability = obj['probability'];
            for (i = 0; i < probability.length; i++) {
                context += `<tr data-id = '${probability[i]['id']}'>`;
                context +=
                    `<td style="min-width: 50%"><input class = 'form-control textOnly' value = ${probability[i]['probability']} type = 'text' onchange = 'update_row(this)' /></td>`;
                context +=
                    `<td style="width: 100px"><input class = 'form-control integerOnly' value = ${probability[i]['from']} type = 'number' onchange = 'update_row(this)' /></td>`;
                context +=
                    `<td style="width: 100px"><input class = 'form-control integerOnly' value = ${probability[i]['to']} type = 'number' onchange = 'update_row(this)' /></td>`;
                context +=
                    `<td style="width: 100px"><input class = 'form-control integerOnly' value = ${probability[i]['score']} type = 'text' onchange = 'update_row(this)' /></td>`;
                context +=
                    `<td class = 'pt-3 ps-0'><button type="button" class="btn-rounded btn btn-light waves-effect waves-light" onclick="delete_row(this)"><i class="bx bx-trash"></i></button></td>`;
                context += `</tr>`;
            }
            $('.probability_table tbody').html(context);
            context = "";
            var impact = obj['impact'];
            for (i = 0; i < impact.length; i++) {
                context += `<tr data-id = '${impact[i]["id"]}'>`;
                context +=
                    `<td><input class = 'form-control textOnly' value = ${impact[i]['impact']} type = 'text' onchange = 'update_row(this)' /></td>`;
                context +=
                    `<td style="width: 100px"><input class = 'form-control integerOnly' value = ${impact[i]['score']} type = 'number' onchange = 'update_row(this)' /></td>`;
                context +=
                    `<td style="width: 50px"><input class = 'form-control form-control-color dot' value = ${impact[i]['color']} type = 'color' onchange = 'update_row(this)' /></td>`;
                context +=
                    `<td class = 'pt-3 ps-0'><button type="button" class="btn-rounded btn btn-light waves-effect waves-light" onclick="delete_row(this)"><i class="bx bx-trash"></i></button></td>`;
                context += `</tr>`;
            }
            $(".impact_table tbody").html(context);
            context = "";
            var severity = obj['severity'];
            for (i = 0; i < severity.length; i++) {
                context += `<tr data-id = '${severity[i]["id"]}'>`;
                context +=
                    `<td><input class = 'form-control textOnly' value = ${severity[i]['severity']} type = 'text' onchange = 'update_row(this)' /></td>`;
                context +=
                    `<td style="width: 100px"><input class = 'form-control integerOnly' value = ${severity[i]['score']} type = 'number' onchange = 'update_row(this)' /></td>`;
                context +=
                    `<td class = 'pt-3 ps-0'><button type="button" class="btn-rounded btn btn-light waves-effect waves-light" onclick="delete_row(this)"><i class="bx bx-trash"></i></button></td>`;
            }
            $('.severity_table tbody').html(context);
            Load_anolyze();
        }
        jQuery(($) => {
            $("[name=contract]").change(function() {
                var new_data = {
                    'contract': $(this).val(),
                }
                myAjax("{{ t_route('risk-management.change') }}", new_data, {show_success_message: false})
                    .then(res => {
                        re_load(res.data);
                    });
            });

            $(".add_probability").click(function() {
                var new_data = {
                    "contract": $('[name=contract]').val(),
                    "risk_type": "{{ AppTenant\Models\Statical\RiskManagementType::PROBABILITY_ID }}",
                    "probability": "Enter a title",
                    "from": 1,
                    "to": 1,
                    "score": 1
                };
                myAjax("{{ t_route('risk-management.create') }}", new_data)
                    .then(res => {
                        var newProbability = "<tr data-id = '" + res.data.id + "'>" +
                            "<td><input class = 'form-control' type = 'text' onchange='update_row(this)' value = 'Enter a title' /></td>" +
                            "<td><input class = 'form-control' value = '1' type = 'number' onchange='update_row(this)' /></td>" +
                            "<td><input class = 'form-control' value = '1' type = 'number' onchange='update_row(this)' /></td>" +
                            "<td><input class = 'form-control' value = '1' type = 'number' onchange='update_row(this)' /></td>" +
                            "<td class = 'pt-3 ps-0'><button type='button' class='btn-rounded btn btn-light waves-effect waves-light' onclick='delete_row(this)'><i class='bx bx-trash''></i></button></td></tr>";
                        $(".probability_table tbody").append(newProbability);
                        Load_anolyze();
                    })
            });
            $(".add_impact").click(function() {
                var new_data = {
                    "contract": $('[name=contract]').val(),
                    "risk_type": "{{ AppTenant\Models\Statical\RiskManagementType::IMPACT_ID }}",
                    "impact": "Enter a title",
                    "color": "#ffc107",
                    "score": 1
                };
                myAjax("{{ t_route('risk-management.create') }}", new_data)
                    .then(res => {
                        var newImpact = "<tr data-id = '" + res.data.id + "'>" +
                            "<td><input class = 'form-control' value = 'Enter a title' type = 'text' onchange='update_row(this)' /></td>" +
                            "<td><input class = 'form-control' value = '1' type = 'number' onchange='update_row(this)'/></td>" +
                            "<td style='width: 100px'><input class = 'form-control form-control-color' value = '#ffc107' type = 'color' onchange='update_row(this)'></td>" +
                            "<td class = 'pt-3 ps-0'><button type='button' class='btn-rounded btn btn-light waves-effect waves-light' onclick='delete_row(this)'><i class='bx bx-trash''></i></button></td></tr>";
                        $('.impact_table tbody').append(newImpact);
                        Load_anolyze();
                    });
            });
            $(".add_severity").click(function() {
                var new_data = {
                    "contract": $('[name=contract]').val(),
                    "risk_type": "{{ AppTenant\Models\Statical\RiskManagementType::SEVERITY_ID }}",
                    "severity": "Enter a title",
                    "score": 1
                };
                myAjax("{{ t_route('risk-management.create') }}", new_data)
                    .then(res => {
                        var newSeverity = "<tr data-id = '" + res.data.id + "'>" +
                            "<td><input class = 'form-control textOnly' value = 'Enter a title' type = 'text' onchange='update_row(this)' /></td>" +
                            "<td style='width: 100px'><input class = 'form-control integerOnly' value = '1' type = 'number' onchange='update_row(this)' /></td>" +
                            "<td class = 'pt-3 ps-0'><button type='button' class='btn-rounded btn btn-light waves-effect waves-light' onclick='delete_row(this)'><i class='bx bx-trash''></i></button></td></tr>";
                        $('.severity_table tbody').append(newSeverity);
                        Load_anolyze();
                    });
            });

            init();
        });

        function init() {
            Load_anolyze();
            
            let contract_options = $("[name=contract] option:not([value=''])");

            if (contract_options.length) {
                $("[name=contract]").val(contract_options[0].value)
                    .trigger('change');
            }
        }
    </script>
@endpush
