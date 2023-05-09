<div class="float-end mx-1">
    <a href="javascript:window.print()" class="btn btn-secondary btn-rounded w-md waves-effect waves-light">
        <i class="fa fa-print me-1"></i>&nbsp;Print
    </a>
    @if (t_profile()->can($resource->permission('update')) && ($resource->isDraft() || $resource->isNotified() || $resource->isSubmitted()))
        <a href="{{ $resource->link('edit') }}" 
            class="btn btn-outline-secondary btn-rounded w-md waves-effect waves-light mx-1"
        >
            <i class="mdi mdi-book-edit-outline me-1"></i>&nbsp;Edit
        </a>
    @endif
</div>