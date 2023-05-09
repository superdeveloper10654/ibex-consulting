@extends('tenant.layouts.master')

@section('title') @lang('Update Settings') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Settings @endslot
@slot('title') Update Settings @endslot
@endcomponent

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <p class="card-title-desc">Please complete fields below</p>
                <form action="{{t_route('notification-settings.update',$setting->id)}}" id="edit-setting" method="POST" autocomplete="off">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <x-form.textarea label="MS Teams Notifications URL" name="value" id='value' value="{{old('title',$setting->value)}}" />
                            @error('value')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <label>Status</label>
                        <div class="d-flex ">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1" {{$setting->status == 1 ? 'checked':''}} {{$setting->value ? '':'disabled'}}>
                                <label class="form-check-label" for="inlineRadio1">Enable</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0" {{$setting->status == 0 ? 'checked':''}} {{$setting->value ? '':'disabled'}}>
                                <label class="form-check-label" for="inlineRadio2">Disable</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row float-end row mt-5 pb-3">
                        <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    jQuery(($) => {
        $('#value').keyup(function(val) {
            console.log($(this).val(), 'hgjg')
            if (!$(this).val()) {
                status = $('input[name="status"]');
                $("#inlineRadio2").prop("checked", true);
                $('input[name="status"]').prop('disabled', true);
            } else {
                $('input[name="status"]').prop('disabled', false);
            }
        })
    });
</script>
@endsection