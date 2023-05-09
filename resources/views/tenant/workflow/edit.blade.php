@extends('tenant.layouts.master')

@section('title')
    @lang('Workflow')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1_link') {{ t_route($route_prefix) }} @endslot
        @slot('li_1') Workflow @endslot
        @slot('title') {{ $id ? 'Edit workflow ' . $name : 'Create' }} @endslot
        @slot('centered_items')
            <div class="d-flex">
                <input type="hidden" name="previous_page" value="{{ url()->previous() }}">
                <input type="hidden" name="category" value="{{ $category }}">
                <input id="workflowName" placeholder="Name" name="name" class="form-control input-sm"
                    style="height: 30px; margin-right: 20px;" value="{{ $name }}" />
                <button class="btn btn-primary btn-rounded btn-sm ml-2 w-md waves-effect waves-light"
                    onclick="saveWorkflow('{{ t_route('workflow.store') }}')">
                    <i class="mdi mdi-content-save me-1"></i> Save
                </button>
            </div>
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-8 left-col">
            <div class="header-wrapper d-flex justify-content-between">
                <x-resource-page.button.expand />
            </div>
            <div class="card">
                <div class="card-body" style="display: flex; height: calc(100vh - 240px);">
                    <div id="myPaletteDiv" class="palette" style="width: 170px;"></div>
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
                    {{-- <textarea id="mySavedModel" style="width:calc(45%);height:100px"></textarea> --}}
                    {{-- <textarea id="myAnswer" style="width:calc(45%);height:100px"></textarea> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <h4>Hotkeys:</h4>
            <ul class="text-muted fst-italic">
                <li>
                    <span class="fw-bolder fst-normal">Del</span>, <span class="fw-bolder fst-normal">Backspace</span> - delete selected element;
                </li>
                <li>
                    <span class="fw-bolder fst-normal">Ctrl + C</span> - copy selected element;
                </li>
                <li>
                    <span class="fw-bolder fst-normal">Ctrl + V</span> - paste selected element;
                </li>
            </ul>
        </div>
    </div>
@endsection


@section('script')
    <script src="{{ URL::asset('/assets/libs/go/go.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/workflow.js?v=2') }}"></script>
    <script>
        var data = @json($data);
        workflowId = {{ $id }};
        initWorkflow();
        if (data) {
            loadWorkflow(data);
        }
    </script>
@endsection
