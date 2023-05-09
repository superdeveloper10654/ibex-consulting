@push('script')
<script>
    jQuery(($) => {
        var measured_items = JSON.parse('{!! json_encode($rate_cards) !!}');
        var cloned = $('#payment_table tr:last').clone();
        console.log(measured_items);
        $(".add-row").click(function(e) {
            e.preventDefault();
            let new_line = cloned.clone();
            changeElemsIndexes(new_line.find('[name^="items[0]"]'), $('#payment_table tbody tr').length)
            new_line.find('input, select').val('');
            new_line.appendTo('#payment_table');
        });

        calculateTotal();

        $('#payment_table').on('change keyup paste', 'input[type=number]', function() {
            updateTotals(this);
            calculateTotal();
        });

        $('#payment_table').on('change', 'select[name$="[rate_card_id]"]', function() {
            updateMeasuredLineData($(this));
        });

        function updateTotals(elem)
        {
            let tr = $(elem).closest('tr');
            let quantity = $('[name$="[qty]"]', tr).val();
            let rate = $('[name$="[rate]"]', tr).val();
            let calc_sum = parseInt(quantity) * parseFloat(rate);
            let sum = $('[name$="[sum]"]', tr).val(calc_sum.toFixed(2));
            let subtotal = parseInt(quantity) * parseFloat(rate);
            $('[name$="[sum]"]', tr).val(subtotal.toFixed(2));

        }

        function calculateTotal()
        {
            var grandTotal = 0;
            var totalQuantity = 0;
            $('#payment_table [name$="[sum]"]').each(function() {
                grandTotal += parseFloat($(this).val());
            });

            $('#payment_sub_total').val(grandTotal.toFixed(2));
        }

        function updateMeasuredLineData(measured_item_select)
        {
            let item = measured_items.find((item) => item.id == measured_item_select.val());
            let line = measured_item_select.closest('tr');
            line.find('[name$="[qty]"]').val(1);
            line.find('[name$="[rate]"]').val(item.rate);
            line.find('[name$="[sum]"]').val(item.rate.toFixed(2));
            calculateTotal();
        }
    });
</script>
@endpush