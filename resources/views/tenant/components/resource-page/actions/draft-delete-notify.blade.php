<div class="card p-lg-3 d-print-none">
    <div class="card-body ">
        <div class="row">
            <p class="text-muted mb-3 text-center"><i class="bx bx-info-circle"></i>&nbsp;<small>You may Delete or Notify the {{ $resource->resourceName() }}</small></p>
            <div class="actions-wrapper d-flex align-items-center mx-auto" style="max-width: 600px">
                <x-swal.confirm callback-yes="{{ $deleteCallback }}"
                    title="Are you sure want to Delete the {{ $resource->resourceName() }}?"
                    class="mx-auto"
                >
                    <button class="btn btn-outline-dark btn-rounded w-md waves-effect waves-light">
                        <i class="mdi mdi-alert-remove-outline font-size-14 me-1" style="vertical-align: middle;"></i>Delete
                    </button>
                </x-swal.confirm>
                <x-swal.confirm callback-yes="{{ $notifyCallback }}"
                    title="Are you sure want to Notify the {{ $resource->resourceName() }}?"
                    class="mx-auto"
                >
                    <button class="btn btn-outline-dark btn-rounded w-md waves-effect waves-light">
                        <i class="mdi mdi-scale-balance font-size-14 me-1" style="vertical-align: middle;"></i>Notify
                    </button>
                </x-swal.confirm>
            </div>
        </div>
    </div>
</div>