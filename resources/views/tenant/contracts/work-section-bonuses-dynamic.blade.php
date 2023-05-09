<script>
    jQuery(($) => {
        var bonusRow = `
            <div class="d-flex align-items-center mt-2 input-set">
                <div class="col-md-11">
                    <div class="input-group">
                        <x-form.input name="bonuses[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="bonuses[0][id]" value="NEW" hidden/>
                        <div class="input-group">
                            <div class="col-md-1 input-group-prepend">
                                <span class="input-group-text"> <span class="mx-auto index"></span> </span>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="bonuses[0][description]" class="form-control" style="margin-left: -1px; border-radius: 0;border-right-width:0">
                            </div>
                            <div class="col-md-3">
                                <input type="number" step=0.1 min=0 name="bonuses[0][amount_per_day]" class="form-control" style="margin-left: -1px; border-bottom-left-radius: 0; border-top-left-radius: 0;" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 text-center bonus-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light bonus-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add_bonus").click(function() {
            addBonusRow(obj = "");
        });

        $(document).on('click', '.bonus-delete', function() {
            $(this).parent().parent().remove();
            $('.bonus-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-danger waves-effect waves-light bonus-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        function addBonusRow(obj) {
            $('.bonus-delete').remove();
            let key = $('#bonuses .input-set').last().find('.index').text();
            key = key ? parseInt(key) + 1 : 1;
            let newRow = $(bonusRow);
            $('#bonuses').append(newRow);
            newRow.find('.index').text(key);
            changeElemsIndexes($(newRow).find('select, input'), key);

            if (obj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(obj.id);
                newRow.find('input[name*=description]').val(obj.description);
                newRow.find('input[name*=amount_per_day]').val(obj.amount_per_day);
            }
        }


        var bonuses = JSON.parse('<?php echo $workSectionBonuses; ?>')
        bonuses.forEach(bonus => {
            addBonusRow(bonus);
        });

    });
</script>