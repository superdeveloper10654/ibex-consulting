<script>
    jQuery(($) => {
        var factorRow = `
            <div class="d-flex align-items-center mt-2 input-set">
                <div class="col-md-11">
                    <div class="input-group">
                        <x-form.input name="paf[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="paf[0][id]" value="NEW" hidden/>
                        <x-form.input name="paf[0][is_non_adjustable]" value=0 hidden/>
                        <div class="input-group-prepend d-none">
                            <span class="input-group-text index">The <i>&nbsp;period for reply&nbsp;</i> for </span>
                        </div>
                        <div class="input-group-prepend">
                            <input name="paf[0][proportion]" type="number" step="0.01" min="0" class="form-control" style="border-bottom-right-radius: 0; border-top-right-radius: 0; width: 100px;" required>
                        </div>
                        <div class="input-group-prepend">
                            <span class="input-group-text non-adjustable">linked to the index for</span>
                        </div>
                        <input name="paf[0][factor]" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-1 text-center price-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light price-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add_price_adj").click(function() {
            addFactorRow(obj = "");
        });

        $(document).on('click', '.price-delete', function() {
            $(this).parent().parent().remove();
            $('.price-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-danger waves-effect waves-light price-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        function addFactorRow(obj) {
            $('.price-delete').remove();
            let key = $('#price-adjustment-factors .input-set').last().find('.index').text();
            key = key ? parseInt(key) + 1 : 1;
            let newRow = $(factorRow);
            $('#price-adjustment-factors').append(newRow);
            newRow.find('.index').text(key);
            changeElemsIndexes($(newRow).find('select, input'), key);

            if (obj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(obj.id);
                newRow.find('input[name*=proportion]').val(obj.proportion);
                newRow.find('input[name*=factor]').val(obj.factor);
            }
        }


        var priceAdjustmentFactors = JSON.parse('<?php echo $priceAdjustmentFactors; ?>')
        if (priceAdjustmentFactors.length == 0) {
            addFactorRow();
        } else {
            priceAdjustmentFactors.forEach(priceAdjustmentFactor => {
                addFactorRow(priceAdjustmentFactor);
            });
        }

    });
</script>