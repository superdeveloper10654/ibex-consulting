<script>
    jQuery(($) => {
        var accountingPeriodRow = `
            <div class="d-flex align-items-center mt-2 input-set">
                <div class="col-md-11">
                    <div class="input-group">
                        <x-form.input name="accountings[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="accountings[0][id]" value="NEW" hidden/>
                        <div class="input-group">
                            <div class="col-md-1 input-group-prepend">
                                <span class="input-group-text"> <span class="mx-auto index"></span> </span>
                            </div>
                            <div class="col-md-11">
                                <input type="text" name="accountings[0][period]" class="form-control" style="margin-left: -1px; border-bottom-left-radius: 0; border-top-left-radius: 0;" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 text-center accounting-period-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light accounting-period-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add_accounting_period").click(function() {
            addAccountingPeriodRow(obj = "");
        });

        $(document).on('click', '.accounting-period-delete', function() {
            $(this).parent().parent().remove();
            $('.accounting-period-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-danger waves-effect waves-light accounting-period-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        function addAccountingPeriodRow(obj) {
            $('.accounting-period-delete').remove();
            let key = $('#accounting-periods .input-set').last().find('.index').text();
            key = key ? parseInt(key) + 1 : 1;
            let newRow = $(accountingPeriodRow);
            $('#accounting-periods').append(newRow);
            newRow.find('.index').text(key);
            changeElemsIndexes($(newRow).find('select, input'), key);

            if (obj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(obj.id);
                newRow.find('input[name*=period]').val(obj.period);
            }
        }


        var accountingPeriods = JSON.parse('<?php echo $accountingPeriods; ?>')
        if (accountingPeriods.length == 0) {
            addAccountingPeriodRow(obj = "");
        } else {
            accountingPeriods.forEach(accountingPeriod => {
                addAccountingPeriodRow(accountingPeriod);
            });
        }
    });
</script>