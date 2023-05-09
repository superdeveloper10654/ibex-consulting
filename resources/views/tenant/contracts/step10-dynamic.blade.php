<script>
    jQuery(($) => {
        var newkeyPeople = `
            <div class="input-group mt-3 mb-3 new_key_people">
                <x-form.input name="key_peoples[0][contract_id]" value="{{$id}}" hidden />
                <x-form.input name="key_peoples[0][id]" value="NEW" hidden />
                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-group-number">1</span>
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text">Name</span>
                    </div>
                    <input name="key_peoples[0][name]" type="text" class="form-control" required>
                </div>
                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-group-number">1</span>
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text">Job</span>
                    </div>
                    <input name="key_peoples[0][job]" type="text" class="form-control" required>
                </div>
                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-group-number">1</span>
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text">Responsibilities</span>
                    </div>
                    <input name="key_peoples[0][responsibility]" type="text" class="form-control" required>
                </div>
                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-group-number">1</span>
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text">Qualifications</span>
                    </div>
                    <input name="key_peoples[0][qualification]" type="textarea" class="form-control" required>
                </div>
                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-group-number">1</span>
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text ">Experience</span>
                    </div>
                    <input name="key_peoples[0][experience]" type="textarea" class="form-control" required>
                </div>
                <div class="col-12 mt-2 text-end KP-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light float-right KP-delete"><i class="bx bx-trash"></i></button>
                </div>
                </div>
            </div>
            `;
        var newSeniorRepresentative = `
            <div class="input-group mt-3 mb-3 new_senior_people">
                <x-form.input name="senior_representatives[0][contract_id]" value="{{$id}}" hidden />
                <x-form.input name="senior_representatives[0][id]" value="NEW" hidden />
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
                <div class="col-12 mt-2 text-end SR-delete-btn-section">
                    <button type="button" class="btn-rounded btn btn-danger waves-effect waves-light float-right SR-delete"><i class="bx bx-trash"></i></button>
                </div>
            </div>
            `;

        $(document).on('click', '.KP-delete', function() {
            $(this).parent().parent().remove();
            $('.KP-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-danger waves-effect waves-light KP-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        $(document).on('click', '.SR-delete', function() {
            $(this).parent().parent().remove();
            $('.SR-delete-btn-section').last().append(
                `<button type="button" class="btn-rounded btn btn-danger waves-effect waves-light SR-delete"><i class="bx bx-trash"></i></button>`
            );
        });

        $("#btn_key_people_add").click(function() {
            addKeyPeople();
        });
        $("#btn_senior_rep_add").click(function() {
            addNewRepresentative();
        });

        let KPIndex = 0;

        function addKeyPeople(alreadyHaveObj = "") {
            $('.KP-delete').remove();
            let newRow = $(newkeyPeople);
            $("#key-peoples").append(newRow);
            let new_key = $(".new_key_people").length;
            newRow.find('.input-group-number').text(new_key);
            changeElemsIndexes($(newRow).find('select, input'), KPIndex++);

            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(alreadyHaveObj.id);
                newRow.find('input[name*=name]').val(alreadyHaveObj.name);
                newRow.find('input[name*=job]').val(alreadyHaveObj.job);
                newRow.find('input[name*=qualification]').val(alreadyHaveObj.qualification);
                newRow.find('input[name*=responsibility]').val(alreadyHaveObj.responsibility);
                newRow.find('input[name*=experience]').val(alreadyHaveObj.experience);
            }

        }

        let SRIndex = 0;

        function addNewRepresentative(alreadyHaveObj = "") {
            $('.SR-delete').remove();
            let newRow = $(newSeniorRepresentative);
            $("#senior-representative-sect").append(newRow);
            let new_key = $(".new_senior_people").length;
            newRow.find('.input-group-number').text(new_key);
            changeElemsIndexes($(newRow).find('select, input'), SRIndex++);

            if (alreadyHaveObj) {
                newRow.find('input[name*=id]').not('input[name*=contract_id]').val(alreadyHaveObj.id);
                newRow.find('select').val(alreadyHaveObj.id);
                newRow.find('.address').val(alreadyHaveObj.address);
                newRow.find('.elec-address').val(alreadyHaveObj.elect_address);
            }

        }
        var keyPeoples = JSON.parse('<?php echo $createdKeyPeoples; ?>')
        if (keyPeoples.length > 0) {
            for (let i = 0; i < keyPeoples.length; i++) {
                let obj = keyPeoples[i];
                addKeyPeople(obj);
            }
        } else {
            addKeyPeople();
        }
        var seniorRepresentatives = JSON.parse('<?php echo $createdSeniorRepresentatives; ?>')
        if (seniorRepresentatives.length > 0) {
            for (let i = 0; i < seniorRepresentatives.length; i++) {
                let obj = seniorRepresentatives[i];
                addNewRepresentative(obj);
            }
        } else {
            addNewRepresentative();
        }
        // other equipments

    });
</script>