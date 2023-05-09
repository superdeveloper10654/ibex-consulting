@extends('tenant.layouts.master')

@section('title')
@lang('New Contract')
@endsection @section('content')

@component('components.breadcrumb')
@slot('li_1') Contracts @endslot
@slot('title') New Contract
@endslot @endcomponent

<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card p-md-5">
            <div class="card-body">
                @if($contractType) <h4 class="card-title">{{ str_contains($contractType, 'NEC4') ? 'NEC4': 'NEC3'}} Suite</h4> @endif
                @if($contractType === 'NONE' || $contractType == NULL)
                <p class="card-title-desc mt-4 mb-2">Please select the contract suite </p>
                <div class="col-md-12">
                    <div class="nav nav-pills" id="nec-tab" role="tablist" aria-orientation="horizontal">
                        <a class="nav-link contract-suite-nav-link mb-2 active" id="NEC3-tab" data-bs-toggle="pill" href="#NEC3" role="tab" aria-controls="NEC3" aria-selected="false">NEC3</a>
                        <a class="nav-link contract-suite-nav-link mb-2" id="NEC4-tab" data-bs-toggle="pill" href="#NEC4" role="tab" aria-controls="NEC4" aria-selected="true">NEC4</a>
                    </div>
                </div>
                @else
                <p class="card-title-desc mt-4 mb-2">{{'You selected '.(str_contains($contractType, 'NEC4') ? 'NEC4': 'NEC3').' suite' }}</p>
                <div class="form-control">
                    <div class="nav nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @if(str_contains($contractType, 'NEC4'))
                        <a class="nav-link contract-suite-nav-link active" id="NEC4-tab" data-bs-toggle="pill" href="#NEC4" role="tab" aria-controls="NEC4" aria-selected="true">NEC4</a>
                        @else
                        <a class="nav-link contract-suite-nav-link active" id="NEC3-tab" data-bs-toggle="pill" href="#NEC3" role="tab" aria-controls="NEC3" aria-selected="false">NEC3</a>
                        @endif
                    </div>
                </div>
                @endif
                <p class="card-title-desc mt-4 mb-2">{{$contractType === 'NONE' || $contractType == NULL ? 'Please select the contract type':'You selected '.str_replace('NEC4_','',$contractType).' Contract' }} </p>
                @if($contractType === 'NONE' || $contractType == NULL)
                <div class="form-control">
                    <div class="nav nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link contract-type-nav-link active" id="ECC-tab" data-bs-toggle="pill" href="#ECC" role="tab" aria-controls="ECC" aria-selected="false">ECC</a>
                        <a class="nav-link contract-type-nav-link " id="ECS-tab" data-bs-toggle="pill" href="#ECS" role="tab" aria-controls="ECS" aria-selected="false">ECS</a>
                        <a class="nav-link contract-type-nav-link" id="TSC-tab" data-bs-toggle="pill" href="#TSC" role="tab" aria-controls="TSC" aria-selected="true">TSC</a>
                    </div>
                </div>
                @else
                <div class="form-control">
                    <div class="nav nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @if(str_contains($contractType, 'ECC'))
                        <a class="nav-link contract-type-nav-link active" data-bs-toggle="pill" href="#ECC" role="tab" aria-controls="ECC" aria-selected="false">ECC</a>
                        @endif
                        @if(str_contains($contractType, 'ECS'))
                        <a class="nav-link contract-type-nav-link active" data-bs-toggle="pill" href="#ECS" role="tab" aria-controls="ECS" aria-selected="false">ECS</a>
                        @endif
                        @if(str_contains($contractType, 'TSC'))
                        <a class="nav-link contract-type-nav-link active" data-bs-toggle="pill" href="#TSC" role="tab" aria-controls="TSC" aria-selected="true">TSC</a>
                        @endif
                    </div>
                </div>
                @endif
                <div class="col-md-11">
                    <div class="tab-content px-3 text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                        <div class="tab-pane" id="ECC" role="tabpanel" aria-labelledby="ECC-tab">
                            <h6>Engineering and Construction Contract</h6>
                            <p>This contract should be used for the appointment of a contractor for engineering and construction work, including any level of design responsibility. It contains all core clauses and secondary option clauses, together with
                                the schedules of cost components and forms for contract data.
                            </p>
                        </div>
                        <div class="tab-pane" id="ECS" role="tabpanel" aria-labelledby="ECS-tab">
                            <h6>Engineering and Construction Subcontract</h6>
                            <p>This subcontract is intended for use in appointing a subcontractor where the contractor has been appointed under the NEC3 Engineering and construction options, the available secondary options, schedules of cost components
                                and contract data.
                            </p>
                        </div>
                        <div class="tab-pane" id="TSC" role="tabpanel" aria-labelledby="TSC-tab">
                            <h6>Term Services Contract</h6>
                            <p>This contract should be used for the appointment of a contractor for engineering and construction work, including any level of design responsibility. It contains all core clauses and secondary option clauses, together with
                                the schedules of cost components and forms for contract data.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="col-md-11" id="contents">
        @if($errors->any())
        <div class="mt-3  alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
            <span class="alert-text text-danger">
                {{$error}}
            </span></br>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <i class="fa fa-close" aria-hidden="true"></i>
            </button>
        </div>
        @endif
        @yield('step-form-section')
    </div>
