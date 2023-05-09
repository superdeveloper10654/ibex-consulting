<script>
    jQuery(($) => {
        var lowPerformanceDamageRow = `
            <div class="d-flex align-items-center mt-2 input-set">
                <div class="col-md-11">
                    <div class="input-group">
                        <x-form.input name="low_perform_damages[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="low_perform_damages[0][id]" value="NEW" hidden/>
                        <div class="input-group">
                            <div class="col-md-1 input-group-prepend">
                                <span class="input-group-text"> <span class="mx-auto index"></span> </span>
                            </div>
                            <div class="col-md-4">
                                <input type="number" step=0.1 min=0 name="low_perform_damages[0][amount]" class="form-control" style="margin-left: -1px; border-radius: 0;border-right-width:0" >
                            </div>
                            <div class="col-md-1 input-group-prepend">
                                <span class="input-group-text"> for </span>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="low_perform_damages[0][performance_level]" class="form-control" style="margin-left: -1px; border-bottom-left-radius: 0; border-top-left-radius: 0;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 text-center low-perform-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light low-perform-damage-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add_low_perform_damage").click(function() {
            addLowPerformanceDamageRow(obj = "");
        });

        $(document).on('click', '.low-perform-damage-delete', function() {
            $(this).parent().parent().remove();
            $('.low-perform-damage-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-danger waves-effect waves-light low-perform-damage-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        function addLowPerformanceDamageRow(obj) {
            $('.low-perform-damage-delete').remove();
            let key = $('#low-perform-damages .input-set').last().find('.index').text();
            key = key ? parseInt(key) + 1 : 1;
            let newRow = $(lowPerformanceDamageRow);
            $('#low-perform-damages').append(newRow);
            newRow.find('.index').text(key);
            changeElemsIndexes($(newRow).find('select, input'), key);

            if (obj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(obj.id);
                newRow.find('input[name*=performance_level]').val(obj.performance_level);
                newRow.find('input[name*=amount]').val(obj.amount);
            }
        }


        var lowPerformanceDamageAmounts = JSON.parse('<?php echo $lowPerformanceDamageAmounts; ?>')
        if (lowPerformanceDamageAmounts.length == 0) {
            addLowPerformanceDamageRow();
        } else {
            lowPerformanceDamageAmounts.forEach(damage => {
                addLowPerformanceDamageRow(damage);
            });
        }

    });
</script>