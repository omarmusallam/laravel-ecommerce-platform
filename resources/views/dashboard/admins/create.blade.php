@extends('layouts.dashboard')

@section('title', 'Create Admin')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Admins</li>
@endsection

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <h3>An error occurred.</h3>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dashboard.admins.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <x-form.input label="Name" class="form-control-lg" name="name" />
        </div>
        <div class="form-group">
            <x-form.input label="Email" type="email" name="email" />
        </div>
        <div class="form-group">
            <label for="">Store</label>
            <select name="store_id" class="form-control form-select">
                <option value="">Select Store</option>
                @foreach (App\Models\Store::all() as $store)
                    <option value="{{ $store->id }}" @selected(old('store_id', $admin->store_id) == $store->id)>{{ $store->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <x-form.input label="Phone Number" name="phone_number" />
        </div>

        <div class="form-group">
            <label for="">Status</label>
            <div>
                <x-form.radio name="status" :options="['active' => 'Active', 'inactive' => 'inActive']" />
            </div>
        </div>

        <div class="form-group">
            <x-form.input label="Password" type="password" name="password" required autocomplete="off" />
        </div>

        <fieldset>
            <legend>{{ __('Roles') }}</legend>

            @foreach ($roles as $role)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" />
                    <label class="form-check-label">
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach
        </fieldset>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>

    </form>

@endsection