</div>

@endsection

@section('scripts')
<script>
    jQuery(($) => {
        $('#create-contract').on('submit', function(e) {
            e.preventDefault();
            removeFormErrors(this);

            form_ajax('{{ t_route("contracts.store") }}', this, {
                redirect: "{{ t_route('contracts') }}"
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        // get ready ECS start
        var contractType = '<?php echo $contractType; ?>'
        if ($("#contract_type").val()) {
            const tabPaneActiveId = $("#contract_type").val();
            $(`#${tabPaneActiveId}`).addClass('active')
            var defaultActiveId = $("#v-pills-tab").find(".active").text()
            $(`#${defaultActiveId}-tab`).removeClass('active')
            $(`#${tabPaneActiveId}-tab`).addClass('active')

            if ($("#nec-tab").find(".active").text() == 'NEC4') {
                $("#contract_type").val('NEC4_' + $(this).text());
                if ($("#v-pills-tab").find(".active").text().includes('ECS')) {
                    $("#works_or_service").prev('label').text('Subcontract Scope')
                } else if ($("#v-pills-tab").find(".active").text().includes('TSC')) {
                    $("#works_or_service").prev('label').text('Service Scope')
                } else {
                    $("#works_or_service").prev('label').text('Works Scope')
                }
            } else {
                $("#contract_type").val($(this).text());
                if ($("#v-pills-tab").find(".active").text().includes('ECS')) {
                    $("#works_or_service").prev('label').text('Subcontract Information')
                } else if ($("#v-pills-tab").find(".active").text().includes('TSC')) {
                    $("#works_or_service").prev('label').text('Service Information')
                } else {
                    $("#works_or_service").prev('label').text('Works Information')
                }
            }

        } else {
            if (contractType === 'NONE') {
                $("#contract_type").val(($("#nec-tab").find(".active").text() == 'NEC4' ? 'NEC4_' : '') + $("#v-pills-tab").find(".active").text());
                $('.contract-type').hide();
                // $("button#continue-1").hide();
                $("div#contents").hide();
                $("select.form-select").val('Select');
                $("button#continue-1").click(function() {
                    $("#contract_type").val(($("#nec-tab").find(".active").text() == 'NEC4' ? 'NEC4_' : '') + $("#v-pills-tab").find(".active").text());
                    $(".contract-type").is(':hidden') ? $(".contract-type").show() : $("div#contents").show();
                });
            } else {
                $("#contract_type").val(contractType);
            }
            const tabPaneActiveId = $("#v-pills-tab").find(".active").text();
            $(`#${tabPaneActiveId}`).addClass('active')
        }

        $(".contract-type-nav-link").on("click", function() {

            if ($("#nec-tab").find(".active").text() == 'NEC4') {
                $("#contract_type").val('NEC4_' + $(this).text());
                if ($(this).text().includes('ECS')) {
                    $("#works_or_service").prev('label').text('Subcontract Scope')
                } else if ($(this).text().includes('TSC')) {
                    $("#works_or_service").prev('label').text('Service Scope')
                } else {
                    $("#works_or_service").prev('label').text('Works Scope')
                }
            } else {
                $("#contract_type").val($(this).text());
                if ($(this).text().includes('ECS')) {
                    $("#works_or_service").prev('label').text('Subcontract Information')
                } else if ($(this).text().includes('TSC')) {
                    $("#works_or_service").prev('label').text('Service Information')
                } else {
                    $("#works_or_service").prev('label').text('Works Information')
                }
            }

            // $("#contract_type").val(($("#nec-tab").find(".active").text() == 'NEC4' ? 'NEC4_' : '') + $(this).text());
            // if ($(this).text().includes('TSC')) {
            //     $("#works_or_service").prev('label').text('Service Information')
            //     // $("#works_or_service_label").text('Service Information');
            // } else {
            //     $("#works_or_service").prev('label').text('Works Information')
            //     // $("#works_or_service_label").text('Works Information');
            // }
            // //  if ($(this).text() == 'ECC') {
            // //     $("#works_or_service_label").text('Works Information');

            // // } else if ($(this).text() == 'ECS') {
            // //     $("#works_or_service_label").text('Works Information');

            // // }
        });

        $(".contract-suite-nav-link").on("click", function() {
            if ($(this).text() == "NEC4") {
                $("#ECC-tab,#ECC").removeClass('active').addClass('d-none');
                $("#TSC-tab,#TSC").removeClass('active');
                $("#ECS-tab,#ECS").addClass('active')
                $("#works_or_service").prev('label').text('Subcontract Scope')
                // .trigger('click');
                $("#contract_type").val('NEC4_' + $("#v-pills-tab").find(".active").text());
            } else {
                // $("#ECS-tab").show();
                $("#ECC-tab,#ECC").removeClass('d-none');
                // $("#TSC-tab").removeClass('active').hide();
                // $("#ECC-tab:not([class*='active'])").addClass('active');
                if ($("#v-pills-tab").find(".active").text().includes('TSC')) {
                    $("#works_or_service").prev('label').text('Subcontract Information')
                } else if ($("#v-pills-tab").find(".active").text().includes('TSC')) {
                    $("#works_or_service").prev('label').text('Service Information')
                } else {
                    $("#works_or_service").prev('label').text('Works Information')
                }
                $("#contract_type").val($("#v-pills-tab").find(".active").text());
            }
            $(".contract-type").show();
        });

        // FIX THIS
        $('input[type="checkbox"]').change(function(e) {
            var txt = $('.secondary-option.input:checked').closest('label').each(function() {
                return $(this).val();
            }).get().join(', ');
            $('#selected_secondary_options').text(txt);
        });


        $("select#dispute_resolution_option").on('change', function() {
            $('.selected_dispute_resolution_option').text(this.value);
        });


        // Main options - X1 not used on E & F      
        $("select#main_option").change(function() {
            if ($('option#ecc-opt-e').is(':selected')) {
                $('div#row-x1').hide();
                $('div#if_x1_used').hide();
            } else if ($('option#ecc-opt-f').is(':selected')) {
                $('div#row-x1').hide();
                $('div#if_x1_used').hide();
            } else {
                $('div#row-x1').show();
                $('div#if_x1_used').show();
            }
        });

        // Main options under ECC - X3 only used on A & B      
        $("select#main_option").change(function() {
            if ($('option#ecc-opt-a').is(':selected')) {
                $('div#row-x3').show();
                $('div#if_x3_used').show();
            } else if ($('option#ecc-opt-b').is(':selected')) {
                $('div#row-x3').show();
                $('div#if_x3_used').show();
            } else {
                $('div#row-x3').hide();
                $('div#if_x3_used').hide();
            }
        });

        // Main options under ECC - X16 not used on F      
        $("select#main_option").change(function() {
            if ($('option#ecc-opt-f').is(':selected')) {
                $('div#row-x16').hide();
            } else {
                // $('div#row-x16').show();
            }
        });

        // Main options under TSC - X5, X6, X7 & X16 not used     
        $("select#main_option").change(function() {
            if ($('option#tsc-opt-a').is(':selected')) {
                $('div#row-x3').show();
            } else if ($('option#tsc-opt-c').is(':selected')) {
                $('div#row-x3').hide();
            } else if ($('option#tsc-opt-e').is(':selected')) {
                $('div#row-x1').hide();
                $('div#if_x1_used').hide();
                $('div#row-x3').hide();
            } else {

            }
        });

        // Main options under ESC - X3 only used on A & B      
        $("select#main_option").change(function() {
            if ($('option#esc-opt-a').is(':selected')) {
                $('div#row-x3').show();
            } else if ($('option#ecs-opt-b').is(':selected')) {
                $('div#row-x3').show();
            } else {
                //$('div#row-x3').hide();
            }
        });

        // Main options - X20 not used if X12 is used      
        $('input[name="x12"]').click(function() {
            if ($(this).prop("checked") == true) {
                $('div#row-x20').hide();
                $("input[name=x20]").val("0");
            } else if ($(this).prop("checked") == false) {
                $('div#row-x20').show();
            }
        });
        $('input[name="x20"]').click(function() {
            if ($(this).prop("checked") == true) {
                $('div#row-x12').hide();
                $("input[name=x12]").val("0");
            } else if ($(this).prop("checked") == false) {
                $('div#row-x12').show();
            }
        });

        $('.is_or_is_not').change(function() {
            $(this).closest('.toggle-section').find('.is_or_is_not_value').text($(this).prop('checked') ? ' is' : ' is not')
            $(this).closest('.toggle-section').find('.is_hide').prop('required', !$(this).closest('.toggle-section').find('.is_hide').prop('required')).toggleClass('d-none')
        })

        $('.select-user').change(function() {
            profile = JSON.parse($(this).find(":selected").attr('data'))
            $(this).siblings('.address').val(profile.address)
            $(this).siblings('.address').val(profile.electronic_address)
        });

    });
</script>

@endsection