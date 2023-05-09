<script>
    jQuery(($) => {
        let index = 0;

        var newOtherEquipment = `
        @if(str_contains($contractType,'NEC4'))
            <div class="row mb-1 input-group m-0 new_other_equipment">
                <x-form.input name="other_equipments[0][contract_id]" value="{{$id}}" hidden />
                <x-form.input name="other_equipments[0][id]" value="NEW" hidden />
                <x-form.input name="other_equipments[0][type]" value="Other" hidden />
                <div class="col-md-9" style="padding: 0;">
                    <input type="text" name="other_equipments[0][name]" class="form-control" style="border-bottom-right-radius: 0; border-top-right-radius: 0;" required>
                </div>
                <div class="col-md-2" style="padding-left: 0;">
                    <input type="number" min=0 step-0.01 name="other_equipments[0][rate]" class="form-control" style="margin-left: -2px; border-bottom-left-radius: 0; border-top-left-radius: 0;" required>
                </div>
                <div class="col-md-1 mb-2 delete-section">
                    <button type="button" data-classPrefix="equip" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light equip-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
        @else
        <div class="row mb-1 input-group m-0 new_other_equipment">
                <x-form.input name="other_equipments[0][contract_id]" value="{{$id}}" hidden />
                <x-form.input name="other_equipments[0][id]" value="NEW" hidden />
                <x-form.input name="other_equipments[0][type]" value="Other" hidden />
                <div class="col-md-5" style="padding: 0;">
                    <input type="text" name="other_equipments[0][name]" class="form-control" style="border-bottom-right-radius: 0; border-top-right-radius: 0;" required>
                </div>
                <div class="col-md-4" style="padding: 0;">
                    <input type="text" name="other_equipments[0][size]" class="form-control" style="border-radius: 0; margin-left: -1px;" required>
                </div>
                <div class="col-md-2" style="padding-left: 0;">
                    <input type="number" min=0 step-0.01 name="other_equipments[0][rate]" class="form-control" style="margin-left: -2px; border-bottom-left-radius: 0; border-top-left-radius: 0;" required>
                </div>
                <div class="col-md-1 mb-2 delete-section">
                    <button type="button" data-classPrefix="equip" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light equip-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
        @endif
            `;
        var newSpecialEquipment = `
        @if(str_contains($contractType,'NEC4'))
            <div class="row mb-1 input-group m-0 new_special_equipment">
                <x-form.input name="special_equipments[0][contract_id]" value="{{$id}}" hidden />
                <x-form.input name="special_equipments[0][id]" value="NEW" hidden />
                <x-form.input name="special_equipments[0][type]" value="Special" hidden />
                <div class="col-md-9" style="padding: 0;">
                    <input type="text" name="special_equipments[0][name]" class="form-control" style="border-bottom-right-radius: 0; border-top-right-radius: 0;" required>
                </div>
                <div class="col-md-2" style="padding-left: 0;">
                    <input type="number" min=0 step-0.01 name="special_equipments[0][rate]" class="form-control" style="margin-left: -2px; border-bottom-left-radius: 0; border-top-left-radius: 0;" required>
                </div>
                <div class="col-md-1 mb-2 delete-section">
                    <button type="button" data-classPrefix="equip" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light equip-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
        @else
        <div class="row mb-1 input-group m-0 new_special_equipment">
                <x-form.input name="special_equipments[0][contract_id]" value="{{$id}}" hidden />
                <x-form.input name="special_equipments[0][id]" value="NEW" hidden />
                <x-form.input name="special_equipments[0][type]" value="Special" hidden />
                <div class="col-md-5" style="padding: 0;">
                    <input type="text" name="special_equipments[0][name]" class="form-control" style="border-bottom-right-radius: 0; border-top-right-radius: 0;" required>
                </div>
                <div class="col-md-4" style="padding: 0;">
                    <input type="number" min=0 step-0.01 name="special_equipments[0][size]" class="form-control" style="border-radius: 0; margin-left: -1px;" required>
                </div>
                <div class="col-md-2" style="padding-left: 0;">
                    <input type="number" min=0 step-0.01 name="special_equipments[0][rate]" class="form-control" style="margin-left: -2px; border-bottom-left-radius: 0; border-top-left-radius: 0;" required>
                </div>
                <div class="col-md-1 mb-2 delete-section">
                    <button type="button" data-classPrefix="equip" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light equip-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            @endif
            `;
        var newTimeBaseEquipment = `
            <div class="row mb-1 input-group m-0 new_time_equipment">
                <x-form.input name="time_equipments[0][contract_id]" value="{{$id}}" hidden />
                <x-form.input name="time_equipments[0][id]" value="NEW" hidden />
                <div class="col-md-5" style="padding: 0;">
                    <input type="text" name="time_equipments[0][name]" class="form-control" style="border-bottom-right-radius: 0; border-top-right-radius: 0;" required>
                </div>
                <div class="col-md-3" style="padding: 0;">
                    <input type="number" min=0 step-0.01 name="time_equipments[0][time_related_charge]" class="form-control" style="border-radius: 0; margin-left: -1px;" required>
                </div>
                <div class="col-md-3" style="padding-left: 0;">
                    <input type="number" min=0 step-0.01 name="time_equipments[0][per_time_period]" class="form-control" style="margin-left: -2px; border-bottom-left-radius: 0; border-top-left-radius: 0;" required>
                </div>
                <div class="col-md-1 mb-2 delete-section">
                    <button type="button" data-classPrefix="time-equip" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light time-equip-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>`;

        var newOtherDefineCost = `
            <div class="row mb-1 input-group m-0 new_other_define_cost">
                <x-form.input name="other_defined_costs[0][contract_id]" value="{{$id}}" hidden />
                <x-form.input name="other_defined_costs[0][id]" value="NEW" hidden />
                <x-form.input name="other_defined_costs[0][type]" value="Other" hidden />
                <div class="col-md-7" style="padding: 0;">
                    <input type="text" name="other_defined_costs[0][category_of_person]" class="form-control" style="border-bottom-right-radius: 0; border-top-right-radius: 0;" required>
                </div>
                <div class="col-md-2" style="padding: 0;">
                    <input type="text" name="other_defined_costs[0][unit]" class="form-control" style="border-radius: 0; margin-left: -1px;" required>
                </div>
                <div class="col-md-2" style="padding-left: 0;">
                    <input type="number" min=0 step-0.01 name="other_defined_costs[0][rate]" class="form-control" style="margin-left: -2px; border-bottom-left-radius: 0; border-top-left-radius: 0;" required>
                </div>
                <div class="col-md-1 mb-2 delete-section">
                    <button type="button" data-classPrefix="def-cost" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light def-cost-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>`;
        var newManufactAndFabDefineCost = `
            <div class="row mb-1 input-group m-0 new_manufact_fabric_define_cost">
                <x-form.input name="manufact_fabric_defined_costs[0][contract_id]" value="{{$id}}" hidden />
                <x-form.input name="manufact_fabric_defined_costs[0][id]" value="NEW" hidden />
                <x-form.input name="manufact_fabric_defined_costs[0][type]" value="ManufactureAndFabrication" hidden />
                <div class="col-md-9" style="padding: 0;">
                    <input type="text" name="manufact_fabric_defined_costs[0][category_of_person]" class="form-control" style="border-bottom-right-radius: 0; border-top-right-radius: 0;" required>
                </div>
                <div class="col-md-2" style="padding-left: 0;">
                    <input type="number" min=0 step-0.01 name="manufact_fabric_defined_costs[0][rate]" class="form-control" style="margin-left: -2px; border-bottom-left-radius: 0; border-top-left-radius: 0;" required>
                </div>
                <div class="col-md-1 mb-2 delete-section">
                    <button type="button" data-classPrefix="def-cost" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light def-cost-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>`;

        var newDesignDefinedCost = `
            <div class="row mb-1 input-group m-0 new_design_defined_cost">
                <x-form.input name="design_defined_costs[0][contract_id]" value="{{$id}}" hidden />
                <x-form.input name="design_defined_costs[0][id]" value="NEW" hidden />
                <x-form.input name="design_defined_costs[0][type]" value="Design" hidden />
                <div class="col-md-9" style="padding: 0;">
                    <input type="text" name="design_defined_costs[0][category_of_person]" class="form-control" style="border-bottom-right-radius: 0; border-top-right-radius: 0;" required>
                </div>
                <div class="col-md-2" style="padding-left: 0;">
                    <input type="number" min=0 step-0.01 name="design_defined_costs[0][rate]" class="form-control" style="margin-left: -2px; border-bottom-left-radius: 0; border-top-left-radius: 0;" required>
                </div>
                <div class="col-md-1 mb-2 delete-section">
                    <button type="button" data-classPrefix="def-cost" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light def-cost-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>`;

        var newSharedServiceDefineCost = `
            <div class="row mb-1 input-group m-0 new_shared_service_define_cost">
                <input name="shared_costs[0][contract_id]" value="{{$id}}" hidden />
                <input name="shared_costs[0][id]" value="NEW" hidden />
                <div class="col-md-5" style="padding: 0;">
                    <input type="text" name="shared_costs[0][shared_service]" class="form-control" style="border-radius: 0; margin-left: -1px;" required>
                </div>
                <div class="col-md-4" style="padding: 0;">
                    <input type="text" name="shared_costs[0][category_of_person]" class="form-control" style="border-bottom-right-radius: 0; border-top-right-radius: 0;" required>
                </div>
                <div class="col-md-2" style="padding-left: 0;">
                    <input type="number" min=0 step-0.01 name="shared_costs[0][rate]" class="form-control" style="margin-left: -2px; border-bottom-left-radius: 0; border-top-left-radius: 0;" required>
                </div>
                <div class="col-md-1 mb-2 delete-section">
                    <button type="button" data-classPrefix="shared" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light shared-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>`;
        $(document).on('click', '.btn_delete', function() {
            let classprefix = $(this).attr('data-classPrefix')
            $(this).parent().parent().prev().find('.delete-section').append(
                `<button type="button" data-classPrefix="${classprefix}" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light ${classprefix}-delete"><i class="bx bx-trash"></i></button>`
            );
            $(this).parent().parent().remove();
        });

        // ----------- buttton click rendering --------
        $("#btn_other_equipment_add").click(function() {
            let elementId = 'other-equipments'
            addNewEquipment(alreadyHaveObj = '', elementId, newOtherEquipment);
        });
        $("#btn_special_equipment_add").click(function() {
            let elementId = 'special-equipments'
            addNewEquipment(alreadyHaveObj = '', elementId, newSpecialEquipment);
        });
        $("#btn_time_equipment_add").click(function() {
            addTimeEquipment(alreadyHaveObj = '');
        });

        //  defined costs dynamic rendering

        $("#btn_other_defined_cost_add").click(function() {
            let elementId = 'other-defined-costs'
            addNewDefinedCost(alreadyHaveObj = '', elementId, newOtherDefineCost);
        });
        $("#btn_manufact_fab_defined_cost_add").click(function() {
            let elementId = 'manufact_fab-defined-costs'
            addNewDefinedCost(alreadyHaveObj = '', elementId, newManufactAndFabDefineCost);
        });

        $("#btn_design_defined_cost_add").click(function() {
            let elementId = 'design-defined-costs'
            addNewDefinedCost(alreadyHaveObj = '', elementId, newDesignDefinedCost);
        });

        $("#btn_shared_defined_cost_add").click(function() {
            addNewSharedDefinedCost();
        });


        // ----------   render functions
        function addNewEquipment(alreadyHaveObj = "", elementId, newDom) {
            $('#' + elementId).find('.equip-delete').remove();
            let newRow = $(newDom);
            $("#" + elementId).append(newRow);
            let new_key = $("#" + elementId).children().length;
            newRow.find('.input-group-number').text(new_key);
            changeElemsIndexes($(newRow).find('select, input'), index++);

            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=name]').val(alreadyHaveObj.name);
                newRow.find('input[name*=size]').val(alreadyHaveObj.size);
                newRow.find('input[name*=rate]').val(alreadyHaveObj.rate);
                newRow.find('input[name*=type]').val(alreadyHaveObj.type);
            }

        }

        function addTimeEquipment(alreadyHaveObj = "") {
            $('.time-equip-delete').remove()
            let newRow = $(newTimeBaseEquipment);
            $("#time-equipments").append(newRow);
            let new_key = $("#time-equipments").children().length;
            newRow.find('.input-group-number').text(new_key);
            changeElemsIndexes($(newRow).find('select, input'), index++);

            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=name]').val(alreadyHaveObj.name);
                newRow.find('input[name*=time_related_charge]').val(alreadyHaveObj.time_related_charge);
                newRow.find('input[name*=per_time_period]').val(alreadyHaveObj.per_time_period);
            }

        }

        function addNewDefinedCost(alreadyHaveObj = "", elementId, newDom) {
            $("#" + elementId).find('.def-cost-delete').remove()
            let newRow = $(newDom);
            $("#" + elementId).append(newRow);
            let new_key = $("#" + elementId).children().length;
            newRow.find('.input-group-number').text(new_key);
            changeElemsIndexes($(newRow).find('select, input'), index++);

            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=category_of_person]').val(alreadyHaveObj.category_of_person);
                newRow.find('input[name*=unit]').val(alreadyHaveObj.unit);
                newRow.find('input[name*=rate]').val(alreadyHaveObj.rate);
                newRow.find('input[name*=type]').val(alreadyHaveObj.type);
            }

        }

        function addNewSharedDefinedCost(alreadyHaveObj = "") {
            $('.shared-delete').remove()
            let newRow = $(newSharedServiceDefineCost);
            $("#shared-defined-costs").append(newRow);
            let new_key = $("#shared-defined-costs").children().length;
            newRow.find('.input-group-number').text(new_key);
            changeElemsIndexes($(newRow).find('select, input'), index++);

            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=shared_service]').val(alreadyHaveObj.shared_service);
                newRow.find('input[name*=category_of_person]').val(alreadyHaveObj.category_of_person);
                newRow.find('input[name*=rate]').val(alreadyHaveObj.rate);
            }
        }

        // ------------   already created objects rendering here
        var otherEquipments = JSON.parse('<?php echo $createdOtherEquipments; ?>')
        if (otherEquipments.length > 0) {
            for (let i = 0; i < otherEquipments.length; i++) {
                let obj = otherEquipments[i];
                let elementId = 'other-equipments'
                addNewEquipment(obj, elementId, newOtherEquipment);
            }
        } else {
            let elementId = 'other-equipments'
            addNewEquipment(alreadyHaveObj = '', elementId, newOtherEquipment);
        }

        var specialEquipments = JSON.parse('<?php echo $createdSpecialEquipments; ?>')
        if (specialEquipments.length > 0) {
            for (let i = 0; i < specialEquipments.length; i++) {
                let obj = specialEquipments[i];
                let elementId = 'special-equipments'
                addNewEquipment(obj, elementId, newSpecialEquipment);
            }
        } else {
            let elementId = 'special-equipments'
            addNewEquipment(alreadyHaveObj = '', elementId, newSpecialEquipment);
        }

        var timeEquipments = JSON.parse('<?php echo $createdTimeEquipments; ?>')
        if (timeEquipments.length > 0) {
            for (let i = 0; i < timeEquipments.length; i++) {
                let obj = timeEquipments[i];
                addTimeEquipment(obj);
            }
        } else {
            let elementId = 'special-equipments'
            addTimeEquipment();
        }



        var otherDefinedCosts = JSON.parse('<?php echo $createdOtherDefinedCosts; ?>')
        if (otherDefinedCosts.length > 0) {
            for (let i = 0; i < otherDefinedCosts.length; i++) {
                let obj = otherDefinedCosts[i];
                let elementId = 'other-defined-costs'
                addNewDefinedCost(obj, elementId, newOtherDefineCost);
            }
        } else {
            let elementId = 'other-defined-costs'
            addNewDefinedCost(alreadyHaveObj = '', elementId, newOtherDefineCost);
        }

        var manufactAndFabDefinedCosts = JSON.parse('<?php echo $createdManufactAndFabDefinedCosts; ?>')
        if (manufactAndFabDefinedCosts.length > 0) {
            for (let i = 0; i < manufactAndFabDefinedCosts.length; i++) {
                let obj = manufactAndFabDefinedCosts[i];
                let elementId = 'manufact_fab-defined-costs'
                addNewDefinedCost(obj, elementId, newManufactAndFabDefineCost);
            }
        } else {
            let elementId = 'manufact_fab-defined-costs'
            addNewDefinedCost(alreadyHaveObj = '', elementId, newManufactAndFabDefineCost);
        }
        var designCosts = JSON.parse('<?php echo $createdDesignCosts; ?>')
        if (designCosts.length > 0) {
            for (let i = 0; i < designCosts.length; i++) {
                let obj = designCosts[i];
                let elementId = 'design-defined-costs'
                addNewDefinedCost(obj, elementId, newDesignDefinedCost);
            }
        } else {
            let elementId = 'design-defined-costs'
            addNewDefinedCost(alreadyHaveObj = '', elementId, newDesignDefinedCost);
        }

        var sharedDefineCosts = JSON.parse('<?php echo $createdSharedDefineCosts; ?>')
        if (sharedDefineCosts.length > 0) {
            for (let i = 0; i < sharedDefineCosts.length; i++) {
                let obj = sharedDefineCosts[i];
                addNewSharedDefinedCost(obj)
            }
        } else {
            addNewSharedDefinedCost()
        }
    });
</script>