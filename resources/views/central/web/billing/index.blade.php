@extends('central.web.layouts.master')

@section('css')
    <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('title') @lang('Billing') @endsection

@section('content')

@component('components.breadcrumb')
    @slot('li_1') Account @endslot
    @slot('title') Billing @endslot
@endcomponent

<style>
/* Reduce the £ sign */
h1::first-letter {
  font-size: 0.8125rem;
}
  .plan-box.col-md-4.text-center.new-selected-plan.mx-auto .card {
    border: solid 3px #34c38f;
}

</style>

<input type="hidden" name="billableId" value="{{ Auth::user()->id }}" />
<input type="hidden" name="billableType" value="user" />
<input type="hidden" name="country" value="GB" />
<input type="hidden" name="postal_code" value="{{ Auth::user()->billing_postal_code }}" />
<input type="hidden" name="vat_number" value="{{ Auth::user()->vat_id }}" />

@if ($state == 'onGracePeriod')
    <div class="resume-plan-wrapper row justify-content-center">
        <div class="col-lg-6">
            <div class="text-center mb-5">
                <h4 class="payment-info-title">{{ __('Resume Subscription') }}</h4>
                <p class="text">{{ __('Having second thoughts about cancelling your subscription? You can instantly reactive your subscription at any time until the end of your current billing cycle. After your current billing cycle ends, you may choose an entirely new subscription plan.') }}</p>
                <button type="button" class="btn btn-primary  waves-effect waves-light resume-plan">Resume Subscription</button>
            </div>
        </div>
    </div>
