<script>
    jQuery(($) => {
        var completionDateRow = `
            <div class="d-flex align-items-center mt-2 input-set">
                <div class="col-md-11">
                    <div class="input-group">
                        <x-form.input name="section_compl_dates[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="section_compl_dates[0][id]" value="NEW" hidden/>
                        <div class="input-group">
                            <div class="col-md-1 input-group-prepend">
                                <span class="input-group-text"> <span class="mx-auto index"></span> </span>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="section_compl_dates[0][description]" class="form-control" style="margin-left: -1px; border-radius: 0;border-right-width:0">
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="section_compl_dates[0][completion_date]" class="form-control" style="margin-left: -1px; border-bottom-left-radius: 0; border-top-left-radius: 0;" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 text-center completion-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light completion-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add_completion_date").click(function() {
            addCompletionDateRow(obj = "");
        });

        $(document).on('click', '.completion-delete', function() {
            $(this).parent().parent().remove();
            $('.completion-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-danger waves-effect waves-light completion-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        function addCompletionDateRow(obj) {
            $('.completion-delete').remove();
            let key = $('#completion-dates .input-set').last().find('.index').text();
            key = key ? parseInt(key) + 1 : 1;
            let newRow = $(completionDateRow);
            $('#completion-dates').append(newRow);
            newRow.find('.index').text(key);
            changeElemsIndexes($(newRow).find('select, input'), key);

            if (obj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(obj.id);
                newRow.find('input[name*=description]').val(obj.description);
                newRow.find('input[name*=completion_date]').val(obj.completion_date);
            }
        }


        var completionDates = JSON.parse('<?php echo $completionDates; ?>')
        completionDates.forEach(completionDate => {
            addCompletionDateRow(completionDate);
        });

    });
</script>