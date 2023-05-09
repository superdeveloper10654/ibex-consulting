<script>
    jQuery(($) => {
        var toClientRow = `
            <div class="d-flex align-items-center mt-2 input-set">
                <div class="col-md-11">
                    <div class="input-group">
                        <x-form.input name="to_clients[0][contract_id]" value="{{$id}}" hidden/>
                        <x-form.input name="to_clients[0][id]" value="NEW" hidden/>
                        <div class="input-group">
                            <div class="col-md-1 input-group-prepend">
                                <span class="input-group-text"> <span class="mx-auto index"></span> </span>
                            </div>
                            <div class="col-md-11">
                                <input type="text" name="to_clients[0][work]" class="form-control" style="margin-left: -1px; border-bottom-left-radius: 0; border-top-left-radius: 0;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 text-center to-clients-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light to-clients-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add_to_client").click(function() {
            addSubToClientRow(obj = "");
        });

        $(document).on('click', '.to-clients-delete', function() {
            $(this).parent().parent().remove();
            $('.to-clients-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-danger waves-effect waves-light to-clients-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        function addSubToClientRow(obj) {
            $('.to-clients-delete').remove();
            let key = $('#to-clients .input-set').last().find('.index').text();
            key = key ? parseInt(key) + 1 : 1;
            let newRow = $(toClientRow);
            $('#to-clients').append(newRow);
            newRow.find('.index').text(key);
            changeElemsIndexes($(newRow).find('select, input'), key);

            if (obj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(obj.id);
                newRow.find('input[name*=work]').val(obj.work);
            }
        }


        var toClients = JSON.parse('<?php echo $undertakingsToClients; ?>')
        toClients.forEach(toClient => {
            addSubToClientRow(toClient);
        });

    });
</script>