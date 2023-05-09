<script>
    jQuery(($) => {
        var newReplyExceptPeriod = `
<x-form.input name="except_reply_periods[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="except_reply_periods[0][id]" value="NEW" hidden/>
                        <x-form.input name="except_reply_periods[0][is_by_sub_contractor]" value=0 hidden/>
            <div class="input-set reply-except-period-row">
                <div class="row mt-2">
                    <div class="col-md-11">
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text index"></span>
                        </div>
                            <div class="col-md-3 input-group-prepend">
                                <span class="input-group-text"> The period for</span>
                            </div>
                            <div class="col">
                                <input type="text" name="except_reply_periods[0][reply_for]" class="form-control" style="margin-left: -1px; border-radius: 0;border-right-width:0">
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text"> is </span>
                            </div>
                            <div style="flex: inherit; width: 100px;">
                                <input type="number" step=0.1 min=0 name="except_reply_periods[0][reply_is]" class="form-control" style="margin-left:-1px; border-radius: 0;" >
                            </div>
                           <label class="input-group-text" style="margin-left: -2px;">weeks</label>
                        </div>
                    </div>
                    <div class="col-md-1 text-center except-reply-period-delete-btn-section">
                        <button type="button" class="btn-rounded btn btn-light waves-effect waves-light except-reply-period-delete"><i class="bx bx-trash"></i></button>
                    </div>
                </div>
            </li>

            `;

        $("#btn_add_except_reply_period").click(function() {
            addReplyExceptPeriodRow(obj = "");
        });

        $("#btn_add_sub_except_reply_period").click(function() {
            addReplyExceptPeriodRow(obj = "", is_by_sub_contractor = 1);
        });

        $(document).on('click', '.except-reply-period-delete', function() {
            $(this).closest('li').remove();
            $('.except-reply-period-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-light waves-effect waves-light except-reply-period-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        $(document).on('click', '.sub-except-reply-period-delete', function() {
            $(this).closest('li').remove();
            $('.sub-except-reply-period-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-light waves-effect waves-light sub-except-reply-period-delete"><i class="bx bx-trash"></i></button>`
            );
        });


        function addReplyExceptPeriodRow(obj, is_by_sub_contractor = 0) {
            let prefix = is_by_sub_contractor ? 'sub-' : '';
            $('.' + prefix + 'except-reply-period-delete').remove();
            let key = $('#' + prefix + 'except-reply-periods .input-set').last().find('.index').text();
            key = key ? parseInt(key) + 1 : 1;
            let newRow = $(newReplyExceptPeriod);
            $('#' + prefix + 'except-reply-periods').append(newRow);
            newRow.find('.index').text(key);
            changeElemsIndexes($(newRow).find('select, input'), $('.reply-except-period-row').length);

            newRow.find('input[name*=is_by_sub_contractor]').val(is_by_sub_contractor);

            is_by_sub_contractor && newRow.find("[class*='except-']").each(function(index, elm) {
                var oldClass = $(elm).attr('class');
                newClass = oldClass.replace('except', 'sub-except');
                $(elm).removeClass(oldClass);
                $(elm).addClass(newClass);
            });

            if (obj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(obj.id);
                newRow.find('input[name*=reply_for]').val(obj.reply_for);
                newRow.find('input[name*=reply_is]').val(obj.reply_is);
            }
        }

        var replyExceptPeriods = JSON.parse('<?php echo $replyExceptPeriods; ?>')
        replyExceptPeriods.forEach(replyExceptPeriod => {
            addReplyExceptPeriodRow(replyExceptPeriod, replyExceptPeriod.is_by_sub_contractor);
        });

        if ($('#sub-except-reply-periods .input-set').length == 0) {
            addReplyExceptPeriodRow(obj = "", is_by_sub_contractor = 1);
        }

        if ($('#except-reply-periods .input-set').length == 0) {
            addReplyExceptPeriodRow();
        }


    });
</script>









