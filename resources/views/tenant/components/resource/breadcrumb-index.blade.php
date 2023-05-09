@php
    $resource = is_object($resource) ? $resource : (new $resource());
    $create_permission = $resource->permission('create'); 
    $li1_title = \App\Services\Helpers\Str::singularToPlural($resource->ResourceName());
    $li1_link = $resource->link();
    $title = $li1_title . ' list';
@endphp

@component('components.breadcrumb')
    @slot('li_1_link') {{ $li1_link }} @endslot
    @slot('li_1') {{ $li1_title }} @endslot
    @slot('title') {{ $title }}  @endslot

    @t_can($create_permission)
        @slot('centered_items')
            <a href="{{ $resource->link('create') }}" class="btn btn-primary btn-rounded w-md waves-effect waves-light">
                <i class="mdi mdi-alert-plus-outline font-size-20 me-1" style="vertical-align: middle"></i> Add new
            </a>
        @endslot
    @endt_can
@endcomponent