<script>
    jQuery(($) => {
        var workConditionRow = `
            <div class="d-flex align-items-center mt-2 input-set print-no-break">
                <div class="col-md-11">
                    <div class="input-group">
                        <x-form.input name="work_cond[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="work_cond[0][id]" value="NEW" hidden/>
                        <div class="input-group-prepend">
                            <span class="input-group-text index">1</span>
                        </div>
                        <input type="text" name="work_cond[0][condition]" class="form-control" required>
                        <div class="input-group-append">
                            <input class="form-control" type="date" name="work_cond[0][key_date]" style="border-bottom-left-radius: 0; border-top-left-radius: 0;" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 text-center condition-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-light waves-effect waves-light condition-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add_condition").click(function() {
            addWorkConditionRow(workCondition = "");
        });

        $(document).on('click', '.condition-delete', function() {
            $(this).parent().parent().remove();
            $('.condition-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-light waves-effect waves-light condition-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        function addWorkConditionRow(workCondition) {
            $('.condition-delete').remove();
            let key = $('#conditions .input-set').last().find('.index').text();
            key = key ? parseInt(key) + 1 : 1;
            let newRow = $(workConditionRow);
            $('#conditions').append(newRow);
            newRow.find('.index').text(key);
            changeElemsIndexes($(newRow).find('select, input'), key);

            if (workCondition) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(workCondition.id);
                newRow.find('input[name*=condition]').val(workCondition.condition);
                newRow.find('input[name*=key_date]').val(workCondition.key_date);
            }
        }

        var workConditions = JSON.parse('<?php echo $workConditions; ?>')
        if (workConditions.length == 0) {
            addWorkConditionRow()
        } else {
            workConditions.forEach(workCondition => {
                addWorkConditionRow(workCondition);
            });
        }

    });
</script>