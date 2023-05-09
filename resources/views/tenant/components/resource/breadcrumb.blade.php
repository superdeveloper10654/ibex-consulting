@php
    $resource = is_object($resource) ? $resource : (new $resource());
    $li1_title = \App\Services\Helpers\Str::singularToPlural($resource->ResourceName());
    $li1_link = $resource->link();
@endphp

@component('components.breadcrumb')
    @slot('li_1_link') {{ $li1_link }} @endslot
    @slot('li_1') {{ $li1_title }} @endslot
    @slot('title') {{ $title }}  @endslot
@endcomponent