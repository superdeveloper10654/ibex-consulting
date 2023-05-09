<script>
    jQuery(($) => {
        var subToOtherRow = `
            <div class="d-flex align-items-center mt-2 input-set">
                <div class="col-md-11">
                    <div class="input-group">
                        <x-form.input name="sub_to_others[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="sub_to_others[0][id]" value="NEW" hidden/>
                        <div class="input-group">
                            <div class="col-md-1 input-group-prepend">
                                <span class="input-group-text"> <span class="mx-auto index"></span> </span>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="sub_to_others[0][work]" class="form-control" style="margin-left: -1px; border-radius: 0;border-right-width:0">
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="sub_to_others[0][provided_to]" class="form-control" style="margin-left: -1px; border-bottom-left-radius: 0; border-top-left-radius: 0;" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 text-center sub-to-others-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light sub-to-others-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add_sub_to_other").click(function() {
            addSubToOtherRow(obj = "");
        });

        $(document).on('click', '.sub-to-others-delete', function() {
            $(this).parent().parent().remove();
            $('.sub-to-others-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-danger waves-effect waves-light sub-to-others-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        function addSubToOtherRow(obj) {
            $('.sub-to-others-delete').remove();
            let key = $('#sub-to-others .input-set').last().find('.index').text();
            key = key ? parseInt(key) + 1 : 1;
            let newRow = $(subToOtherRow);
            $('#sub-to-others').append(newRow);
            newRow.find('.index').text(key);
            changeElemsIndexes($(newRow).find('select, input'), key);

            if (obj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(obj.id);
                newRow.find('input[name*=work]').val(obj.work);
                newRow.find('input[name*=provided_to]').val(obj.provided_to);
            }
        }


        var subToOthers = JSON.parse('<?php echo $subcontractorUndertakingsToOthers; ?>')
        subToOthers.forEach(subToOther => {
            addSubToOtherRow(subToOther);
        });

    });
</script>