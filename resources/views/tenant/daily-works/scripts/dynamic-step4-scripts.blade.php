<script>
    jQuery(($) => {
       
            var newDailyOperationalTimingOperation = `
            <div class="row mb-3 mb-md-1 line" id="measured_items">
                <x-form.input name="dailyOperationalTimingOperations[0][id]" value="NEW" hidden/>
                <x-form.input name="dailyOperationalTimingOperations[0][daily_work_record_id]" value="{{$dailyWorkRecordId}}" hidden/>
                <div class="col-md-4 mb-2">
                <x-form.select  name="dailyOperationalTimingOperations[0][operation_id]" :options="$operationOptions->pluck('name', 'id')" required/>
                </div>
                <div class="col-md-2 mb-2">
                <x-form.input type="time" name="dailyOperationalTimingOperations[0][started]" class="started" required/>
                </div>
                <div class="col-md-2 mb-2">
                <x-form.input type="time" name="dailyOperationalTimingOperations[0][completed]" class="completed" required/>
                </div>
                <div class="col-md-3 mb-2">
                <x-form.input  name="dailyOperationalTimingOperations[0][comments]" class="comments"/>
                </div>
                <div class="col-md-1 mb-2 text-center">
                    <button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;
            var newDailyOperationalTimingSuppliedMaterial = `
            <div class="row mb-3 mb-md-1 line" id="measured_items">
                <x-form.input name="dailyOperationalTimingSuppliedMaterials[0][id]" value="NEW" hidden/>
                <x-form.input name="dailyOperationalTimingSuppliedMaterials[0][daily_work_record_id]" value="{{$dailyWorkRecordId}}" hidden/>
                <div class="col-md-4 mb-2">
                <x-form.select  name="dailyOperationalTimingSuppliedMaterials[0][material_id]" :options="$materialOptions->pluck('name', 'id')" required/>
                </div>
                <div class="col-md-2 mb-2">
                <x-form.input type="time" name="dailyOperationalTimingSuppliedMaterials[0][started]" class="started" required/>
                </div>
                <div class="col-md-2 mb-2">
                <x-form.input type="time" name="dailyOperationalTimingSuppliedMaterials[0][completed]" class="completed" required/>
                </div>
                <div class="col-md-3 mb-2">
                <x-form.input  name="dailyOperationalTimingSuppliedMaterials[0][comments]" class="comments"/>
                </div>
                <div class="col-md-1 mb-2 text-center">
                    <button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;
            var newDailyOperationalTimingSuppliedPlantHaulage = `
            <div class="row mb-3 mb-md-1 line" id="measured_items">
                <x-form.input name="dailyOperationalTimingSuppliedPlantHaulages[0][id]" value="NEW" hidden/>
                <x-form.input name="dailyOperationalTimingSuppliedPlantHaulages[0][daily_work_record_id]" value="{{$dailyWorkRecordId}}" hidden/>
                <div class="col-md-4 mb-2">
                <x-form.input  name="dailyOperationalTimingSuppliedPlantHaulages[0][plant_haulage]" required/>
                </div>
                <div class="col-md-2 mb-2">
                <x-form.input type="time" name="dailyOperationalTimingSuppliedPlantHaulages[0][started]" class="started" required/>
                </div>
                <div class="col-md-2 mb-2">
                <x-form.input type="time" name="dailyOperationalTimingSuppliedPlantHaulages[0][completed]" class="completed" required/>
                </div>
                <div class="col-md-3 mb-2">
                <x-form.input  name="dailyOperationalTimingSuppliedPlantHaulages[0][comments]" class="comments"/>
                </div>
                <div class="col-md-1 mb-2 text-center">
                    <button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;
            var newDailyOperationalTimingToClientInfo = `
            <div class="row mb-3 mb-md-1 line" id="measured_items">
                <x-form.input name="dailyOperationalTimingToClientInfos[0][id]" value="NEW" hidden/>
                <x-form.input name="dailyOperationalTimingToClientInfos[0][daily_work_record_id]" value="{{$dailyWorkRecordId}}" hidden/>
                <div class="col-md-3 mb-2">
                <x-form.input type="time" name="dailyOperationalTimingToClientInfos[0][demoblished_or_offsite]" required/>
                </div>
                <div class="col-md-4 mb-2">
                <x-form.input name="dailyOperationalTimingToClientInfos[0][informed_client]" class="informed-client" required/>
                </div>
                <div class="col-md-4 mb-2">
                <x-form.input name="dailyOperationalTimingToClientInfos[0][comments]" class="comments" required/>
                </div>
            </div>
            `;
        $("#btn_dailyOperationalTimingOperations_add").click(function() {
            addDailyOperationalTimingOperationRow();
        });

        $("#btn_dailyOperationalTimingSuppliedMaterials_add").click(function() {
            addDailyOperationalTimingSuppliedMaterialRow();
        });

        $("#btn_dailyOperationalTimingSuppliedPlantHaulages_add").click(function() {
            addDailyOperationalTimingPlantHaulageRow();
        });

        $(document).on('click', '.btn_delete', function() {
            $(this).parent().parent().remove();
        });
        

        // dailyOperationalTimingOperations  
        function addDailyOperationalTimingOperationRow(alreadyHaveObj = "")
        {
            let newRow = $(newDailyOperationalTimingOperation);
            $("#dailyOperationalTimingOperations-container").append(newRow);
            let new_key = $("#dailyOperationalTimingOperations-container .line").length;
            changeElemsIndexes($(newRow).find('select, input'), new_key);
            newRow.find('input[name*=no]').val(new_key);
            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=daily_work_record_id]').val(alreadyHaveObj.daily_work_record_id);
                newRow.find('select[name*=operation_id]').val(alreadyHaveObj.operation_id);
                newRow.find('input[name*=started]').val(alreadyHaveObj.started);
                newRow.find('input[name*=completed]').val(alreadyHaveObj.completed);
                newRow.find('input[name*=comments]').val(alreadyHaveObj.comments);
            }
        }
        var dailyOperationalTimingOperations = JSON.parse('<?php echo $createdDailyOperationalTimingOperations; ?>')
        console.log(dailyOperationalTimingOperations)
       
        for (let i = 0; i < dailyOperationalTimingOperations.length; i++) {
            let obj = dailyOperationalTimingOperations[i];
            addDailyOperationalTimingOperationRow(obj);
        }
         // dailyOperationalTimingSuppliedMaterials  
         function addDailyOperationalTimingSuppliedMaterialRow(alreadyHaveObj = "")
        {
            let newRow = $(newDailyOperationalTimingSuppliedMaterial);
            $("#dailyOperationalTimingSuppliedMaterials-container").append(newRow);
            let new_key = $("#dailyOperationalTimingSuppliedMaterials-container .line").length;
            changeElemsIndexes($(newRow).find('select, input'), new_key);
            newRow.find('input[name*=no]').val(new_key);
            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=daily_work_record_id]').val(alreadyHaveObj.daily_work_record_id);
                newRow.find('select[name*=material_id]').val(alreadyHaveObj.material_id);
                newRow.find('input[name*=started]').val(alreadyHaveObj.started);
                newRow.find('input[name*=completed]').val(alreadyHaveObj.completed);
                newRow.find('input[name*=comments]').val(alreadyHaveObj.comments);
            }
        }
        var dailyOperationalTimingSuppliedMaterials = JSON.parse('<?php echo $createdDailyOperationalTimingSuppliedMaterials; ?>')
        console.log(dailyOperationalTimingSuppliedMaterials)
       
        for (let i = 0; i < dailyOperationalTimingSuppliedMaterials.length; i++) {
            let obj = dailyOperationalTimingSuppliedMaterials[i];
            addDailyOperationalTimingSuppliedMaterialRow(obj);
        }

         // dailyOperationalTimingSuppliedPlantHaulages  
         function addDailyOperationalTimingPlantHaulageRow(alreadyHaveObj = "")
        {
            let newRow = $(newDailyOperationalTimingSuppliedPlantHaulage);
            $("#dailyOperationalTimingSuppliedPlantHaulages-container").append(newRow);
            let new_key = $("#dailyOperationalTimingSuppliedPlantHaulages-container .line").length;
            changeElemsIndexes($(newRow).find('select, input'), new_key);
            newRow.find('input[name*=no]').val(new_key);
            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=daily_work_record_id]').val(alreadyHaveObj.daily_work_record_id);
                newRow.find('input[name*=plant_haulage]').val(alreadyHaveObj.plant_haulage);
                newRow.find('input[name*=started]').val(alreadyHaveObj.started);
                newRow.find('input[name*=completed]').val(alreadyHaveObj.completed);
                newRow.find('input[name*=comments]').val(alreadyHaveObj.comments);
            }
        }
        var dailyOperationalTimingPlantHaulages = JSON.parse('<?php echo $createdDailyOperationalTimingPlantHaulages; ?>')
        console.log(dailyOperationalTimingPlantHaulages)
        for (let i = 0; i < dailyOperationalTimingPlantHaulages.length; i++) {
            let obj = dailyOperationalTimingPlantHaulages[i];
            addDailyOperationalTimingPlantHaulageRow(obj);
        }
        
         // dailyOperationalTimingToClientInfos 
         function addDailyOperationalTimingToClientInfoRow(alreadyHaveObj = "")
        {
            let newRow = $(newDailyOperationalTimingToClientInfo);
            $("#dailyOperationalTimingToClientInfos-container").append(newRow);
            let new_key = $("#dailyOperationalTimingToClientInfos-container .line").length;
            changeElemsIndexes($(newRow).find('select, input'), new_key);
            newRow.find('input[name*=no]').val(new_key);
            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=daily_work_record_id]').val(alreadyHaveObj.daily_work_record_id);
                newRow.find('input[name*=demoblished_or_offsite]').val(alreadyHaveObj.demoblished_or_offsite);
                newRow.find('input[name*=informed_client]').val(alreadyHaveObj.informed_client);
                newRow.find('input[name*=comments]').val(alreadyHaveObj.comments);
            }
        }
        var dailyOperationalTimingToClientInfos = JSON.parse('<?php echo $createdDailyOperationalTimingToClientInfos; ?>')
        console.log(dailyOperationalTimingToClientInfos)
       if(dailyOperationalTimingToClientInfos.length>0){
           for (let i = 0; i < dailyOperationalTimingToClientInfos.length; i++) {
               let obj = dailyOperationalTimingToClientInfos[i];
               addDailyOperationalTimingToClientInfoRow(obj);
           }
       }else{
           addDailyOperationalTimingToClientInfoRow()
       }
    });

</script>