@else
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-5">
                @if ($state == 'none')
                    <h4>Choose your package</h4>
                    <p class="text-muted">Transparent pricing to help your budget and cashflow</p>
                @else
                    <h2>Your subscription</h2>
                @endif
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        @foreach ($plans as $plan)
            @php
                $selected = $state != 'none' && ($selected_plan && $plan->id == $selected_plan->id);
            @endphp
            <div class="plan-box col-md-4 text-center {{ $selected_plan && !$selected ? 'd-none' : '' }} {{ $selected ? 'mx-auto selected-plan new-selected-plan' : '' }}">
                <div class="card">
                    <div class="card-body p-4">
                        <input type="hidden" name="id" value="{{ $plan->id }}" />
                        <input type="hidden" name="currency" value="{{ $plan->currency }}" />
                        <input type="hidden" name="total" value="{{ $plan->rawPrice }}" />

                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5>{{ $plan->name }}</h5>
                            </div>
                        </div>
                        <div class="py-4">
                          <h1>{{ $plan->price }}</h1>
                          <p>Per user per {{ $plan->interval == 'monthly' ? 'month' : 'year' }}</p>
                          <small class="text-muted">{{ $plan->shortDescription }}</small>
                        </div>

                        @if (!empty($plan->features)) 
                            <div class="plan-features mb-1 text-start">
                                @foreach ($plan->features as $feature)
                                    <p class="mb-0 w-50 mx-auto"><i class="bx bx-checkbox-square text-primary me-2"></i> {{ $feature }}</p>
                                @endforeach
                            </div>
                        @endif

                        <div class="py-4 text-start {{ $selected_plan ? 'd-none' : '' }}">
                            <x-form.input-with-slot label="Your instance subdomain" name="subdomain" type="text" value="{{ Auth::user()->preferred_subdomain }}">
                                <span class="input-group-text">.{{ env('APP_DOMAIN') }}</span>
                            </x-form.input-with-slot>
                        </div>

                        <div class="text-center">
                            @if ($plan->trialDays === 99999)
                                <button type="button" class="btn btn-primary w-lg waves-effect waves-light subscribe demo {{ $selected_plan ? 'd-none' : '' }}">Choose</button>
                            @else
                                <button type="button" class="btn btn-primary w-lg waves-effect waves-light subscribe {{ $selected_plan ? 'd-none' : '' }}">Choose {{ $plan->interval == 'monthly' ? 'month' : 'year' }}ly</button>
                            @endif
                        </div>
                        {{-- @todo: when Paid subscription ready - setup change subscription functional --}}
                        {{-- @if ($selected_plan && $selected)
                            <div class="text-center">
                                <button type="button" class="btn btn-light w-lg waves-effect waves-light change-plan">Change subscription</button>
                            </div>
                        @endif --}}
                    </div>
                </div>
            </div>

            @if ($selected)
                <div class="next-payment-date-wrapper row justify-content-center">
                    <div class="col-md-6 card p-5">
                        <h5 class="mb-3"><i class="mdi mdi-credit-card-check"></i> Payments</h5>
                        <p>Your next payment is due on {{ date('D d M Y', $stripe_subscription->current_period_end) }}.</p>
                        <p>This is for your {{ Auth::user()->team_users_count }} users.</p>

                        @if ($selected_plan && !empty(Auth::user()->card_last_four) && !empty(Auth::user()->card_expiration))
                            <p class="text">Your current payment method is a <span style="text-transform: capitalize;">{{ ( Auth::user()->card_brand ) }} </span> card ending in {{ Auth::user()->card_last_four . ' ' . __('which expires on') . ' ' . Auth::user()->card_expiration }}.</p>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    @if ($selected_plan)
        <div class="cancel-subscription-wrapper row justify-content-center">
            <div class="col-md-6 card p-5">
                <h5 class="mb-3"><i class="mdi mdi-credit-card-remove"></i> Cancel</h5>
                <p class="text">{{ __('You may cancel your subscription at any time. Once your subscription has been cancelled, you will have the option to resume the subscription until the end of your current billing cycle.') }}</p>
                <div class="text-center">
                    <button type="button" class="btn btn-danger w-lg waves-effect waves-light cancel-plan">Cancel Subscription</button>
                </div>
            </div>
        </div>
    @endif

    <div class="row justify-content-center mt-4 d-none payment-details-wrapper">
      
        <div class="col-md-6 card p-5">
                <h4 class="text-center">Enter your details</h4>
          <p class="text-muted text-center">Please enter your billing details below </p>
                <div class="card-details">
                    <div class="mb-3">
                        <label for="title" class="form-label">{{ __('Card') }}</label>
                        <div id="card-element" class="form-control"></div>
                    </div>
                    
                    <div class="mb-3" style="display: none;">
                        <label for="country" class="form-label">{{ __('Country') }}</label>

                        <select name="country" id="country" class="form-select">
                            <option value="" disabled="">{{ __('Select') }}</option>

                            @foreach ($countries as $code => $country)
                                <option value="{{ $code }}" {{ $code == $home_country ? 'selected' : '' }}>{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" style="display: none;">
                        <label for="extra" class="form-label">{{ __('Extra Billing Information') }}</label>

                        <textarea id="extra" rows="5"
                            placeholder="{{ __('If you need to add specific contact or tax information to your receipts, like your full business name, VAT identification number, or address of record, you may add it here.') }}"
                            class="w-100 form-control"></textarea>
                    </div>
                </div>
 
            <div class="mb-3">
                    <label for="users_count" class="form-label">How many users?</label>
                    <input id="users_count" name="users_count" type="number" 
                        style="width: 100px;"
                        class="form-control" 
                        value="{{ Auth::user()->team_users_count }}" 
                        min="{{ env('TEAM_USERS_COUNT_MIN') }}"
                        required />
                </div>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="total fw-bold">
                        {{ __('Total:') }}: <span class="value">checkoutAmount</span>
                    </span>
                    <span class="total-tax">
                        (<span class="value">checkoutTax</span> {{ __('TAX') }})
                    </span>
                </div>

                <button class="btn btn-primary waves-effect waves-light subscribe" id="confirmSubscriptionButton" disabled>{{ __('Subscribe') }}</button>
            </div>
            <button class="change-plan d-flex align-items-center mt-2 px-0 border-0">
                <svg viewBox="0 0 20 20" fill="currentColor" class="text-muted me-3" style="height: 1em;">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                </svg>
                <div class="ml-2 fs-6 text-muted text-decoration-underline">{{ __('Select a different plan') }}</div>
            </button>
        </div>
    </div>

    <button class="back-to-my-plan d-flex align-items-center mt-2 px-0 border-0 d-none">
        <svg viewBox="0 0 20 20" fill="currentColor" class="text-muted me-3" style="height: 1em;">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
        </svg>
        <div class="ml-2 fs-6 text-muted text-decoration-underline">{{ __("Nevermind, I'll keep my old plan") }}</div>
    </button>
@endif

@endsection

@section('script')
    <script>
        let payment_method_added = Boolean({{ $selected_plan && !empty(Auth::user()->card_last_four) && !empty(Auth::user()->card_expiration) }});
        let stripe = Stripe("{{ env('STRIPE_KEY') }}", {
            apiVersion: "{{ $stripe_version }}"
        });
        let card_element;
        let selected_plan;
        let confirmSubscriptionButton = $('#confirmSubscriptionButton');

        @empty($selected_plan)
            let tenant_subdomain = Str.subdomain('{{ Auth::user()->organisation }}');
            $('[name=subdomain]').val(tenant_subdomain);
        @endempty

        window.onload = () => {
            @if ($state != 'onGracePeriod')
                let subscriptionCardElement = createCardElement('#card-element');

                subscriptionCardElement.on('ready', () => {
                    subscriptionCardElement.focus()
                });

                subscriptionCardElement.on('change', (event) => {
                    if (event.complete) {
                        confirmSubscriptionButton.attr('disabled', false)
                    }
                });

                confirmSubscriptionButton.on('click', () => {
                    confirmSubscription();
                });

                // change plan
                $('button.change-plan').on('click', () => {
                    $('.plan-box').removeClass('d-none')
                        .removeClass('mx-auto');
                    $('.plan-box button.subscribe').removeClass('d-none');
                    $('.plan-box button.change-plan').addClass('d-none');

                    if ($('.plan-box.selected-plan').length) {
                        $('.plan-box.selected-plan').addClass('d-none');
                        $('button.back-to-my-plan').removeClass('d-none');   
                    }

                    $('.next-payment-date-wrapper').addClass('d-none');
                    $('.payment-information-wrapper').addClass('d-none');
                    $('.cancel-subscription-wrapper').addClass('d-none');
                    $('.payment-details-wrapper').addClass('d-none');
                });

                // back to old plan
                $('button.back-to-my-plan').on('click', () => {
                    $('.plan-box:not(.selected-plan)').addClass('d-none');
                    $('.plan-box.selected-plan').addClass('mx-auto').removeClass('d-none');
                    $('.plan-box button.subscribe').addClass('d-none');
                    $('.plan-box button.change-plan').removeClass('d-none');
                    $('button.back-to-my-plan').addClass('d-none');

                    $('.next-payment-date-wrapper').removeClass('d-none');
                    $('.payment-information-wrapper').removeClass('d-none');
                    $('.cancel-subscription-wrapper').removeClass('d-none');
                    $('.payment-details-wrapper').addClass('d-none');
                });

                // cancel plan
                $('button.cancel-plan').on('click', () => {
                    $('button.cancel-plan').attr('disabled', true);
                    request('PUT', '/spark/subscription/cancel')
                        .then((res) => {
                            window.location.reload();
                        });
                });
            
                $('.plan-box').each((i, el) => {
                    let plan_el = $(el);

                    // subscribe on plan
                    plan_el.find('.subscribe').on('click', function(e) {
                        if ($(this).hasClass('demo')) {
                            showLoader();
                            let info_msg_timeout = setTimeout(() => {
                                infoMsg('Configuring your instance ... It can take a while', '', {timeOut: 12000});
                            }, 2000);

                            request('POST', '/billing/subscribe-demo', {
                                subdomain : $('[name=subdomain]').val()
                            }).then(response => {
                                successMsg("Instance has been successfully created. You'll be redirected on the instance subdomain");
                                setTimeout(() => {
                                    window.location.href = window.location.protocol + '//' + response.data.redirect;
                                }, 5000);

                            }).catch(error => {
                                clearTimeout(info_msg_timeout);
                                confirmSubscriptionButton.attr('disabled', false);
                                errorMsg(error);

                            }).finally((e) => {
                                hideLoader();
                            });

                        } else {
                            $('.plan-box').removeClass('new-selected-plan');
                            $(e.target).closest('.plan-box').addClass('new-selected-plan');
                            updateTotals();
                        }
                    });
                });

                // change users count field
                $('[name=users_count]').on('change', () => {
                    updateTotals();
                });

            @else
                // resume plan
                $('button.resume-plan').on('click', () => {
                    $('button.resume-plan').attr('disabled', true);
                    request('PUT', '/spark/subscription/resume')
                        .then((res) => {
                            window.location.reload();
                        });
                });
            @endif
        };

        function updateTotals() {
            let plan_el = $('.plan-box.new-selected-plan');
            let btn_subscribe = plan_el.find('.subscribe');
            btn_subscribe.attr('disabled', true);
            selected_plan = plan_el.find('[name=id]').val();

            return request('POST', '/spark/tax-rate', {
                is_demo         : $('[name=is_demo]').val(),
                billableId      : $('[name=billableId]').val(),
                billableType    : $('[name=billableType]').val(),
                country         : $('[name=country]').val(),
                currency        : plan_el.find('[name=currency]').val(),
                postal_code     : $('[name=postal_code]').val(),
                total           : plan_el.find('[name=total]').val(),
                vat_number      : $('[name=vat_number]').val(),
                users_count     : $('[name=users_count]').val(),
            }).then((res) => {
                $('.plan-box').not(plan_el).addClass('d-none');
                plan_el.addClass('mx-auto');
                btn_subscribe.addClass('d-none')
                    .attr('disabled', false);

                $('.payment-details-wrapper').removeClass('d-none');

                if (payment_method_added) {
                    $('.payment-details-wrapper .card-details').addClass('d-none');
                    confirmSubscriptionButton.attr('disabled', false);
                } else {
                    $('.payment-details-wrapper .card-details').removeClass('d-none');
                    confirmSubscriptionButton.attr('disabled', !confirmSubscriptionButton.hasClass('StripeElement--complete'));
                }

                $('.payment-details-wrapper .total .value').html(res.total);
                $('.payment-details-wrapper .total-tax .value').html(res.tax);
            }).catch((err) => {
                errorMsg('{{ __("Something went wrong") }}')
                console.log(res);
                btn_subscribe.attr('disabled', false);
            });
        }

        function createCardElement(container) {
            card_element = stripe.elements({
                fonts: [{
                    cssSrc: 'https://fonts.googleapis.com/css?family=Nunito:400,600,700'
                }],
            }).create('card', {
                hideIcon: true,
                hidePostalCode: true,
                style: {
                    base: {
                        '::placeholder': {
                            color: '#aab7c4'
                        },
                        fontFamily: 'Nunito, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
                        color: '#000000',
                        fontSize: '16px',
                        fontWeight: '400',
                        fontSmoothing: 'antialiased'
                    }
                }
            });

            card_element.mount(container);

            return card_element;
        }

        /**
         * Actually create a new subscription for the billable.
         */
        function confirmSubscription() {
            confirmSubscriptionButton.attr('disabled', true);

            if (!payment_method_added) {
                generateSetupIntentToken(secret => {
                    let payload = {
                        name: "{{ $user_name }}"
                    };
                    let country = $('[name=country]').val();

                    if (country) {
                        // @todo add payment addresses
                        payload.address = {
                            line1: '',
                            line2: '',
                            city: '',
                            state: '',
                            postal_code: '',
                            country: country,
                        }
                    }

                    stripe.handleCardSetup(secret, card_element, {
                        payment_method_data: {
                            billing_details: payload
                        }
                    }).then(response => {
                        if (response.error) {
                            errorMsg(response.error.message);
                        } else {
                            confirmSubscriptionStage2(response.setupIntent.payment_method);
                        }
                    });
                });
            } else {
                confirmSubscriptionStage2();
            }
        }

        function confirmSubscriptionStage2(payment_method = '')
        {
            let data = {
                plan: selected_plan,
                users_count: $('[name=users_count]').val(),
            };

            if (!payment_method_added) {
                data = Object.assign(data, {
                    payment_method: payment_method,
                    // @todo add coupons
                    // coupon: this.subscriptionForm.coupon,
                    extra_billing_information: $('#extra').val(),
                    billing_address: '',
                    billing_address_line_2: '',
                    billing_city: '',
                    billing_state: '',
                    billing_postal_code: '',
                    billing_country: $('[name=country]').val(),
                    vat_id: '',
                });
            }

            showLoader();
            request('POST', '/spark/subscription', data).then(response => {
                confirmSubscriptionButton.attr('disabled', false);
                window.location.reload();

            }).catch(error => {
                confirmSubscriptionButton.attr('disabled', false);
                errorMsg(error);

            }).finally((e) => {
                hideLoader();
            });
        }

        /**
         * Generate a Stripe Setup Intent token.
         */
        function generateSetupIntentToken(callback) {
            return request('GET', "/spark/token").then(
                response => callback(response.clientSecret)
            );
        }

        /**
         * Make an outgoing request to the Laravel application.
         */
        function request(method, url, data = {}) {
            return new Promise ((resolve, reject) => {
                data.billableType = $('[name=billableType]').val();
                data.billableId = $('[name=billableId]').val();

                $.ajax({
                    url: "{{ url('') }}" + url,
                    dataType: 'JSON',
                    method: method,
                    data: data,
                    success: (response => {
                        resolve(response);
                    }),
                    error: (res => {
                        if (res.status == 200) {
                            resolve();
                        } else if (res.status == 422 && res.message) {
                            error = res.message;
                        } else if (res.status == 422 && res.responseJSON.message) {
                            error = res.responseJSON.message;
                        } else {
                            error = "{{ __('An unexpected error occurred and we have notified our support team. Please try again later.') }}";
                        }

                        reject(error);
                    })
                });
            });
        }
    </script>
@endsection