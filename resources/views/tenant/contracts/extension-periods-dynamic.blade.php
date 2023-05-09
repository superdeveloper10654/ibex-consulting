<script>
    jQuery(($) => {
        var extensionPeriodRow = `
            <div class="d-flex align-items-center mt-2 input-set">
                <div class="col-md-11">
                    <div class="input-group">
                        <x-form.input name="extensions[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="extensions[0][id]" value="NEW" hidden/>
                        <div class="input-group">
                            <div class="col-md-1 input-group-prepend">
                                <span class="input-group-text"> <span class="mx-auto index"></span> </span>
                            </div>
                            <div class="col-md-8">
                                <input type="number" min=0 name="extensions[0][period]" class="form-control" style="margin-left: -1px; border-radius: 0;border-right-width:0">
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="extensions[0][notice_date]" class="form-control" style="margin-left: -1px; border-bottom-left-radius: 0; border-top-left-radius: 0;" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 text-center extension-period-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light extension-period-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add_extension_period").click(function() {
            addExtensionPeriodRow(obj = "");
        });

        $(document).on('click', '.extension-period-delete', function() {
            $(this).parent().parent().remove();
            $('.extension-period-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-danger waves-effect waves-light extension-period-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        function addExtensionPeriodRow(obj) {
            $('.extension-period-delete').remove();
            let key = $('#extension-periods .input-set').last().find('.index').text();
            key = key ? parseInt(key) + 1 : 1;
            let newRow = $(extensionPeriodRow);
            $('#extension-periods').append(newRow);
            newRow.find('.index').text(key);
            changeElemsIndexes($(newRow).find('select, input'), key);

            if (obj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(obj.id);
                newRow.find('input[name*=period]').val(obj.period);
                newRow.find('input[name*=notice_date]').val(obj.notice_date);
            }
        }


        var extensionPeriods = JSON.parse('<?php echo $extensionPeriods; ?>')
        if (extensionPeriods.length == 0) {
            addExtensionPeriodRow();
        } else {
            extensionPeriods.forEach(extensionPeriod => {
                addExtensionPeriodRow(extensionPeriod);
            });
        }

    });
</script>