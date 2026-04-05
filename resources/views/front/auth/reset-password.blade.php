<x-front-layout title="Login">
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
                    <form class="card login-form auth-card" action="{{ route('password.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="card-body">
                            <div class="title">
                                <h3>Reset Password</h3>
                                <p>Choose a new password to regain access to your ShopGrids account.</p>
                            </div>
                            <x-auth-validation-errors style="color: red" class="mb-4" :errors="$errors" />
                            <div class="form-group input-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" name="email" id="email" required
                                    autofocus />
                            </div>
                            <div class="form-group input-group">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" name="password" id="password" required />
                            </div>
                            <div class="form-group input-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input class="form-control" type="password" name="password_confirmation"
                                    id="password_confirmation" required />
                            </div>
                            <div class="button">
                                <button class="btn" type="submit">Reset Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Login Area -->

</x-front-layout>
