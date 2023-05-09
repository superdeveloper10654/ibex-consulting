<script>
    jQuery(($) => {
        var damageRow = `
            <div class="d-flex align-items-center mt-2 input-set">
                <div class="col-md-11">
                    <div class="input-group">
                        <x-form.input name="damages[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="damages[0][id]" value="NEW" hidden/>
                        <div class="input-group">
                            <div class="col-md-1 input-group-prepend">
                                <span class="input-group-text"> <span class="mx-auto index"></span> </span>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="damages[0][description]" class="form-control" style="margin-left: -1px; border-radius: 0;border-right-width:0">
                            </div>
                            <div class="col-md-3">
                                <input type="number" step=0.1 min=0 name="damages[0][amount_per_day]" class="form-control" style="margin-left: -1px; border-bottom-left-radius: 0; border-top-left-radius: 0;" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 text-center damage-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light damage-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add_delay_damage").click(function() {
            addDamageRow(obj = "");
        });

        $(document).on('click', '.damage-delete', function() {
            $(this).parent().parent().remove();
            $('.damage-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-danger waves-effect waves-light damage-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        function addDamageRow(obj) {
            $('.damage-delete').remove();
            let key = $('#delay-damages .input-set').last().find('.index').text();
            key = key ? parseInt(key) + 1 : 1;
            let newRow = $(damageRow);
            $('#delay-damages').append(newRow);
            newRow.find('.index').text(key);
            changeElemsIndexes($(newRow).find('select, input'), key);

            if (obj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(obj.id);
                newRow.find('input[name*=description]').val(obj.description);
                newRow.find('input[name*=amount_per_day]').val(obj.amount_per_day);
            }
        }


        var damages = JSON.parse('<?php echo $workSectionDelayDamages; ?>')
        damages.forEach(damage => {
            addDamageRow(damage);
        });

    });
</script>