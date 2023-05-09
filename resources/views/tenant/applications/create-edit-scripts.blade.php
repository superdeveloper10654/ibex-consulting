<script>
    jQuery(($) => {
        var new_row = `
            <div class="row mb-3 mb-md-1 line" id="measured_items">
                <div class="col-md-7 mb-2">
                    <select class="form-select item_select" name="items[0][rate_card_id]">
                        <option value=''>Select</option>
                        @foreach ($rate_cards as $index => $rate_card)
                            <option value="{{ $rate_card->id }}" data-index="{{ $index }}">{{ $rate_card->item_desc }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger" data-error="items[0][rate_card_id]"></div>
                </div>
                <div class="col-md-1 mb-2">
                    <x-form.input name="items[0][qty]" class="qty" />
                </div>
                <div class="col-md-1 mb-2">
                    <x-form.input name="items[0][unit]" class="unit" readonly />
                </div>
                <div class="col-md-1 mb-2">
                    <x-form.input name="items[0][rate]" class="rate" readonly />
                </div>
                <div class="col-md-1 mb-2">
                    <x-form.input name="items[0][sum]" class="sum" readonly />
                </div>
                <div class="col-md-1 mb-2 text-center">
                    <button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;
        var items = JSON.parse('{!! json_encode($rate_cards) !!}');

        $("#btn_add").click(function() {
            addMeasuredItemsRow();
        });
    
        $(document).on('click', '.btn_delete', function() {
            $(this).parent().parent().remove();
            $('.qty').trigger('keyup');
        });

        $(document).on('change', '.item_select', function() {
            $(this).parent().parent().find(".qty").val('').trigger('keyup');
            if ($(this).val() == "") {
                $(this).parent().parent().find(".unit").val("");
                $(this).parent().parent().find(".rate").val("");
            } else {
                var selected = $(this).find(":selected").data("index");
                $(this).parent().parent().find(".unit").val(items[selected]["unit"]);
                $(this).parent().parent().find(".rate").val(items[selected]["rate"]);
            }
        });

        $(document).on('keyup', '.qty', function() {
            let item_rate = parseFloat($(this).parent().parent().find(".rate").val());

            if (Number($(this).val()) > 0) {
                $(this).parent().parent().find(".sum").val(parseFloat($(this).val()) * item_rate);
            } else {
                $(this).parent().parent().find(".sum").val(item_rate);
            }
            
            var total = 0;

            $(".sum").each(function() {
                if (parseFloat($(this).val()) > 0) {
                    total += parseFloat($(this).val());
                }
            });

            $("#application_net").val(total.toFixed(2));
        });

        $('select[name=measure_id]').on('change', function() {
            $.ajax({
                url         : "{{ t_route('measures.ajax') }}",
                method      : 'POST',
                dataType    : 'JSON',
                data        : {
                    action  : 'getById',
                    id      : this.value,
                },
                success     : (res) => {
                    $("#items-container").html('');

                    if (typeof res.data.quantified_items !== 'undefined' && res.data.quantified_items !== null) {
                        for (let i = 0; i < res.data.quantified_items.length; i++) {
                            addMeasuredItemsRow(res.data.quantified_items[i]);
                        }  
                    }

                    if (typeof res.data.linear_items !== 'undefined' && res.data.linear_items !== null) {
                        for (let i = 0; i < res.data.linear_items.length; i++) {
                            let item = res.data.linear_items[i];
                            item.qty = Math.round(item.length * item.width);
                            addMeasuredItemsRow(item);
                        }
                    }
                }
            });
        });

        function addMeasuredItemsRow(item = '')
        {
            let item_jq = $(new_row);
            let new_key = $("#items-container .line").length;
            $("#items-container").append(item_jq);
            changeElemsIndexes($(item_jq).find('select, input'), new_key);

            if (item) {
                item_jq.find('select[name*=rate_card_id]').val(item.rate_card.id).change();
                item_jq.find('input[name*=unit]').val(item.rate_card.unit);
                item_jq.find('input[name*=rate]').val(item.rate_card.rate);
                item_jq.find('input[name*=qty]').val(item.qty).trigger('keyup');
            }
        }
    });
</script>