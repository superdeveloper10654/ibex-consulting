<script>
    jQuery(($) => {
            var newDailySiteRisksInfo = `
            <div class="row mb-3 mb-md-1 line" id="measured_items">
                <x-form.input name="dailySiteRisks[0][id]" value="NEW" hidden/>
                <x-form.input name="dailySiteRisks[0][daily_work_record_id]" value="{{$dailyWorkRecordId}}" hidden/>
                <div class="col-md-10 mb-2">
                <textarea name="dailySiteRisks[0][description_of_issue]" class="description_of_issue" required style="width:100%;"/>
                </div>
                <div class="col-md-1 mb-2 text-center">
                    <button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;
        $("#btn_dailyDailySiteRisks_add").click(function() {
            addDailySiteRisksRow();
        });

        $(document).on('click', '.btn_delete', function() {
            $(this).parent().parent().remove();
        });
        

        
         // dailySiteRisks 
         function addDailySiteRisksRow(alreadyHaveObj = "")
        {
            let newRow = $(newDailySiteRisksInfo);
            $("#dailySiteRisks-container").append(newRow);
            let new_key = $("#dailySiteRisks-container .line").length;
            changeElemsIndexes($(newRow).find('select, input, textarea'), new_key);
            newRow.find('input[name*=no]').val(new_key);
            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=daily_work_record_id]').val(alreadyHaveObj.daily_work_record_id);
                newRow.find('textarea[name*=description_of_issue]' ).val(alreadyHaveObj.description_of_issue);
                
            }
        }
        var dailySiteRisks = JSON.parse('<?php echo $createdDailySiteRisks; ?>')
        console.log(dailySiteRisks)
       if(dailySiteRisks.length>0){
           for (let i = 0; i < dailySiteRisks.length; i++) {
               let obj = dailySiteRisks[i];
               addDailySiteRisksRow(obj);
           }
       }else{
        addDailySiteRisksRow();
       }
    });

</script>