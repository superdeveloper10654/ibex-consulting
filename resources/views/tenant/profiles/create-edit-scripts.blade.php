@push('script')
    <script>
        jQuery($ => {
            $('#role').on('change', function() {
                if (this.value == '<?= AppTenant\Models\Statical\Role::SUBCONTRACTOR_ID ?>') {
                    $('.row.contractor-parent-id').show();
                } else {
                    $('.row.contractor-parent-id').hide();
                }
            });
        });
    </script>
@endpush