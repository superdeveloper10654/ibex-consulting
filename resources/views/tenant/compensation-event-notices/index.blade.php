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
                                    <h6>please complete all fields below.</h6>
                                </div>
                                <div class = "form-group mt-3 row">
                                    <div class = "col-md-6">
                                        <x-form.select label="Contract" name="contract_id" :options="$contracts->pluck('contract_name', 'id')" :selected="old('contract_id')" />    
                                    </div>
                                    <div class = "col-md-6">
                                        <x-form.select label="Source" name="early_warning_id" :options="$sources->pluck('title', 'id')" :selected="old('early_warning_id')" />
                                    </div>
                                </div>
                                <div class = "form-group mt-3 row">
                                    <div>
                                        <label for = "clause" >Clause</label>
                                        <select id = "clause" name = "clause_id" class = "form-control">
                                            <option>60.1(1)  The Service Manager gives an instruction changing the Service Information except a change made in order to accept a Defect.</option>
                                        </select>
                                    </div>
                                </div>
                                <div class = "form-group mt-3 row">
                                    <div>
                                        <label for = "title" >Title</label>
                                        <input id = "title" name = "title" class = "form-control" />
                                    </div>
                                </div>
                                <div class = "form-group mt-3 row">
                                    <div>
                                        <label for = "description" >description</label>
                                        <textarea id = "description" name = "description" class = "form-control"></textarea>
                                    </div>
                                    
                                </div>
                                <div class = "form-group mt-3 row">
                                    <div class = "col-md-6"></div>
                                    <div class = "col-md-6 row">
                                        <div class = "col-md-6 btn-group">
                                            <button type = "button" class = "save-a-draft btn btn-secondary form-control">save a draft</button>
                                        </div>
                                        <div class = "col-md-6">
                                            <button type = "submit" class = "create btn btn-success form-control">create</button>
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
        $('#create-compensation').on('submit', function(e) {
            e.preventDefault();
            removeFormErrors(this);
            form_ajax('{{ t_route("compensation-events-notification.create") }}', this, {redirect: "{{ t_route('compensation-events-notification.pending') }}"});
        });
        
    });
        
    
</script>
@endsection('script')
