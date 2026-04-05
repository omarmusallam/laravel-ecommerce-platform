<x-front-layout title="{{ __('Checkout') }}">
    @push('styles')
        <style>
            .checkout-shell {
                background: linear-gradient(180deg, #f8fbff 0%, #ffffff 22%, #f8fafc 100%);
            }

            .checkout-hero {
                padding: 24px 0 10px;
            }

            .checkout-hero p {
                color: #667085;
                margin-bottom: 0;
            }

            .checkout-card,
            .checkout-sidebar-price-table {
                background: #fff;
                border: 1px solid #e8eef7;
                border-radius: 24px;
                box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);
            }

            .checkout-card {
                padding: 10px 24px 24px;
            }

            .checkout-steps-form-style-1 > ul {
                margin: 0;
                padding: 0;
                list-style: none;
            }

            .checkout-steps-form-style-1 li {
                margin-bottom: 18px;
                border: 1px solid #edf2f7;
                border-radius: 20px;
                overflow: hidden;
            }

            .checkout-steps-form-style-1 li .title {
                margin: 0;
                padding: 18px 22px;
                background: #f8fbff;
                font-size: 17px;
                font-weight: 700;
                color: #081828;
            }

            .checkout-steps-form-content {
                padding: 22px;
                background: #fff;
            }

            .single-form label,
            .single-checkbox p {
                color: #667085;
                font-weight: 600;
            }

            .form-default .form-input input,
            .form-default .form-input select {
                height: 50px;
                border-radius: 14px;
                border: 1px solid #d6e3f2;
                box-shadow: none;
            }

            .checkout-card .btn {
                border-radius: 999px;
            }

            .checkout-sidebar-price-table {
                padding: 24px;
                margin-top: 0;
                position: sticky;
                top: 24px;
            }

            .checkout-sidebar-price-table .title {
                margin-bottom: 18px;
            }

            .total-payable .payable-price {
                border-radius: 18px;
                background: #edf4ff !important;
                padding: 14px 16px !important;
            }

            .total-payable .payable-price .value,
            .total-payable .payable-price .price {
                color: #0167f3 !important;
                font-weight: 800 !important;
            }
        </style>
    @endpush

    <section class="checkout-wrapper section checkout-shell">
        <div class="container">
            <div class="checkout-hero">
                <h1>{{ __('Checkout') }}</h1>
                <p>Enter your billing and shipping details to complete your order with a cleaner checkout flow.</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="checkout-card">
                    <form action="{{ route('checkout') }}" method="post" id="payment-form">
                        @csrf
                        <div class="checkout-steps-form-style-1">
                            <ul id="accordionExample">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $message)
                                                <li>{{ $message }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <li>
                                    <h6 class="title" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                        aria-expanded="true" aria-controls="collapseThree">
                                        {{ __('Your Personal Details') }} </h6>
                                    <section class="checkout-steps-form-content collapse show" id="collapseThree"
                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>{{ __('User Name') }}</label>
                                                    <div class="row">
                                                        <div class="col-md-6 form-input form">
                                                            <x-form.input required id="billing_first_name"
                                                                name="addr[billing][first_name]" :value="old('addr.billing.first_name')"
                                                                placeholder="{{ __('First Name') }}" />
                                                        </div>
                                                        <div class="col-md-6 form-input form">
                                                            <x-form.input required id="billing_last_name"
                                                                name="addr[billing][last_name]" :value="old('addr.billing.last_name')"
                                                                placeholder="{{ __('Last Name') }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>{{ __('Email Address (optional)') }}</label>
                                                    <div class="form-input form">
                                                        <x-form.input id="billing_email" name="addr[billing][email]"
                                                            :value="old('addr.billing.email')"
                                                            placeholder="{{ __('Email Address') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>{{ __('Phone Number') }}</label>
                                                    <div class="form-input form">
                                                        <x-form.input required id="billing_phone_number"
                                                            name="addr[billing][phone_number]" :value="old('addr.billing.phone_number')"
                                                            placeholder="{{ __('Phone Number') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>{{ __('Mailing Address') }}</label>
                                                    <div class="form-input form">
                                                        <x-form.input required id="billing_street_address"
                                                            name="addr[billing][street_address]" :value="old('addr.billing.street_address')"
                                                            placeholder="{{ __('Mailing Address') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>{{ __('City') }}</label>
                                                    <div class="form-input form">
                                                        <x-form.input required id="billing_city"
                                                            name="addr[billing][city]" :value="old('addr.billing.city')"
                                                            placeholder="{{ __('City') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>{{ __('Post Code (optional)') }}</label>
                                                    <div class="form-input form">
                                                        <x-form.input id="billing_postal_code"
                                                            name="addr[billing][postal_code]" :value="old('addr.billing.postal_code')"
                                                            placeholder="{{ __('Post Code') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>{{ __('Region/State (optional)') }}</label>
                                                    <div class="select-items">
                                                        <x-form.input id="billing_state" name="addr[billing][state]"
                                                            :value="old('addr.billing.state')" placeholder="{{ __('State') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>{{ __('Country') }}</label>
                                                    <div class="form-input form">
                                                        <x-form.select required id="billing_country" :value="old('addr.billing.country')"
                                                            name="addr[billing][country]" :options="$countries" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-checkbox checkbox-style-3">
                                                    <input type="checkbox" id="checkbox-3">
                                                    <label for="checkbox-3"><span></span></label>
                                                    <p>{{ __('My delivery and mailing addresses are the same.') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-form button">
                                                    <button type="button" class="btn" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseFour" aria-expanded="false"
                                                        aria-controls="collapseFour">{{ __('Next Step') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </li>
                                <li>
                                    <h6 class="title collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">
                                        {{ __('Shipping Address') }}
                                    </h6>
                                    <section class="checkout-steps-form-content collapse" id="collapseFour"
                                        aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>{{ __('User Name') }}</label>
                                                    <div class="row">
                                                        <div class="col-md-6 form-input form">
                                                            <x-form.input id="shipping_first_name" required
                                                                name="addr[shipping][first_name]" :value="old('addr.shipping.first_name')"
                                                                placeholder="{{ __('First Name') }}" />
                                                        </div>
                                                        <div class="col-md-6 form-input form">
                                                            <x-form.input id="shipping_last_name" required
                                                                :value="old('addr.shipping.last_name')" name="addr[shipping][last_name]"
                                                                placeholder="{{ __('Last Name') }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>{{ __('Email Address (optional)') }}</label>
                                                    <div class="form-input form">
                                                        <x-form.input id="shipping_email" name="addr[shipping][email]"
                                                            :value="old('addr.shipping.email')"
                                                            placeholder="{{ __('Email Address') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>{{ __('Phone Number') }}</label>
                                                    <div class="form-input form">
                                                        <x-form.input required id="shipping_phone_number"
                                                            name="addr[shipping][phone_number]" :value="old('addr.shipping.phone_number')"
                                                            placeholder="{{ __('Phone Number') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>{{ __('Mailing Address') }}</label>
                                                    <div class="form-input form">
                                                        <x-form.input required id="shipping_street_address"
                                                            name="addr[shipping][street_address]" :value="old('addr.shipping.street_address')"
                                                            placeholder="{{ __('Mailing Address') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>{{ __('City') }}</label>
                                                    <div class="form-input form">
                                                        <x-form.input required id="shipping_city"
                                                            name="addr[shipping][city]" :value="old('addr.shipping.city')"
                                                            placeholder="{{ __('City') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>{{ __('Post Code (optional)') }}</label>
                                                    <div class="form-input form">
                                                        <x-form.input id="shipping_postal_code"
                                                            name="addr[shipping][postal_code]" :value="old('addr.shipping.postal_code')"
                                                            placeholder="{{ __('Post Code') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>{{ __('Region/State (optional)') }}</label>
                                                    <div class="select-items">
                                                        <x-form.input id="shipping_state" name="addr[shipping][state]"
                                                            :value="old('addr.shipping.state')" placeholder="{{ __('State') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>{{ __('Country') }}</label>
                                                    <div class="form-input form">
                                                        <x-form.select required id="shipping_country"
                                                            :value="old('addr.shipping.country')" name="addr[shipping][country]"
                                                            :options="$countries" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="steps-form-btn button">
                                                    <button type="button" class="btn" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseThree" aria-expanded="false"
                                                        aria-controls="collapseThree">{{ __('Previous') }}</button>

                                                    <button class="btn"
                                                        type="submit">{{ __('Save & Continue') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </li>
                            </ul>
                        </div>
                    </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="checkout-sidebar">
                        {{-- <div class="checkout-sidebar-coupon">
                            <p>{{ __('Apply Coupon to get discount!') }}</p>
                            <form action="#">
                                <div class="single-form form-default">
                                    <div class="form-input form">
                                        <input type="text" placeholder="{{ __('Coupon Code') }}">
                                    </div>
                                    <div class="button">
                                        <button class="btn">{{ __('apply') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div> --}}
                        <div class="checkout-sidebar-price-table mt-30">
                            <p class="title">{{ __('You Pay') }}</p>

                            <div class="sub-total-price">
                                <div class="total-price">
                                    <p class="value">{{ __('Subtotal Price:') }}</p>
                                    <p class="price">{{ Currency::format($cart->total()) }}</p>
                                </div>
                                <div class="total-price shipping">
                                    <p class="value">{{ __('Shipping') }}</p>
                                    <p class="price">{{ __('Free') }}</p>
                                </div>
                                <div class="total-price discount">
                                    <p class="value">{{ __('Tax') }}</p>
                                    <p class="price">{{ Currency::format(00.0) }}</p>
                                </div>
                            </div>

                            <div class="total-payable">
                                <div class="payable-price">
                                    <p class="value">{{ __('You Pay:') }}</p>
                                    <p class="price">
                                        {{ Currency::format($cart->total()) }}</p>
                                </div>
                            </div>
                            {{-- <div class="price-table-btn button">
                                <a href="javascript:void(0)" class="btn btn-alt">{{ __('Checkout') }}</a>
                            </div> --}}
                        </div>
                        {{-- <div class="checkout-sidebar-banner mt-30">
                            <a href="product-grids.html">
                                <img src="https://via.placeholder.com/400x330" alt="#">
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#checkbox-3').on('change', function() {
                    if ($(this).prop('checked')) {
                        $('#shipping_first_name').val($('#billing_first_name').val());
                        $('#shipping_last_name').val($('#billing_last_name').val());
                        $('#shipping_email').val($('#billing_email').val());
                        $('#shipping_phone_number').val($('#billing_phone_number').val());
                        $('#shipping_street_address').val($('#billing_street_address').val());
                        $('#shipping_city').val($('#billing_city').val());
                        $('#shipping_postal_code').val($('#billing_postal_code').val());
                        $('#shipping_state').val($('#billing_state').val());
                        $('#shipping_country').val($('#billing_country').val());
                    } else {
                        $('#shipping_first_name').val('');
                        $('#shipping_last_name').val('');
                        $('#shipping_email').val('');
                        $('#shipping_phone_number').val('');
                        $('#shipping_street_address').val('');
                        $('#shipping_city').val('');
                        $('#shipping_postal_code').val('');
                        $('#shipping_state').val('');
                        $('#shipping_country').val('');
                    }
                });
            });
        </script>
    @endpush
</x-front-layout>
