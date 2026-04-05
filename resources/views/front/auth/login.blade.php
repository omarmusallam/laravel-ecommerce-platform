<x-front-layout title="{{ __('Login') }}">
    @push('styles')
        <style>
            .auth-shell {
                background: linear-gradient(180deg, #f8fbff 0%, #ffffff 24%, #f8fafc 100%);
            }

            .auth-card {
                border: 1px solid #e8eef7;
                border-radius: 28px;
                box-shadow: 0 24px 50px rgba(15, 23, 42, 0.06);
            }

            .auth-card .card-body {
                padding: 34px;
            }

            .auth-card .title p,
            .auth-card .outer-link,
            .auth-card .lost-pass {
                color: #667085;
            }

            .auth-card .form-control {
                height: 50px;
                border-radius: 14px;
                border-color: #d6e3f2;
                box-shadow: none;
            }

            .auth-card .btn {
                border-radius: 999px;
            }
        </style>
    @endpush

    <div class="account-login section auth-shell">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form auth-card" action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>{{ __('Welcome Back') }}</h3>
                                <p>{{ __('Sign in to manage your orders, cart, and account details.') }}</p>
                            </div>
                            <div class="social-login">
                                <div class="row">
                                    <div class="col-lg-6 col-md-4 col-12"><a class="btn facebook-btn"
                                            href="{{ route('auth.socialite.redirect', 'facebook') }}"><i
                                                class="lni lni-facebook-filled"></i>
                                            {{ __('Facebook login') }}</a>
                                    </div>
                                    <div class="col-lg-6 col-md-4 col-12"><a class="btn google-btn"
                                            href="{{ route('auth.socialite.redirect', 'google') }}"><i
                                                class="lni lni-google"></i> {{ __('Google login') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="alt-option">
                                <span>{{ __('Or') }}</span>
                            </div>
                            @if ($errors->has(config('fortify.username')))
                                <div class="alert alert-danger">
                                    {{ $errors->first(config('fortify.username')) }}
                                </div>
                            @endif
                            <div class="form-group input-group">
                                <label for="reg-fn">{{ __('Email or Phone') }}</label>
                                <input class="form-control" type="text" name="{{ config('fortify.username') }}"
                                    id="reg-email" required>
                            </div>
                            <div class="form-group input-group">
                                <label for="reg-fn">{{ __('Password') }}</label>
                                <input class="form-control" type="password" name="password" id="reg-pass" required>
                            </div>
                            <div class="d-flex flex-wrap justify-content-between bottom-content">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" value="1"
                                        class="form-check-input width-auto" id="exampleCheck1">
                                    <label class="form-check-label">{{ __('Remember me') }}</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="lost-pass"
                                        href="{{ route('password.request') }}">{{ __('Forgot password?') }}</a>
                                @endif
                            </div>
                            <div class="button">
                                <button class="btn" type="submit">{{ __('Login') }}</button>
                            </div>
                            @if (Route::has('register'))
                                <p class="outer-link">{{ __("Don't have an account?") }}
                                    <a href="{{ route('user.register') }}">{{ __('Register here') }}</a>
                                </p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Login Area -->

</x-front-layout>
