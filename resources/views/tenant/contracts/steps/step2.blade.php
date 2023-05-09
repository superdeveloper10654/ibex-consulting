@extends('tenant.contracts.create-layout')
@section('step-form-section')
<div class="card p-md-5">
    <div class="card-body">
        <h4>Options</h4>
        <p class="card-title-desc">Please select all the appropriate options</p>
        {!! Form::open(array('route' => ['contracts-step2-update', $id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}
        {!! csrf_field() !!}

        @include('tenant.contracts.contract-details.step2')

        <div class="border-top mt-5 pt-4">
            <a href="{{ URL::to('contracts/' .$id.'/edit') }}">
              <button type="button" class="btn btn-secondary btn-rounded w-md waves-effect waves-light float-left"><i class="mdi mdi-chevron-left me-1"></i>Back</button>
          </a>
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