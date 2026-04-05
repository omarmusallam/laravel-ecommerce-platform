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
    <x-form.input label="Name" class="form-control-lg" name="name" :value="$admin->name" />
</div>
<div class="form-group">
    <x-form.input label="Email" type="email" name="email" :value="$admin->email" />
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
    <x-form.input label="Phone Number" name="phone_number" :value="$admin->phone_number" />
</div>

<div class="form-group">
    <label for="">Status</label>
    <div>
        <x-form.radio name="status" :checked="$admin->status" :options="['active' => 'Active', 'inactive' => 'inActive']" />
    </div>
</div>

<fieldset>
    <legend>{{ __('Roles') }}</legend>

    @foreach ($roles as $role)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}"
                @checked(in_array($role->id, old('roles', $admin_roles)))>
            <label class="form-check-label">
                {{ $role->name }}
            </label>
        </div>
    @endforeach
</fieldset>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>

