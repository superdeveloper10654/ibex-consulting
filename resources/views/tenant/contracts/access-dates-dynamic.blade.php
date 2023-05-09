<script>
    jQuery(($) => {
        var newAccessDate = `
            <div class="d-flex align-items-center mt-2 input-set print-no-break">
                <div class="col-md-11">
                    <div class="input-group">
                        <x-form.input name="access_dates[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="access_dates[0][id]" value="NEW" hidden/>
                        <div class="input-group-prepend">
                            <span class="input-group-text index"></span>
                        </div>
                        <input type="text" name="access_dates[0][part_of_the_site]" class="form-control col-md-9" required>
                        <div class="input-group-append">
                            <input class="form-control" type="date" name="access_dates[0][date]" style="border-bottom-left-radius: 0; border-top-left-radius: 0;" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 text-center access-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-light waves-effect waves-light access-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add_access_date").click(function() {
            addAccessDateRow(accessDate = "");
        });

        $(document).on('click', '.access-delete', function() {
            $(this).parent().parent().remove();
            $('.access-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-light waves-effect waves-light access-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        function addAccessDateRow(accessDate) {
            $('.access-delete').remove();
            let key = $('#access-dates .input-set').last().find('.index').text();
            key = key ? parseInt(key) + 1 : 1;
            let newRow = $(newAccessDate);
            $('#access-dates').append(newRow);
            newRow.find('.index').text(key);
            changeElemsIndexes($(newRow).find('select, input'), key);

            if (accessDate) {
                newRow.find('input[name*=date]').not('input[name*=contract_id]').val(accessDate.date);
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(accessDate.id);
                newRow.find('input[name*=part_of_the_site]').val(accessDate.part_of_the_site);
            }
        }

        var accessDates = JSON.parse('<?php echo $accessDates; ?>')
        if (accessDates.length == 0) {
            addAccessDateRow(accessDate = "");
        } else {
            accessDates.forEach(accessDate => {
                addAccessDateRow(accessDate);
            });
        }

    });
</script>