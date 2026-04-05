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
<div class="form-group">
    <x-form.input label="Name" class="form-control-lg" name="name" :value="$user->name" />
</div>
<div class="form-group">
    <x-form.input label="Email" type="email" name="email" :value="$user->email" />
</div>

<fieldset>
    <legend>{{ __('Roles') }}</legend>

    @foreach ($roles as $role)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}"
                @checked(in_array($role->id, old('roles', $user_roles)))>
            <label class="form-check-label">
                {{ $role->name }}
            </label>
        </div>
    @endforeach
</fieldset>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>

