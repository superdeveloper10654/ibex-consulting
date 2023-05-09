<script>
    jQuery(($) => {
        var itemRow = `
            <div class="d-flex align-items-center mt-2 input-set">
                <div class="col-md-11">
                    <div class="input-group">
                        <x-form.input name="pay_items[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="pay_items[0][id]" value="NEW" hidden/>
                        <div class="input-group">
                            <div class="col-md-1 input-group-prepend">
                                <span class="input-group-text"> <span class="mx-auto index"></span> </span>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="pay_items[0][item_or_activity]" class="form-control" style="border-bottom-right-radius: 0; border-top-right-radius: 0;">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="pay_items[0][other_currency]" class="form-control" style="margin-left: -1px; border-radius: 0;border-right-width:0">
                            </div>
                            <div class="col-md-5">
                                <input type="number" name="pay_items[0][total_max_payment]" class="form-control" style="margin-left: -1px; border-bottom-left-radius: 0; border-top-left-radius: 0;" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 text-center item-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light item-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add_item").click(function() {
            addItemRow(obj = "");
        });

        $(document).on('click', '.item-delete', function() {
            $(this).parent().parent().remove();
            $('.item-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-danger waves-effect waves-light item-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        function addItemRow(obj) {
            $('.item-delete').remove();
            let key = $('#pay-items .input-set').last().find('.index').text();
            key = key ? parseInt(key) + 1 : 1;
            let newRow = $(itemRow);
            $('#pay-items').append(newRow);
            newRow.find('.index').text(key);
            changeElemsIndexes($(newRow).find('select, input'), key);

            if (obj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(obj.id);
                newRow.find('input[name*=item_or_activity]').val(obj.item_or_activity);
                newRow.find('input[name*=other_currency]').val(obj.other_currency);
                newRow.find('input[name*=total_max_payment]').val(obj.total_max_payment);
            }
        }


        var payItems = JSON.parse('<?php echo $payItems; ?>')
        if (payItems.length == 0) {
            addItemRow();
        } else {
            payItems.forEach(payItem => {
                addItemRow(payItem);
            });
        }

    });
</script>