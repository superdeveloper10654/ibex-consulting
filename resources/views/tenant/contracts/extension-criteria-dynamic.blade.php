<script>
    jQuery(($) => {
        var criteriaRow = `
            <div class="d-flex align-items-center mt-2 input-set">
                <div class="col-md-11">
                    <div class="input-group">
                        <x-form.input name="extension_crite[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="extension_crite[0][id]" value="NEW" hidden/>
                        <div class="input-group">
                            <div class="col-md-1 input-group-prepend">
                                <span class="input-group-text"> <span class="mx-auto index"></span> </span>
                            </div>
                            <div class="col-md-11">
                                <input type="text" name="extension_crite[0][criteria]" class="form-control" style="margin-left: -1px; border-bottom-left-radius: 0; border-top-left-radius: 0;" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 text-center extension-criteria-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light extension-criteria-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add_extension_criteria").click(function() {
            addCriteriaRow(obj = "");
        });

        $(document).on('click', '.extension-criteria-delete', function() {
            $(this).parent().parent().remove();
            $('.extension-criteria-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-danger waves-effect waves-light extension-criteria-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        function addCriteriaRow(obj) {
            $('.extension-criteria-delete').remove();
            let key = $('#extension-criteria .input-set').last().find('.index').text();
            key = key ? parseInt(key) + 1 : 1;
            let newRow = $(criteriaRow);
            $('#extension-criteria').append(newRow);
            newRow.find('.index').text(key);
            changeElemsIndexes($(newRow).find('select, input'), key);

            if (obj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(obj.id);
                newRow.find('input[name*=criteria]').val(obj.criteria);
            }
        }


        var extensionCriteria = JSON.parse('<?php echo $extensionCriteria; ?>')
        if (extensionCriteria.length == 0) {
            addCriteriaRow();
        } else {
            extensionCriteria.forEach(criteria => {
                addCriteriaRow(criteria);
            });
        }

    });
</script>