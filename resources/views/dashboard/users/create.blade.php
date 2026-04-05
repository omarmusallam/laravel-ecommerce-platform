@extends('layouts.dashboard')

@section('title', 'Create User')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Users</li>
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

    <form action="{{ route('dashboard.users.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <x-form.input label="Name" class="form-control-lg" name="name" required />
        </div>
        <div class="form-group">
            <x-form.input label="Email" type="email" name="email" required />
        </div>
        <div class="form-group">
            <x-form.input label="Password" type="password" name="password" required />
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

