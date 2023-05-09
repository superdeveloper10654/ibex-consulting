<div class="modal" tabindex="-1" id="modal_date_range">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Date Range Editor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="daterangeform">
                    <div class="form-group mb-3">
                        <x-form.datepicker name="date_from" label="Date From" :value="$data['date_range_start']" />
                    </div>
                    <div class="form-group mb-3">
                        <x-form.datepicker name="date_to" label="Date To" :value="$data['date_range_end']" />
                    </div>
                    <span class="text-danger" id="date_toErrorMsg"></span>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary set-default-date-range">Default</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>