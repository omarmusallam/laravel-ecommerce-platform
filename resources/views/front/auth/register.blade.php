<x-front-layout title="{{ __('Register') }}">
    @push('styles')
        <style>
            .auth-shell {
                background: linear-gradient(180deg, #f8fbff 0%, #ffffff 24%, #f8fafc 100%);
            }

            .register-wrap {
                align-items: stretch;
            }

            .register-card,
            .register-sidecard {
                background: #fff;
                border: 1px solid #e8eef7;
                border-radius: 28px;
                box-shadow: 0 24px 50px rgba(15, 23, 42, 0.06);
            }

            .register-card {
                padding: 34px;
            }

            .register-sidecard {
                padding: 34px 30px;
                background: linear-gradient(160deg, #0b1d34 0%, #12345a 100%);
                color: #fff;
                height: 100%;
                position: relative;
                overflow: hidden;
            }

            .register-sidecard::after {
                content: "";
                position: absolute;
                right: -60px;
                bottom: -60px;
                width: 220px;
                height: 220px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(65, 146, 255, 0.42), transparent 68%);
                pointer-events: none;
            }

            .register-sidecard > * {
                position: relative;
                z-index: 1;
            }

            .register-chip {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 14px;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.12);
                font-size: 12px;
                font-weight: 700;
                letter-spacing: 0.06em;
                text-transform: uppercase;
                margin-bottom: 18px;
            }

            .register-card .title {
                margin-bottom: 22px;
            }

            .register-card .title p,
            .register-card .outer-link {
                color: #667085;
            }

            .register-card .form-group {
                margin-bottom: 18px;
            }

            .register-card label {
                color: #667085;
                font-weight: 600;
                margin-bottom: 8px;
            }

            .register-card .form-control,
            .register-card input {
                height: 52px;
                border-radius: 14px;
                border-color: #d6e3f2;
                box-shadow: none;
                background: #fbfdff;
            }

            .register-card .btn {
                border-radius: 999px;
                min-width: 180px;
            }

            .register-card .button {
                margin-top: 8px;
            }

            .register-sidecard h3 {
                color: #fff;
                font-size: 32px;
                line-height: 1.2;
                margin-bottom: 14px;
            }

            .register-sidecard p,
            .register-sidecard li {
                color: rgba(255, 255, 255, 0.82);
                line-height: 1.8;
            }

            .register-sidecard ul {
                margin: 24px 0 0;
                padding: 0;
                list-style: none;
                display: grid;
                gap: 14px;
            }

            .register-sidecard li {
                display: flex;
                gap: 12px;
                align-items: flex-start;
            }

            .register-sidecard i {
                color: #8fcbff;
                margin-top: 5px;
            }

            @media (max-width: 991.98px) {
                .register-sidecard {
                    margin-top: 24px;
                }
            }
        </style>
    @endpush

    <div class="account-login section auth-shell">
        <div class="container">
            <div class="row register-wrap justify-content-center g-4">
                <div class="col-lg-5 col-md-10 col-12">
                    <div class="register-form register-card">
                        <div class="title">
                            <h3>{{ __('Create Your Account') }}</h3>
                            <p>{{ __('Registration takes less than a minute and gives you full control over your orders and saved details.') }}</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="row" method="post" action="{{ route('user.register') }}">
                            @csrf
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-fn">{{ __('User Name') }}</label>
                                    <x-form.input id="reg-fn" name="name" :value="old('name')" required placeholder="Your full name" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-email">{{ __('Email') }}</label>
                                    <x-form.input type="email" id="reg-email" name="email" :value="old('email')" required placeholder="name@example.com" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-phone">{{ __('Phone Number') }}</label>
                                    <x-form.input type="text" id="reg-phone" name="phone_number" :value="old('phone_number')" required placeholder="+1 202 555 0187" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reg-pass">{{ __('Password') }}</label>
                                    <x-form.input type="password" id="reg-pass" name="password" required placeholder="At least 9 characters" />
                                </div>
                            </div>
                            <div class="button col-12">
                                <button class="btn" type="submit">{{ __('Register') }}</button>
                            </div>
                            <p class="outer-link col-12">{{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Login Now') }}</a></p>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5 col-md-10 col-12">
                    <aside class="register-sidecard">
                        <span class="register-chip">ShopGrids Account</span>
                        <h3>{{ __('A cleaner way to manage your shopping.') }}</h3>
                        <p>{{ __('Create your account to track orders, save your details, and move through checkout faster on your next visit.') }}</p>
                        <ul>
                            <li><i class="lni lni-checkmark-circle"></i><span>{{ __('Quick access to your orders and account details.') }}</span></li>
                            <li><i class="lni lni-checkmark-circle"></i><span>{{ __('A smoother checkout experience with saved information.') }}</span></li>
                            <li><i class="lni lni-checkmark-circle"></i><span>{{ __('A calmer, cleaner account area designed for everyday use.') }}</span></li>
                        </ul>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
