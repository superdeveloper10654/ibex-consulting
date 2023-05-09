<script>
    jQuery(($) => {
        var benificiaryTermRow = `
            <div class="d-flex align-items-center mt-2 input-set">
                <div class="col-md-11">
                    <div class="input-group">
                        <x-form.input name="benificiaries[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="benificiaries[0][id]" value="NEW" hidden/>
                        <div class="input-group">
                            <div class="col-md-1 input-group-prepend">
                                <span class="input-group-text"> <span class="mx-auto index"></span> </span>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="benificiaries[0][term]" class="form-control" style="margin-left: -1px; border-radius: 0;border-right-width:0">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="benificiaries[0][benificiary]" class="form-control" style="margin-left: -1px; border-bottom-left-radius: 0; border-top-left-radius: 0;" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 text-center benificiary-term-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light benificiary-term-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add_benificiary_term").click(function() {
            addBenificiaryTermRow(obj = "");
        });

        $(document).on('click', '.benificiary-term-delete', function() {
            $(this).parent().parent().remove();
            $('.benificiary-term-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-danger waves-effect waves-light benificiary-term-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        function addBenificiaryTermRow(obj) {
            $('.benificiary-term-delete').remove();
            let key = $('#benificiary-terms .input-set').last().find('.index').text();
            key = key ? parseInt(key) + 1 : 1;
            let newRow = $(benificiaryTermRow);
            $('#benificiary-terms').append(newRow);
            newRow.find('.index').text(key);
            changeElemsIndexes($(newRow).find('select, input'), key);

            if (obj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(obj.id);
                newRow.find('input[name*=term]').val(obj.term);
                newRow.find('input[name*=benificiary]').val(obj.benificiary);
            }
        }


        var benificiaryTerms = JSON.parse('<?php echo $benificiaryTerms; ?>')
        if (benificiaryTerms.length == 0) {
            addBenificiaryTermRow(obj = "");
        } else {
            benificiaryTerms.forEach(benificiaryTerm => {
                addBenificiaryTermRow(benificiaryTerm);
            });
        }
    });
</script>