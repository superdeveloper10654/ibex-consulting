@push('script')
    <script>
        jQuery(($) => {
            $('#contract').on('change', function() {
                updateContractCompletionDates();

                let option = $(this).find(`option[value=${this.value}]`);
                    if (['{{ AppTenant\Http\Controllers\ContractApplicationController::TSC }}', '{{ AppTenant\Http\Controllers\ContractApplicationController::NEC4_TSC }}'].includes(option.data('contract_type'))) {
                        $('.date-effects-wrapper').hide();
                    } else {
                        $('.date-effects-wrapper').show();
                    }
                });

            $(`
                #contract_completion_date_effect,
                #contract_key_date_1_effect,
                #contract_key_date_2_effect,
                #contract_key_date_3_effect
            `).on('change', function() {
                $(this).removeClass('badge-soft-danger badge-soft-success');

                if (this.value > 0) {
                    $(this).addClass('badge-soft-danger');
                } else if (this.value < 0) {
                    $(this).addClass('badge-soft-success');
                }

                if (this.value == '') {
                    this.value = 0;
                }
                updateContractCompletionDates()
            });

            $(`#price_effect`).on('change', function() {
                this.value = this.value == '' ? 0 : this.value;
            });
        });

        function updateContractCompletionDates()
        {
            let types = ['completion_date', 'key_date_1', 'key_date_2', 'key_date_3'];

            for (let type of types) {
                $(`#contract_${type}_effect`).attr('disabled', true);
                let contract_id = $('#contract').val();

                if (!contract_id) {
                    $(`#contract_${type}`).val('');
                    continue;
                }

                let initial_completion_date = $(`#contract option[value=${contract_id}]`).data(type);

                if (!initial_completion_date) {
                    $(`#contract_${type}`).val('');
                    continue;

                } else {
                    $(`#contract_${type}_effect`).attr('disabled', false);
                }

                let date_affect = Number($(`#contract_${type}_effect`).val());
                let completion_date = moment(initial_completion_date);

                if (date_affect > 0) {
                    completion_date.add(date_affect, 'days');
                } else {
                    completion_date.subtract(date_affect, 'days');
                }

                $(`#contract_${type}`).val(completion_date.format('YYYY-MM-DD'));
            }
        }
    </script>
@endpush