@php
    $link = $link ?? $resource->link('show');
@endphp

{{ $name }}
<a href="{{ $link }}"><i class="mdi mdi-link-variant d-print-none"></i></a>