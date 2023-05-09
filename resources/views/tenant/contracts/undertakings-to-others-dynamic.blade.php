<script>
    jQuery(($) => {
        var toOtherRow = `
            <div class="d-flex align-items-center mt-2 input-set">
                <div class="col-md-11">
                    <div class="input-group">
                        <x-form.input name="to_others[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="to_others[0][id]" value="NEW" hidden/>
                        <div class="input-group">
                            <div class="col-md-1 input-group-prepend">
                                <span class="input-group-text"> <span class="mx-auto index"></span> </span>
                            </div>
                            <div class="col-md-11">
                                <input type="text" name="to_others[0][provided_to]" class="form-control" style="margin-left: -1px; border-bottom-left-radius: 0; border-top-left-radius: 0;" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 text-center to-others-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light to-others-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add_to_other").click(function() {
            addSubToOtherRow(obj = "");
        });

        $(document).on('click', '.to-others-delete', function() {
            $(this).parent().parent().remove();
            $('.to-others-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-danger waves-effect waves-light to-others-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        function addSubToOtherRow(obj) {
            $('.to-others-delete').remove();
            let key = $('#to-others .input-set').last().find('.index').text();
            key = key ? parseInt(key) + 1 : 1;
            let newRow = $(toOtherRow);
            $('#to-others').append(newRow);
            newRow.find('.index').text(key);
            changeElemsIndexes($(newRow).find('select, input'), key);

            if (obj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(obj.id);
                newRow.find('input[name*=provided_to]').val(obj.provided_to);
            }
        }


        var toOthers = JSON.parse('<?php echo $undertakingsToOthers; ?>')
        toOthers.forEach(toOther => {
            addSubToOtherRow(toOther);
        });

    });
</script>