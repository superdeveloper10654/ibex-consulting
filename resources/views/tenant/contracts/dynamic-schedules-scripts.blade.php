<script>
    jQuery(($) => {

        var new_boq_row = `
            <div class="row mb-3 mb-md-1 line" id="measured_items">
                <x-form.input name="boq_schedules[0][id]" value="NEW" hidden/>
                <x-form.input name="boq_schedules[0][contract_id]" value="{{$id}}" hidden/>
                <div class="col-md-4 mb-2">
                <x-form.input name="boq_schedules[0][item]" class="item" required/>
                </div>
                <div class="col-md-2 mb-2">
                    <x-form.input name="boq_schedules[0][qty]" class="qty" type="number" min=0 step=0.01 required/>
                </div>
                <div class="col-md-1 mb-2">
                    <x-form.input name="boq_schedules[0][unit]" class="unit" required/>
                </div>
                <div class="col-md-2 mb-2">
                    <x-form.input name="boq_schedules[0][rate]" class="rate" type="number" min=0 step=0.01 required/>
                </div>
                <div class="col-md-2 mb-2">
                    <x-form.input name="boq_schedules[0][sum]" class="sum" readonly required/>
                </div>
                <div class="col-md-1 mb-2 text-center delete-section">
                    <button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;
        var new_activity_schedule_row = `
            <div class="row mb-3 mb-md-1 line" id="activity_schedules">
                <div class="col-md-1 mb-2">
                    <x-form.input name="activity_schedules[0][no]" class="act-no" readonly/>
                </div>
                <div class="col-md-6 mb-2">
                    <x-form.input name="activity_schedules[0][id]" value="NEW" hidden/>
                    <x-form.input name="activity_schedules[0][contract_id]" value="{{$id}}" hidden/>
                    <x-form.input name="activity_schedules[0][description]" class="act-description" placeholder="Description of Activity" required/>
                </div>
                <div class="col-md-1 mb-2">
                    <x-form.input name="activity_schedules[0][unit]" type="text" class="act-unit" required/>
                </div>
                <div class="col-md-2 mb-2">
                    <x-form.input name="activity_schedules[0][price]" type="number" min=0 step=0.01 class="act-price"  required/>
                </div>
               
                <div class="col-md-1 mb-2 text-center delete-section">
                    <button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;
        var new_price_list_row = `
            <div class="row mb-3 mb-md-1 line" id="price_lists">
                <x-form.input name="pri_lists[0][id]" value="NEW" hidden/>
                <x-form.input name="pri_lists[0][contract_id]" value="{{$id}}" hidden/>
                <div class="col-md-4 mb-2">
                <x-form.input name="pri_lists[0][item]" class="price_list_item" required/>
                </div>
                <div class="col-md-2 mb-2">
                    <x-form.input name="pri_lists[0][quantity]" type="number" min=0 step=0.01 class="qty" required/>
                </div>
                <div class="col-md-1 mb-2">
                    <x-form.input name="pri_lists[0][unit]" class="unit" required/>
                </div>
                <div class="col-md-2 mb-2">
                    <x-form.input name="pri_lists[0][rate]" class="rate" required/>
                </div>
                <div class="col-md-2 mb-2">
                    <x-form.input name="pri_lists[0][price]" class="sum" required/>
                </div>
                <div class="col-md-1 mb-2 text-center delete-section">
                    <button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;
        $("#btn_activity_schedule_add").click(function() {
            addNewActivityScheduleRow();
        });
        $("#btn_boq_add").click(function() {
            addNewBoqScheduleRow();
        });
        $("#btn_remeasurable_pricelist_add").click(function() {
            addNewPriceListRow(price_item = "", isRateEditable = true);
        });
        $("#btn_lumpsum_pricelist_add").click(function() {
            addNewPriceListRow(price_item = "", isRateEditable = false);
        });

        $(document).on('click', '.btn_delete', function() {
            $(this).parent().parent().prev().find('.delete-section').append(
                `<button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>`
            );
            $(this).parent().parent().remove();

            var total = 0;
            $(".sum").each(function() {
                if (parseFloat($(this).val()) > 0) {
                    total += parseFloat($(this).val());
                }
            });
            $("#net_total").val(total.toFixed(2));

            var actSchTotal = 0;
            $(".act-price").each(function() {
                if (parseFloat($(this).val()) > 0) {
                    actSchTotal += parseFloat($(this).val());
                }
            });
            $("#sum_total").val(actSchTotal.toFixed(2));
        });

        let boqIndex = 0;

        function addNewBoqScheduleRow(boqSchedule = "") {
            $('#bill-of-quantities-schedule-container').children().find('.btn_delete').remove();
            let newRow = $(new_boq_row);
            $("#bill-of-quantities-schedule-container").append(newRow);
            let new_key = $("#bill-of-quantities-schedule-container .line").length;
            changeElemsIndexes($(newRow).find('select, input'), boqIndex++);

            if (boqSchedule) {
                newRow.find('input[name*=id]').val(boqSchedule.id);
                newRow.find('input[name*=contract_id]').val(boqSchedule.contract_id);
                newRow.find('input[name*=unit]').val(boqSchedule.unit);
                newRow.find('input[name*=item]').val(boqSchedule.item);
                newRow.find('input[name*=rate]').val(boqSchedule.rate);
                newRow.find('input[name*=qty]').val(boqSchedule.qty).trigger('keyup');
            }
        }

        let priceIndex = 0;

        function addNewPriceListRow(price_item = "", isRateEditable = false) {
            $('#price-lists-container').children().find('.btn_delete').remove();
            let newRow = $(new_price_list_row);
            $("#price-lists-container").append(newRow);
            newRow.find('input[name*=rate]').prop('disabled', isRateEditable ? false : true);
            newRow.find('input[name*=price]').prop('readonly', isRateEditable);
            let new_key = $("#price-lists-container .line").length;
            changeElemsIndexes($(newRow).find('select, input'), priceIndex++);

            if (price_item) {
                console.log(price_item.contract_id)
                newRow.find('input[name*=price]').val(price_item.price);
                newRow.find('input[name*=id]').val(price_item.id);
                newRow.find('input[name*=contract_id]').val(price_item.contract_id);
                newRow.find('input[name*=item]').val(price_item.item);
                newRow.find('input[name*=unit]').val(price_item.unit);
                newRow.find('input[name*=rate]').val(price_item.rate);
                newRow.find('input[name*=quantity]').val(price_item.quantity).trigger('keyup');
            }
        }

        function calculateDays(start_date, end_date) {
            const date1 = new Date(start_date);
            const date2 = new Date(end_date);
            const diffTime = Math.abs(date2 - date1);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return diffDays
        }

        let activityIndex = 0;

        function addNewActivityScheduleRow(activitySchedule = "") {
            $('#activity-schedule-container').children().find('.btn_delete').remove();
            let newRow = $(new_activity_schedule_row);
            $("#activity-schedule-container").append(newRow);
            let new_key = $("#activity-schedule-container .line").length;
            changeElemsIndexes($(newRow).find('select, input'), activityIndex++);
            newRow.find('input[name*=no]').val(new_key);

            if (activitySchedule) {
                newRow.find('input[name*=id]').val(activitySchedule.id);
                newRow.find('input[name*=contract_id]').val(activitySchedule.contract_id);
                newRow.find('input[name*=description]').val(activitySchedule.description);
                newRow.find('input[name*=unit]').val(activitySchedule.unit);
                newRow.find('input[name*=price]').val(activitySchedule.price).trigger('keyup');
            }
        }
        $(document).on('keyup', '.act-price', function() {
            var total = 0;

            $(".act-price").each(function() {
                if (parseFloat($(this).val()) > 0) {
                    total += parseFloat($(this).val());
                }
            });
            $("#sum_total").val(total.toFixed(2));
        })

        $(document).on('keyup', '.qty', function() {
            let item_rate = parseFloat($(this).parent().parent().find(".rate").val());

            if (Number($(this).val()) > 0) {
                item_rate && $(this).parent().parent().find(".sum").val(parseFloat($(this).val()) * item_rate);
            } else {
                item_rate && $(this).parent().parent().find(".sum").val(item_rate);
            }

            var total = 0;

            $(".sum").each(function() {
                if (parseFloat($(this).val()) > 0) {
                    total += parseFloat($(this).val());
                }
            });

            $("#net_total").val(total.toFixed(2));
        });

        $(document).on('keyup', '.rate', function() {
            let quantity = parseFloat($(this).parent().parent().find(".qty").val());

            if (Number($(this).val()) > 0) {
                $(this).parent().parent().find(".sum").val(parseFloat($(this).val()) * quantity);
            } else {
                $(this).parent().parent().find(".sum").val($(this).val());
            }

            var total = 0;

            $(".sum").each(function() {
                if (parseFloat($(this).val()) > 0) {
                    total += parseFloat($(this).val());
                }
            });

            $("#net_total").val(total.toFixed(2));
        });

        $(document).on('keyup', '.sum', function() {

            var total = 0;

            $(".sum").each(function() {
                if (parseFloat($(this).val()) > 0) {
                    total += parseFloat($(this).val());
                }
            });

            $("#net_total").val(total.toFixed(2));
        });

        var boqSchedules = JSON.parse('<?php echo $createdBoqSchedules; ?>')
        console.log(boqSchedules)
        var activitySchedules = JSON.parse('<?php echo $createdActivitySchedules; ?>')
        console.log(activitySchedules)
        var priceLists = JSON.parse('<?php echo $createdPriceLists; ?>')
        console.log(priceLists)

        if (boqSchedules.length == 0) {

            addNewBoqScheduleRow();
        } else {
            for (let i = 0; i < boqSchedules.length; i++) {
                let boqSchedule = boqSchedules[i];
                addNewBoqScheduleRow(boqSchedule);
            }
        }

        if (activitySchedules.length == 0) {
            addNewActivityScheduleRow();
        } else {
            for (let i = 0; i < activitySchedules.length; i++) {
                let activitySchedule = activitySchedules[i];
                addNewActivityScheduleRow(activitySchedule);
            }
        }

        if (priceLists.length == 0) {
            addNewPriceListRow(price_item = "", isRateEditable = true);
        } else {
            for (let i = 0; i < priceLists.length; i++) {
                let priceList = priceLists[i];
                console.log(priceList)
                addNewPriceListRow(priceList, isRateEditable = priceList.rate ? true : false);
            }
        }
    });
</script>