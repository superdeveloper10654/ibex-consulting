@extends('tenant.contracts.create-layout')
@section('step-form-section')
<div class="card p-md-5">
    <div class="card-body">
        <h4>{{str_contains($contractType,'ECS') ? 'SUB' : ''}}CONTRACT DATA</h4>
        <h5 class="pt-5 border-top">Part one - Data provided by the <i>{{str_contains($contractType,'ECS') ? 'Contractor' :( str_contains($contractType,'NEC4') ? 'Client':'Employer')}}</i></h5>
        <hr>
        {!! Form::open(array('route' => ['contracts-step6-update', $contractAppl->contract_id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}
        {!! csrf_field() !!}

        @include('tenant.contracts.contract-details.step6')

        <div class="border-top mt-5 pt-4">
          <a href="{{ URL::to('contracts/' .$contractAppl->contract_id.'/step5') }}"><button type="button" class="btn btn-secondary btn-rounded w-md waves-effect waves-light float-left"><i class="mdi mdi-chevron-left me-1"></i>Back</button></a>
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
@endsection
@section('script')
@include('tenant.contracts.defect-except-periods-dynamic')
@endsection