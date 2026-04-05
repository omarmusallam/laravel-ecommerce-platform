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
    <x-form.input label="Store Name" name="name" :value="$store->name" />
</div>
<div class="form-group">
    <label for="">Description</label>
    <x-form.textarea name="description" :value="$store->description" />
</div>
<div class="form-group">
    <x-form.label id="image">Image</x-form.label>

    <x-form.input type="file" name="logo_image" accept="image/*" />
    @if ($store->logo_image)
        <img src="{{ asset('storage/' . $store->logo_image) }}" alt="img" height="60">
    @endif
</div>
<div class="form-group">
    <label for="">Status</label>
    <div>
        <x-form.radio name="status" :checked="$store->status" :options="['active' => 'Active', 'inactive' => 'inActive']" />
    </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_lable ?? 'Sava' }}</button>
</div>

