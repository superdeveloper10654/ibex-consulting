@extends('tenant.layouts.master')
@section('title')
    @lang('Add New Charts')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            <a href="{{t_route('chart')}}">List Of Charts</a>
        @endslot
        @slot('title')
            Add New Charts
        @endslot
    @endcomponent
    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-8">
            <div class="card p-5">
                <div class="card-body">
                    <p class="card-title-desc">Please complete all fields below</p>
                    <form id="create-new-chart" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.input label="Name" name="name" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Contract" name="contract_id" :options="$contracts->pluck('contract_name', 'id')" />
                            </div>
                        </div>
                        <hr>
                        <div class="row float-end row mt-5 pb-3">
                            <button type="submit"
                                class="btn btn-success btn-rounded w-md waves-effect waves-light">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $("#create-new-chart").submit(function(e) {
            e.preventDefault(); // prevent actual form submit
            var form = $(this);

            //form.attr('action'); //get submit url [replace url here if desired]
            var url = '{{ t_route('chart.store') }}';
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes form input
                success: function(result) {
                    window.open('../programmes/gantt/' + result.data, '_blank');

                }
            });
        });
    </script>
@endsection
