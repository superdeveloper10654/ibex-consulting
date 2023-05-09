<div class="card p-lg-3 d-print-none">
    <div class="card-body ">
        <div class="row">
            <p class="text-muted mb-3 text-center"><i class="bx bx-info-circle"></i>&nbsp;You may accept or reject this {{ $resource->resourceName() }}</p>
            <div class="actions-wrapper d-flex align-items-center mx-auto" style="max-width: 600px">
                <x-swal.confirm callback-yes="{{ $acceptCallback }}" title="Are you sure want to Accept the {{ $resource->resourceName() }}?"
                    class="mx-auto">
                    <button class="btn btn-success btn-rounded w-md waves-effect waves-light">
                        <i class="mdi mdi-check font-size-18 me-1" style="vertical-align: middle;"></i>Accept
                    </button>
                </x-swal.confirm>
                <x-swal.confirm callback-yes="{{ $rejectCallback }}" title="Are you sure want to Reject the {{ $resource->resourceName() }}?"
                    class="mx-auto">
                    <button class="btn btn-danger btn-rounded w-md waves-effect waves-light">
                        <i class="mdi mdi-close font-size-18 me-1" style="vertical-align: middle;"></i>Reject
                    </button>
                </x-swal.confirm>
            </div>
        </div>
    </div>
</div>