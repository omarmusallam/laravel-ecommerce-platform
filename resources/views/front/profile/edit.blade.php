<x-front-layout>

    @push('styles')
        <style>
            .user-profile-form {
                background-color: #f9f9f9;
                padding: 20px;
                border-radius: 10px;
                margin-bottom: 15px
            }

            .user-profile-form input[type="text"],
            .user-profile-form input[type="date"],
            .user-profile-form select {
                width: 100%;
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            .user-profile-form .btn-primary {}
        </style>
    @endpush

    <x-slot:breadcrumb>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">{{ __('Profile') }}</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('Home') }}</a></li>
                            <li>{{ __('Profile') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:breadcrumb>

    <div class="container mt-4">

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="card user-profile-form">
                    <div class="card-body">
                        <x-alert type="success" />
                        <x-alert type="info" />
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h3>{{ __('An error occurred.') }}</h3>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <h3 class="page-title text-center">{{ __('User Profile') }}</h3>

                        <form action="{{ route('user-profile.update') }}" method="post" class="mt-4">
                            @csrf
                            @method('patch')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name">{{ __('First Name') }}</label>
                                    <input type="text" name="first_name" class="form-control"
                                        value="{{ $user->userprofile->first_name ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name">{{ __('Last Name') }}</label>
                                    <input type="text" name="last_name" class="form-control"
                                        value="{{ $user->userprofile->last_name ?? '' }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="birthday">{{ __('Birthday') }}</label>
                                    <input type="date" name="birthday" class="form-control"
                                        value="{{ $user->userprofile->birthday ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>{{ __('Gender') }}</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male"
                                            value="male"
                                            {{ $user->userprofile->gender === 'male' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="male">
                                            {{ __('Male') }}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female"
                                            value="female"
                                            {{ $user->userprofile->gender === 'female' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="female">
                                            {{ __('Female') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="street_address">{{ __('Street Address') }}</label>
                                    <input type="text" name="street_address" class="form-control"
                                        value="{{ $user->userprofile->street_address ?? '' }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="city">{{ __('City') }}</label>
                                    <input type="text" name="city" class="form-control"
                                        value="{{ $user->userprofile->city ?? '' }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="state">{{ __('State') }}</label>
                                    <input type="text" name="state" class="form-control"
                                        value="{{ $user->userprofile->state ?? '' }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="postal_code">{{ __('Postal Code') }}</label>
                                    <input type="text" name="postal_code" class="form-control"
                                        value="{{ $user->userprofile->postal_code ?? '' }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <x-form.select name="country" :options="$countries" label="{{ __('Country') }}"
                                        :selected="$user->userprofile->country ?? ''" />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <x-form.select name="locale" :options="$locales" label="{{ __('Locale') }}"
                                        :selected="$user->userprofile->locale ?? ''" />
                                </div>
                            </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary col-md-2">{{ __('Save') }}</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-front-layout>

