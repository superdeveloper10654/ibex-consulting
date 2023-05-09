<script>
    jQuery(($) => {
       
        var newDailySubcontractOrClientOperation = `
            <div class="row mb-3 mb-md-1 line" id="measured_items">
                <x-form.input name="dailySubcontractOrClientOperations[0][id]" value="NEW" hidden/>
                <x-form.input name="dailySubcontractOrClientOperations[0][daily_work_record_id]" value="{{$dailyWorkRecordId}}" hidden/>
                <div class="col-md-1 mb-2">
                    <x-form.input name="dailySubcontractOrClientOperations[0][no]" class="act-no" readonly/>
                </div>
                <div class="col-md-4 mb-2">
                <x-form.select  name="dailySubcontractOrClientOperations[0][subcontract_or_client_operation_id]" :options="$subcontractOrClientOperationOptions->pluck('subbie_name', 'id')" />
                </div>
                <div class="col-md-3 mb-2">
                <x-form.select  name="dailySubcontractOrClientOperations[0][operation_id]" :options="$operationOptions->pluck('name', 'id')" />
                </div>
                <div class="col-md-3 mb-2">
                <x-form.input name="dailySubcontractOrClientOperations[0][comments]" class="comments"/>
                </div>
                <div class="col-md-1 mb-2 text-center">
                    <button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;
        
        var newDailyOrderedOrSuppliedMaterial = `
            <div class="row mb-3 mb-md-1 line" id="measured_items">
                <x-form.input name="dailyOrderedOrSuppliedMaterials[0][id]" value="NEW" hidden/>
                <x-form.input name="dailyOrderedOrSuppliedMaterials[0][daily_work_record_id]" value="{{$dailyWorkRecordId}}" hidden/>
                <div class="col-md-3 mb-2">
                <x-form.select  name="dailyOrderedOrSuppliedMaterials[0][material_id]" :options="$materialOptions->pluck('name', 'id')" required/>
                </div>
                <div class="col-md-2 mb-2">
                <x-form.input type="number" name="dailyOrderedOrSuppliedMaterials[0][prog]" class="prog" required/>
                </div>
                <div class="col-md-2 mb-2">
                <x-form.input type="number" name="dailyOrderedOrSuppliedMaterials[0][on_site]" class="onsite" required/>
                </div>
                <div class="col-md-2 mb-2">
                <x-form.input type="number" name="dailyOrderedOrSuppliedMaterials[0][supplied]" class="supplied" required/>
                </div>
                <div class="col-md-2 mb-2">
                <x-form.input type="textArea" name="dailyOrderedOrSuppliedMaterials[0][comments]" class="comments"/>
                </div>
                <div class="col-md-1 mb-2 text-center">
                    <button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;
            var newDailyWeatherCondition = `
            <div class="row mb-3 mb-md-1 line" id="measured_items">
                <x-form.input name="dailyWeatherConditions[0][id]" value="NEW" hidden/>
                <x-form.input name="dailyWeatherConditions[0][daily_work_record_id]" value="{{$dailyWorkRecordId}}" hidden/>
               
                <div class="col-md-3 mb-2">
                <x-form.input type="time" name="dailyWeatherConditions[0][time]" class="time" required/>
                </div>
                <div class="col-md-2 mb-2">
                <x-form.input name="dailyWeatherConditions[0][observation]" class="observation" required/>
                </div>
                <div class="col-md-2 mb-2">
                <x-form.input type="number" name="dailyWeatherConditions[0][air]" class="air" required/>
                </div>
                <div class="col-md-2 mb-2">
                <x-form.input  name="dailyWeatherConditions[0][ground]" class="ground"/>
                </div>
                <div class="col-md-2 mb-2">
                <x-form.input name="dailyWeatherConditions[0][wind]" class="wind"/>
                </div>
                <div class="col-md-1 mb-2 text-center">
                    <button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;
        $("#btn_dailySubcontractOrClientOperations_add").click(function() {
            addDailySubcontractOrClientOperationRow();
        });
        $("#btn_dailyOrderedOrSuppliedMaterials_add").click(function() {
            addDailyOrderedOrSuppliedMaterialRow();
        });
        $("#btn_dailyWeatherConditions_add").click(function() {
            addDailyWeatherConditionRow();
        });

        $(document).on('click', '.btn_delete', function() {
            $(this).parent().parent().remove();
        });
        
        $(document).on('keyup', '.prog', function() {
            var total = 0;

            $(".prog").each(function() {
                if (parseFloat($(this).val()) > 0) {
                    total += parseFloat($(this).val());
                }
            });
            $("#sumOfProg").val(total.toFixed(2));
        })
        $(document).on('keyup', '.onsite', function() {
            var total = 0;

            $(".onsite").each(function() {
                if (parseFloat($(this).val()) > 0) {
                    total += parseFloat($(this).val());
                }
            });
            $("#sumOfOnsite").val(total.toFixed(2));
        })
        $(document).on('keyup', '.supplied', function() {
            var total = 0;

            $(".supplied").each(function() {
                if (parseFloat($(this).val()) > 0) {
                    total += parseFloat($(this).val());
                }
            });
            $("#sumOfSupplied").val(total.toFixed(2));
        })

        function addDailySubcontractOrClientOperationRow(alreadyHaveObj = "")
        {
            let newRow = $(newDailySubcontractOrClientOperation);
            $("#dailySubcontractOrClientOperations-container").append(newRow);
            let new_key = $("#dailySubcontractOrClientOperations-container .line").length;
            changeElemsIndexes($(newRow).find('select, input'), new_key);
            newRow.find('input[name*=no]').val(new_key);
            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=daily_work_record_id]').val(alreadyHaveObj.daily_work_record_id);
                newRow.find('select[name*=subcontract_or_client_operation_id]').val(alreadyHaveObj.subcontract_or_client_operation_id);
                newRow.find('select[name*=operation_id]').val(alreadyHaveObj.operation_id);
                newRow.find('input[name*=comments]').val(alreadyHaveObj.comments);
            }
        }
        
        var dailySubcontractOrClientOperations = JSON.parse('<?php echo $createdDailySubcontractOrClientOperations; ?>')
        console.log(dailySubcontractOrClientOperations)
       
        for (let i = 0; i < dailySubcontractOrClientOperations.length; i++) {
            let obj = dailySubcontractOrClientOperations[i];
            addDailySubcontractOrClientOperationRow(obj);
        }


    //    dailyOrderedOrSuppliedMaterials
        function addDailyOrderedOrSuppliedMaterialRow(alreadyHaveObj = "")
        {
            let newRow = $(newDailyOrderedOrSuppliedMaterial);
            $("#dailyOrderedOrSuppliedMaterials-container").append(newRow);
            let new_key = $("#dailyOrderedOrSuppliedMaterials-container .line").length;
            changeElemsIndexes($(newRow).find('select, input'), new_key);
            newRow.find('input[name*=no]').val(new_key);
            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=daily_work_record_id]').val(alreadyHaveObj.daily_work_record_id);
                newRow.find('select[name*=material_id]').val(alreadyHaveObj.material_id);
                newRow.find('input[name*=prog]').val(alreadyHaveObj.prog).trigger('keyup');
                newRow.find('input[name*=on_site]').val(alreadyHaveObj.on_site).trigger('keyup');
                newRow.find('input[name*=supplied]').val(alreadyHaveObj.supplied).trigger('keyup');
                newRow.find('input[name*=comments]').val(alreadyHaveObj.comments);
            }
        }
        
        var dailyOrderedSuppliedMaterials = JSON.parse('<?php echo $createdDailyOrderedSuppliedMaterials; ?>')
        console.log(dailyOrderedSuppliedMaterials)
       
        for (let i = 0; i < dailyOrderedSuppliedMaterials.length; i++) {
            let obj = dailyOrderedSuppliedMaterials[i];
            addDailyOrderedOrSuppliedMaterialRow(obj);
        }

        // dailyWeatherConditions  
        function addDailyWeatherConditionRow(alreadyHaveObj = "")
        {
            let newRow = $(newDailyWeatherCondition);
            $("#dailyWeatherConditions-container").append(newRow);
            let new_key = $("#dailyWeatherConditions-container .line").length;
            changeElemsIndexes($(newRow).find('select, input'), new_key);
            newRow.find('input[name*=no]').val(new_key);
            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=daily_work_record_id]').val(alreadyHaveObj.daily_work_record_id);
                newRow.find('input[name*=time]').val(alreadyHaveObj.time);
                newRow.find('input[name*=observation]').val(alreadyHaveObj.observation);
                newRow.find('input[name*=air]').val(alreadyHaveObj.air);
                newRow.find('input[name*=ground]').val(alreadyHaveObj.ground);
                newRow.find('input[name*=wind]').val(alreadyHaveObj.wind);
            }
        }

        var dailyWeatherConditions = JSON.parse('<?php echo $createdDailyWeatherConditions; ?>')
        console.log(dailyWeatherConditions)
       
        for (let i = 0; i < dailyWeatherConditions.length; i++) {
            let obj = dailyWeatherConditions[i];
            addDailyWeatherConditionRow(obj);
        }
        
    });

</script>