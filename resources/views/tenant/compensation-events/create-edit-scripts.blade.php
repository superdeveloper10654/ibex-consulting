<script>
    jQuery(($) => {
        $('#early_warning_id').on('change', function() {
            if (this.value == '{{ App\Models\Statical\Constant::OPTION_NO_EARLY_WARNING_ID }}') {
                $('#early_warning_notified').closest('.checkbox-customized-wrapper').removeClass('d-none');
            } else {
                $('#early_warning_notified').closest('.checkbox-customized-wrapper').addClass('d-none');
            }
        });
    });
</script>