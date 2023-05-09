<script>
    jQuery(($) => {
       
        var newDailyDirectPessonel = `
            <div class="row mb-3 mb-md-1 line" id="measured_items">
                <x-form.input name="dailyDirectPessonels[0][id]" value="NEW" hidden/>
                <x-form.input name="dailyDirectPessonels[0][daily_work_record_id]" value="{{$dailyWorkRecordId}}" hidden/>
                <div class="col-md-1 mb-2">
                    <x-form.input name="dailyDirectPessonels[0][no]" class="act-no" readonly/>
                </div>
                <div class="col-md-8 mb-2">
                <x-form.select  name="dailyDirectPessonels[0][direct_personnel_id]" :options="$directPessonelOptions->pluck('optionName', 'id')" required/>
                </div>
                <div class="col-md-2 mb-2">
                <x-form.input name="dailyDirectPessonels[0][worked_hours]" class="worked-hours" required/>
                </div>
                <div class="col-md-1 mb-2 text-center">
                    <button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;
            var newDailySubContractPessonel = `
            <div class="row mb-3 mb-md-1 line" id="measured_items">
                <x-form.input name="dailySubContractPessonels[0][id]" value="NEW" hidden/>
                <x-form.input name="dailySubContractPessonels[0][daily_work_record_id]" value="{{$dailyWorkRecordId}}" hidden/>
                <div class="col-md-1 mb-2">
                    <x-form.input name="dailySubContractPessonels[0][no]" class="act-no" readonly/>
                </div>
                <div class="col-md-5 mb-2">
                <x-form.select  name="dailySubContractPessonels[0][subcontract_personnel_id]" :options="$subContractPessonelOptions->pluck('optionName', 'id')" required/>
                </div>
                <div class="col-md-1 mb-2">
                <x-form.input name="dailySubContractPessonels[0][worked_hours]" class="worked-hours" required/>
                </div>
                <div class="col-md-4 mb-2">
                <x-form.input name="dailySubContractPessonels[0][comments]" class="worked-hours" />
                </div>
                <div class="col-md-1 mb-2 text-center">
                    <button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;
            var newDailyDirectVehicleAndPlant = `
            <div class="row mb-3 mb-md-1 line" id="measured_items">
                <x-form.input name="dailyDirectVehicleAndPlants[0][id]" value="NEW" hidden/>
                <x-form.input name="dailyDirectVehicleAndPlants[0][daily_work_record_id]" value="{{$dailyWorkRecordId}}" hidden/>
                <div class="col-md-1 mb-2">
                    <x-form.input name="dailyDirectVehicleAndPlants[0][no]" class="act-no" readonly/>
                </div>
                <div class="col-md-8 mb-2">
                <x-form.select  name="dailyDirectVehicleAndPlants[0][direct_vehicles_and_plant_id]" :options="$directVehicleAndPlantOptions->pluck('optionName', 'id')" required/>
                </div>
                <div class="col-md-2 mb-2" hidden>
                <x-form.input name="dailyDirectVehicleAndPlants[0][comments]" class="comments" />
                </div>
                <div class="col-md-1 mb-2 text-center">
                    <button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;
            var newDailySubContractOrHiredVehicleAndPlants = `
            <div class="row mb-3 mb-md-1 line" id="measured_items">
                <x-form.input name="dailySubContractOrHiredVehicleAndPlants[0][id]" value="NEW" hidden/>
                <x-form.input name="dailySubContractOrHiredVehicleAndPlants[0][daily_work_record_id]" value="{{$dailyWorkRecordId}}" hidden/>
                <div class="col-md-1 mb-2">
                    <x-form.input name="dailySubContractOrHiredVehicleAndPlants[0][no]" class="act-no" readonly/>
                </div>
                <div class="col-md-8 mb-2">
                <x-form.select  name="dailySubContractOrHiredVehicleAndPlants[0][subcontract_or_hired_vehicles_and_plant_id]" :options="$subcontractOrHiredVehicleAndPlantOptions->pluck('optionName', 'id')" required/>
                </div>
                 <div class="col-md-2 mb-2" hidden>
                 <x-form.input name="dailySubContractOrHiredVehicleAndPlants[0][comments]" class="comments" />
                </div>
                <div class="col-md-1 mb-2 text-center">
                    <button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;
        $("#btn_direct_personnel_add").click(function() {
            addDailyDirectPersonnelRow();
        });
        $("#btn_subcontract_personnel_add").click(function() {
            addDailySubContractPersonnelRow();
        });
        $("#btn_dailyDirectVehicleAndPlants__add").click(function() {
            addDailyDirectVehicleAndPlantsRow();
        });
        $("#btn_dailySubContractOrHiredVehicleAndPlants__add").click(function() {
            addDailySubContractOrHiredVehicleAndPlantsRow();
        });

        $(document).on('click', '.btn_delete', function() {
            $(this).parent().parent().remove();
        });
        
        
       
        function addDailyDirectPersonnelRow(alreadyHaveObj = "")
        {
            let newRow = $(newDailyDirectPessonel);
            $("#daily-direct-personnel-container").append(newRow);
            let new_key = $("#daily-direct-personnel-container .line").length;
            changeElemsIndexes($(newRow).find('select, input'), new_key);
            newRow.find('input[name*=no]').val(new_key);
            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=daily_work_record_id]').val(alreadyHaveObj.daily_work_record_id);
                newRow.find('select[name*=direct_personnel_id]').val(alreadyHaveObj.direct_personnel_id);
                newRow.find('input[name*=worked_hours]').val(alreadyHaveObj.worked_hours);
            }
        }
        function addDailySubContractPersonnelRow(alreadyHaveObj = "")
        {
            let newRow = $(newDailySubContractPessonel);
            $("#daily-subContract-personnel-container").append(newRow);
            let new_key = $("#daily-subContract-personnel-container .line").length;
            changeElemsIndexes($(newRow).find('select, input'), new_key);
            newRow.find('input[name*=no]').val(new_key);
            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=daily_work_record_id]').val(alreadyHaveObj.daily_work_record_id);
                newRow.find('select[name*=subcontract_personnel_id]').val(alreadyHaveObj.subcontract_personnel_id);
                newRow.find('input[name*=worked_hours]').val(alreadyHaveObj.worked_hours);
                newRow.find('input[name*=comments]').val(alreadyHaveObj.comments);
            }
        }

        function addDailyDirectVehicleAndPlantsRow(alreadyHaveObj = "")
        {
            let newRow = $(newDailyDirectVehicleAndPlant);
            $("#dailyDirectVehicleAndPlants-container").append(newRow);
            let new_key = $("#dailyDirectVehicleAndPlants-container .line").length;
            changeElemsIndexes($(newRow).find('select, input'), new_key);
            newRow.find('input[name*=no]').val(new_key);
            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=daily_work_record_id]').val(alreadyHaveObj.daily_work_record_id);
                newRow.find('select[name*=direct_vehicles_and_plant_id]').val(alreadyHaveObj.direct_vehicles_and_plant_id);
                newRow.find('input[name*=comments]').val(alreadyHaveObj.comments);
            }
        }
        function addDailySubContractOrHiredVehicleAndPlantsRow(alreadyHaveObj = "")
        {
            let newRow = $(newDailySubContractOrHiredVehicleAndPlants);
            $("#dailySubContractOrHiredVehicleAndPlants-container").append(newRow);
            let new_key = $("#dailySubContractOrHiredVehicleAndPlants-container .line").length;
            changeElemsIndexes($(newRow).find('select, input'), new_key);
            newRow.find('input[name*=no]').val(new_key);
            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=daily_work_record_id]').val(alreadyHaveObj.daily_work_record_id);
                newRow.find('select[name*=subcontract_or_hired_vehicles_and_plant_id]').val(alreadyHaveObj.subcontract_or_hired_vehicles_and_plant_id);
                newRow.find('input[name*=comments]').val(alreadyHaveObj.comments);
            }
        }
        var dailyDirectPessonels = JSON.parse('<?php echo $createdDailyDirectPessonels; ?>')
        console.log(dailyDirectPessonels)
       
        for (let i = 0; i < dailyDirectPessonels.length; i++) {
            let obj = dailyDirectPessonels[i];
            addDailyDirectPersonnelRow(obj);
        }
        var dailySubContractPessonels = JSON.parse('<?php echo $createdDailySubContractPessonels; ?>')
        console.log(dailySubContractPessonels)
       
        for (let i = 0; i < dailySubContractPessonels.length; i++) {
            let obj = dailySubContractPessonels[i];
            addDailySubContractPersonnelRow(obj);
        }
        var dailyDirectVehiclesAndPlants = JSON.parse('<?php echo $createdDailyDirectVehiclesAndPlants; ?>')
        console.log(dailyDirectVehiclesAndPlants)
       
        for (let i = 0; i < dailyDirectVehiclesAndPlants.length; i++) {
            let obj = dailyDirectVehiclesAndPlants[i];
            addDailyDirectVehicleAndPlantsRow(obj);
        }
        var dailySubcontractOrHiredVehiclesAndPlants = JSON.parse('<?php echo $createdDailySubcontractOrHiredVehiclesAndPlants; ?>')
        console.log(dailySubcontractOrHiredVehiclesAndPlants)
       
        for (let i = 0; i < dailySubcontractOrHiredVehiclesAndPlants.length; i++) {
            let obj = dailySubcontractOrHiredVehiclesAndPlants[i];
            addDailySubContractOrHiredVehicleAndPlantsRow(obj);
        }
        
    });

</script>