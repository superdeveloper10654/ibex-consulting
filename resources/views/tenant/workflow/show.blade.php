@extends('tenant.layouts.master')

@section('title')
    @lang('Workflow')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1_link')
            {{ t_route($route_prefix) }}
        @endslot
        @slot('li_1')
            Workflow
        @endslot
        @slot('title')
            Show workflow {{ $workflow->name }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-8 left-col">
            <x-resource-page.button.expand />
            <div class="card">
                <div class="card-body" style="display: flex; height: calc(100vh - 240px);">
                    <div id="myPaletteDiv" class="palette" style="display:none;"></div>
                    <div id="myDiagramDiv" class="diagram" style="flex-grow: 1; border-left: 1px solid lightgrey;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 right-col">
            <div class="card mt-5">
                <div class="card-body">
                    <div id="previewDiv" style="flex-grow: 1;padding: 8px;">
                        <label class="form-label m-0">Preview</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="{{ URL::asset('/assets/libs/go/go.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/workflow.js?v=1') }}"></script>
    <script>
        var data = @json($workflow->data);
        initWorkflow(false);
        if (data) {
            loadWorkflow(data);
        }
    </script>
@endsection
