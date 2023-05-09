@extends('tenant.contracts.create-layout')
@section('step-form-section')
<div class="card p-md-5">
    <div class="card-body">
        <h4>{{str_contains($contractType,'ECS') ? 'SUB' : ''}}CONTRACT DATA</h4>
        <h5 class="pt-5 border-top">Part one - Data provided by the <i>{{str_contains($contractType,'ECS') ? 'Contractor' :( str_contains($contractType,'NEC4') ? 'Client':'Employer')}}</i></h5>
        <hr>
        {!! Form::open(array('route' => ['contracts-step9-update', $contractAppl->contract_id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}
        {!! csrf_field() !!}

        @include('tenant.contracts.contract-details.step9')

        <div class="border-top mt-5 pt-4">
          <a href="{{ URL::to('contracts/' .$contractAppl->contract_id.'/step8') }}"><button type="button" class="btn btn-secondary btn-rounded w-md waves-effect waves-light float-left"><i class="mdi mdi-chevron-left me-1"></i>Back</button></a>
            <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light float-end">Continue<i class="mdi mdi-chevron-right ms-1"></i></button>
          <p class="text-muted mb-3 text-center"><i class="bx bx-info-circle ms-1"></i>
                                <small>
                                    Your changes are automagically saved
                                </small>
                            </p>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet" />
<script>
    jQuery(($) => {
        $('.date').datepicker({
            multidate: true,
            format: 'dd-mm-yyyy'
        })
        // .on("change", function(ev) {
        //     console.log($(this).val())
        // })
        ;
    });
</script>
@endsection
@section('script')
@include('tenant.contracts.price-adjustment-factor-proportions-dynamic')
@include('tenant.contracts.pay-item-activities-dynamic')
@include('tenant.contracts.work-section-completion-dates-dynamic')
@include('tenant.contracts.work-section-bonuses-dynamic')
@include('tenant.contracts.work-section-delay-damages-dynamic')
@include('tenant.contracts.undertakings-to-clients-dynamic')
@include('tenant.contracts.undertakings-to-others-dynamic')
@include('tenant.contracts.subcontractor-undertakings-to-others-dynamic')
@include('tenant.contracts.low-performance-damage-amounts-dynamic')
@include('tenant.contracts.extension-periods-dynamic')
@include('tenant.contracts.extension-criteria-dynamic')
@include('tenant.contracts.accounting-periods-dynamic')
@include('tenant.contracts.benificiary-terms-dynamic')
@endsection