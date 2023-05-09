<script>
    jQuery(($) => {
        var newSR = `
            <div class="row align-items-center mt-3 input-set">
                <div class="col-md-12">
                    <p class="mb-0 mt-3">Name</p>
                    <select class="form-control select-user" name="senior_representatives[0]" required>
                        <option value="">select</option>
                        @foreach ($seniorRepresentativeProfiles as $profile)
                        <option value="{{$profile->id}}" data="{{$profile}}">{{$profile->name}}</option>
                        @endforeach
                    </select>
                    <p class="mb-0 mt-3">Address for communications</p>
                    <textarea class="form-control mt-2 address" rows="3" required disabled></textarea>
                    <p class="mb-0 mt-3">Address for electronic communications</p>
                    <textarea class="form-control mt-2 elec-address" rows="3" required disabled></textarea>
                </div>
                <div class="col-md-12 text-end mt-2 SR-delete-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light SR-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $("#btn_add_SR").click(function() {
            addSRRow(obj = "");
        });

        $(document).on('click', '.SR-delete', function() {
            $(this).parent().parent().remove();
            $('.SR-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-danger waves-effect waves-light SR-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        let index = 0;

        function addSRRow(obj) {
            $('.SR-delete').remove();
            let newRow = $(newSR);
            $('#SR').append(newRow);
            changeElemsIndexes($(newRow).find('select, input'), index++);

            if (obj) {
                newRow.find('select').val(obj.id);
                newRow.find('.address').val(obj.address);
                newRow.find('.elec-address').val(obj.electronic_address);
            }
        }

        var seniorRepresentatives = JSON.parse('<?php echo $seniorRepresentatives; ?>')
        if (seniorRepresentatives.length == 0) {
            addSRRow();
        } else {
            seniorRepresentatives.forEach(seniorRepresentative => {
                addSRRow(seniorRepresentative);
            });
        }

    });
</script>