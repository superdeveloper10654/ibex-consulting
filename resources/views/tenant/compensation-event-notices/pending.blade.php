@extends('tenant.layouts.master')

@section('title') @lang('Notifications') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Compensation Events Notification @endslot
        @slot('title') Compensation Events Notification @endslot

        <!-- @t_can('early-warnings.create')
            @slot('centered_items')
                <a href="{{ t_route('early-warnings.create') }}" class="btn btn-primary btn-rounded w-md waves-effect waves-light"><i class="mdi mdi-alert-plus-outline font-size-20 me-1" style="vertical-align: middle"></i> Early Warning</a>
            @endslot
        @endt_can -->
        <style>
            #form_description{
                min-height:100px;
            }
        </style>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form id = "create-compensation" action = "create" method="POST">
                                @csrf
                                <div class = "form-group row">
                                    <label>Title</label>
                                    <label>{{$pending->title}}</label>
                                </div>
                                <div class = "form-group mt-4 row">
                                    <label>Description</label>
                                    <label>{{$pending->description}}</label>
                                </div>
                                <div class = "form-group mt-4 row">
                                    <label>Decision</label>
                                    <x-form.checkbox-customized label="Pending" 
                                        name="early_warning_notified" 
                                        :checked="old('early_warning_notified') == 0 ? 'checked' : false" 
                                    />
                                    <x-form.checkbox-customized label="Correct" 
                                        name="early_warning_notified" 
                                        :checked="old('early_warning_notified') == 1 ? 'checked' : false" 
                                    />
                                    <x-form.checkbox-customized label="Incorrect" 
                                        name="early_warning_notified" 
                                        :checked="old('early_warning_notified') == 2 ? 'checked' : false" 
                                    />
                                </div>
                                <div style = "padding-left:100px;" class = "form-group mt-4 row">
                                    <label>Incorrect because this event</label>
                                    <x-form.checkbox-customized label="arises from a fault of the Contractor" 
                                        name="incorrect" 
                                        :checked="old('early_warning_notified') == 1 ? 'checked' : false" 
                                    />
                                    <x-form.checkbox-customized label="has not happened and is not expected to happen" 
                                        name="incorrect" 
                                        :checked="old('early_warning_notified') == 1 ? 'checked' : false" 
                                    />
                                    <x-form.checkbox-customized label="blah" 
                                        name="incorrect" 
                                        :checked="old('early_warning_notified') == 1 ? 'checked' : false" 
                                    />
                                </div>
                                <div class = "form-group mt-4 row">
                                    <label>Notified by</label>
                                    <label>{{$pending->first_name}} {{$pending->last_name}} on {{$pending->created_at}}</label>
                                </div>
                                <div class = "form-group mt-4 row">
                                    <div class = "col-md-6"></div>
                                    <div class = "col-md-6 row">
                                        <div class = "col-md-6">
                                        </div>
                                        <div class = "col-md-6">
                                            <a href="javascript:window.print()" class="btn btn-secondary btn-rounded w-md waves-effect waves-light">
                                                <i class="fa fa-print me-1"></i>&nbsp;Print
                                            </a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>

        
@endsection
@section('script')
<script>    
    jQuery(($)=>{
    });
        
    
</script>
@endsection('script')
