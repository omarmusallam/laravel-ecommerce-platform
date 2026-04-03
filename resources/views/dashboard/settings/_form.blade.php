@if ($errors->any())
    <div class="alert alert-danger">
        <h3>Error Occured!</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="modal-body">
    <div class="container text-start">
        <div class="row mb-0 mb-md-3">
            <div class="mt-md-0 mt-3 col-md-6">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="اسم الموقع الجديد"
                        value="{{ old('name', $setting ? $setting->name : '') }}" required="">
                </div>

            </div>
            <div class="mt-md-0 mt-3 col-md-6">
                <div class="form-group">
                    <label for="name" class="form-label">Currency</label>
                    <input type="text" class="form-control" name="currency" placeholder="عملة الموقع الجديدة"
                        value="{{ old('currency', $setting ? $setting->currency : '') }}" required="">
                </div>

            </div>
        </div>
        <div class="row mb-0 mb-md-3">
            <div class="mt-md-0 mt-3 col-md-4">
                <div class="form-group">
                    <label for="name" class="form-label">WhatsApp</label>
                    <input type="text" class="form-control" name="phone" placeholder="واتساب الموقع الجديد"
                        value="{{ old('phone', $setting ? $setting->phone : '') }}" required="">
                </div>

            </div>
            <div class="mt-md-0 mt-3 col-md-4">
                <div class="form-group">
                    <label for="name" class="form-label">Mail</label>
                    <input type="gmail" class="form-control" name="email" placeholder="بريد الموقع الجديد"
                        value="{{ old('email', $setting ? $setting->email : '') }}">
                </div>

            </div>
            <div class="mt-md-0 mt-3 col-md-4">
                <div class="form-group">
                    <label for="name" class="form-label">Tax number</label>
                    <input type="text" class="form-control" name="tax_number"
                        placeholder="الرقم الضريبي الخاص في الموقع"
                        value="{{ old('tax_number', $setting ? $setting->tax_number : '') }}">
                </div>

            </div>
        </div>
        <div class="row mb-0 mb-md-3">
            <div class="mt-md-0 mt-3 col-md-4">
                <div class="form-group">
                    <label for="name" class="form-label">Site Logo</label>
                    <input type="file" class="form-control" name="website_logo" accept=".jpg,.jpeg,.png,.gif,.webp,.svg,image/jpeg,image/png,image/gif,image/webp,image/svg+xml">
                    @if ($setting && $setting->website_logo)
                        <img src="{{ $setting->website_logo_url }}" alt="" width="150">
                    @endif
                </div>
            </div>
            <div class="mt-md-0 mt-3 col-md-4">
                <div class="form-group">
                    <label for="name" class="form-label">Outro logo</label>
                    <input type="file" class="form-control" name="epilogue_logo" accept=".jpg,.jpeg,.png,.gif,.webp,.svg,image/jpeg,image/png,image/gif,image/webp,image/svg+xml">
                    @if ($setting && $setting->epilogue_logo)
                        <img src="{{ $setting->epilogue_logo_url }}" alt="" width="150">
                    @endif
                </div>
            </div>
            <div class="mt-md-0 mt-3 col-md-4">
                <div class="form-group">
                    <input type="hidden" name="id" value="6" id="">
                    <label for="name" class="form-label">tab logo</label>
                    <input type="file" class="form-control" name="tab_logo" accept=".jpg,.jpeg,.png,.gif,.webp,.svg,image/jpeg,image/png,image/gif,image/webp,image/svg+xml">
                    @if ($setting && $setting->tab_logo)
                        <img src="{{ $setting->tab_logo_url }}" alt="" height="60">
                    @endif
                </div>
            </div>
        </div>

        <div class="row mb-0 mb-md-3">
            <div class="mt-md-0 mt-3 col-md-6">
                <div class="form-group">
                    <label for="name" class="form-label">QR Code</label>
                    <input type="file" class="form-control" name="qr_code" accept=".jpg,.jpeg,.png,.gif,.webp,.svg,image/jpeg,image/png,image/gif,image/webp,image/svg+xml">
                    @if ($setting && $setting->qr_code)
                        <img src="{{ $setting->qr_code_url }}" alt="" height="60">
                    @endif
                </div>
            </div>
            <div class="mt-md-0 mt-3 col-md-6">
                <div class="form-group">
                    <label for="name" class="form-label">Invoice Stamp</label>
                    <input type="file" class="form-control" name="invoice_stamp" accept=".jpg,.jpeg,.png,.gif,.webp,.svg,image/jpeg,image/png,image/gif,image/webp,image/svg+xml">
                    @if ($setting && $setting->invoice_stamp)
                        <img src="{{ $setting->invoice_stamp_url }}" alt="" height="60">
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
