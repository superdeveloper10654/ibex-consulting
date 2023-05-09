<script>
    jQuery(($) => {
        var defectExceptPeriodRow = `
<x-form.input name="defect_except_periods[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="defect_except_periods[0][id]" value="NEW" hidden/>
            <div class="d-flex align-items-center mt-2 input-set">
                <div class="col-md-11">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text index"></span>
                        </div>
                        <div class="input-group-prepend">
                            <span class="input-group-text">The <i>&nbsp;defect correction period &nbsp;</i> for</span>
                        </div>
                        <div class="input-group-prepend col">
                        <x-form.input type="text" name="defect_except_periods[0][period_for]" class="form-control" style="border-radius: 0"/>
                        </div>
                        <div class="input-group-prepend">
                            <span class="input-group-text">is</span>
                        </div>
                         <div class="input-group-prepend">
                        <x-form.input type="number" min=0 name="defect_except_periods[0][period_is]" style="border-radius: 0; width: 100px;"/>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">weeks</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 text-center defect-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-light waves-effect waves-light defect-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add").click(function() {
            addDefectExceptPeriodRow(defectExceptPeriod = "");
        });

        $(document).on('click', '.defect-delete', function() {
            $(this).parent().parent().remove();
            $('.defect-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-light waves-effect waves-light defect-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        function addDefectExceptPeriodRow(defectExceptPeriod) {
            $('.defect-delete').remove();
            let key = $('#except-periods .input-set').last().find('.index').text();
            key = key ? parseInt(key) + 1 : 1;
            let newRow = $(defectExceptPeriodRow);
            $('#except-periods').append(newRow);
            newRow.find('.index').text(key);
            changeElemsIndexes($(newRow).find('select, input'), key);

            if (defectExceptPeriod) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(defectExceptPeriod.id);
                newRow.find('input[name*=period_for]').val(defectExceptPeriod.period_for);
                newRow.find('input[name*=period_is]').val(defectExceptPeriod.period_is);
            }
        }

        var defectExceptPeriods = JSON.parse('<?php echo $defectExceptPeriods; ?>')
        if (defectExceptPeriods.length == 0) {
            addDefectExceptPeriodRow();
        } else {
            defectExceptPeriods.forEach(defectExceptPeriod => {
                addDefectExceptPeriodRow(defectExceptPeriod);
            });
        }

    });
</script>