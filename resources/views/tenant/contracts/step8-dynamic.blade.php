<script>
    jQuery(($) => {
        var newAdditionalEmployerRisk = `
            <div class="row new-risk new-row align-items-center mt-3">
                <div class="col-md-11">
                    <div class="input-group additional_employer_risk">
                        <x-form.input name="additional_empr[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="additional_empr[0][provider]" hidden/>
                        <x-form.input name="additional_empr[0][id]" value="NEW" hidden/>
                            <div class="input-group-prepend">
                                <span class="input-group-text input-group-number"></span>
                            </div>
                            <input type="text" name="additional_empr[0][risk]" class="form-control required">
                    </div>
                </div>
                <div class="col-md-1 delete-row-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light delete-row"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_employer_risk_add").click(function() {
            addAdditionalEmployerRisk(alreadyHaveObj = "", provider = "employer/client");
        });

        $("#btn_contractor_risk_add").click(function() {
            addAdditionalEmployerRisk(alreadyHaveObj = "", provider = "contractor");
        });

        $(document).on('click', '.delete-row', function() {
            $(this).closest('.new-row').prev('.new-row').find('.delete-row-section').append(
                `<button type="button" class="btn-rounded btn btn-danger waves-effect waves-light delete-row"><i class="bx bx-trash"></i></button>`
            );
            $(this).closest('.new-row').remove();
        });

        let riskIndex = 0;

        function addAdditionalEmployerRisk(alreadyHaveObj = "", provider = "employer/client") {
            let newRow = $(newAdditionalEmployerRisk);
            let element_id = provider == 'contractor' ? 'additional-contractor-risks' : 'additional-risks';
            $('#' + element_id + ' .new-row').find('.delete-row').remove();
            $("#" + element_id).append(newRow);

            let new_key = $('#' + element_id).children().length;
            newRow.find('.input-group-number').text(new_key);
            changeElemsIndexes($(newRow).find('select, input'), ++riskIndex);

            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=risk]').val(alreadyHaveObj.risk);
            }

            newRow.find('input[name*=provider]').val(provider);
        }

        var additionalEmployerRisks = JSON.parse('<?php echo $createdAdditionalEmployerRisks; ?>')

        additionalEmployerRisks.forEach(additionalEmployerRisk => {
            addAdditionalEmployerRisk(additionalEmployerRisk, additionalEmployerRisk.provider);
        });

        if ($('#additional-risks .new-row').length == 0) {
            addAdditionalEmployerRisk(alreadyHaveObj = "", provider = 'employer/client');
        }

        if ($('#additional-contractor-risks .new-row').length == 0) {
            addAdditionalEmployerRisk(alreadyHaveObj = "", provider = 'contractor');
        }

        let insuranceIndex = 0;

        var newInsurance = `
            <div class="new-insurance new-row">
                <x-form.input name="new_insurance[0][contract_id]" value="{{$id}}" hidden/>
                <x-form.input name="new_insurance[0][id]" value="NEW" hidden/>
                <x-form.input name="new_insurance[0][is_additional]"  hidden/>
                <x-form.input name="new_insurance[0][provider]" hidden/>
                <div class="input-group mt-3 mb-3">
                    <div class="input-group mt-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-group-number"></span>
                        </div>
                        <div class="input-group-prepend">
                            <span class="input-group-text">Insurances against</span>
                        </div>
                        <input type="text" name="new_insurance[0][insurance_against]" class="form-control">
                    </div>
                    <div class="input-group mt-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-group-number"></span>
                        </div>
                        <div class="input-group-prepend">
                            <span class="input-group-text">Cover/indemnity is</span>
                        </div>
                        <input name="new_insurance[0][cover_or_indemnity]" type="text" class="form-control">
                    </div>
                    <div class="input-group mt-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-group-number"></span>
                        </div>
                        <div class="input-group-prepend">
                            <span class="input-group-text">The deductibles are</span>
                        </div>
                        <input name="new_insurance[0][deductibles]" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-12 text-end delete-row-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light delete-row"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add_insurance").click(function() {
            addInsurance(alreadyHaveObj = "", is_additional = 0, provider = 'employer/client');
        });

        $("#btn_add_insurance1").click(function() {
            addInsurance(alreadyHaveObj = "", is_additional = 1, provider = 'employer/client');
        });

        $("#btn_add_insurance2").click(function() {
            addInsurance(alreadyHaveObj = "", is_additional = 1, provider = 'contractor');
        });


        function addInsurance(alreadyHaveObj = "", is_additional, provider) {
            let element_id = is_additional == 0 ? 'new-insurance' : (provider == 'contractor' ? 'new-contr-add-insurance' : 'new-emp-add-insurance');
            $('#' + element_id + ' .new-row').find('.delete-row').remove();
            let newRow = $(newInsurance);
            $('#' + element_id).append(newRow);
            let new_key = $('#' + element_id).children().length;
            newRow.find('.input-group-number').text(new_key);
            changeElemsIndexes($(newRow).find('select, input'), ++insuranceIndex);

            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=insurance_against]').val(alreadyHaveObj.insurance_against);
                newRow.find('input[name*=cover_or_indemnity]').val(alreadyHaveObj.cover_or_indemnity);
                newRow.find('input[name*=deductibles]').val(alreadyHaveObj.deductibles);
            }

            newRow.find('input[name*=is_additional]').val(is_additional);
            newRow.find('input[name*=provider]').val(provider);

        }

        var insurances = JSON.parse('<?php echo $createdInsurances; ?>')
        insurances.forEach(insurance => {
            addInsurance(insurance, is_additional = insurance.is_additional, provider = insurance.provider);
        });

        if ($('#new-insurance .new-row').length == 0) {
            addInsurance(alreadyHaveObj = "", is_additional = 0, provider = 'employer/client');
        }

        if ($('#new-emp-add-insurance .new-row').length == 0) {
            addInsurance(alreadyHaveObj = "", is_additional = 1, provider = 'employer/client');
        }

        if ($('#new-contr-add-insurance .new-row').length == 0) {
            addInsurance(alreadyHaveObj = "", is_additional = 1, provider = 'contractor');
        }
    });
</script>