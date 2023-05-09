<script>
    if (typeof maybe_redirect === 'undefined') {
        maybe_redirect = '';
    }
    if (typeof unit_id === 'undefined') {
        unit_id = '';
    }

    jQuery(($) => {
        $(form).on('submit', function(e) {
            e.preventDefault();
            removeFormErrors(this);

            form_ajax($(this).attr('action'), this, {redirect: maybe_redirect});
        });

        refreshRowsByUnit(unit_id);

        $('[name=unit]').on('change', function() {
            refreshRowsByUnit(this.value);
        });

        function refreshRowsByUnit(unit = false)
        {
            $('[data-unit]').hide();
            $(`[data-unit] input`).attr('disabled', true);

            if (unit) {
                $(`[data-unit=${unit}]`).show();
                $(`[data-unit=${unit}] input`).attr('disabled', false);
            }
        }
    });
</script>