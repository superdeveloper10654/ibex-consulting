@php
    if ($resource->isAccepted()) {
        $color_class = 'alert-success';
    } else if ($resource->isRejected() || $resource->isClosed()) {
        $color_class = 'alert-danger';
    } else if ($resource->isSubmitted() || $resource->isNotified()) {
        $color_class = 'alert-primary';
    } else if ($resource->isEscalated()) {
        $color_class = 'alert-warning';
    } else {
        $color_class = 'alert-dark';
    }
@endphp

<span class="alert status-label {{ $color_class }}">{!! $resource->status()->icon !!} {{ $resource->status()->name }}</span>