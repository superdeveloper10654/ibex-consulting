@extends('tenant.contracts.create-layout')
@section('step-form-section')
<div class="card">
    <div class="card-body">
        <h4>{{str_contains($contractType,'ECS') ? 'SUB' : ''}}CONTRACT DATA</h4>
        <h5 class="pt-5 border-top">Part two - Data provided by the
            @if(str_contains($contractType,'ECS'))
            <i>Subcontractor</i>
            @else
            <i>Contractor</i>
            @endif
        </h5>
        <hr>
        {!! Form::open(array('route' => ['contracts-step11-update', $contractData2->contract_id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}
        {!! csrf_field() !!}

        @include('tenant.contracts.contract-details.step11')

        <div style="float:right; margin-top: 5px;">
            <a href="{{ URL::to('contracts/' .$contractData2->contract_id.'/step10') }}"><button type="button" class="btn btn-primary btn-rounded w-md waves-effect waves-light">Back</button></a>
            <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Save & Finish</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection
@section('script')
@include('tenant.contracts.step11-dynamic')
@endsection