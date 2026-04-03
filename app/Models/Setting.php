<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'currency',
        'phone',
        'email',
        'tax_number',
        'website_logo',
        'epilogue_logo',
        'tab_logo',
        'qr_code',
        'invoice_stamp'
    ];

    protected $appends = [
        'website_logo_url',
        'epilogue_logo_url',
        'tab_logo_url',
        'qr_code_url',
        'invoice_stamp_url',
    ];

    public function getWebsiteLogoUrlAttribute(): string
    {
        return $this->resolveAssetUrl($this->website_logo, asset('assets/images/logo/logo.svg'));
    }

    public function getEpilogueLogoUrlAttribute(): string
    {
        return $this->resolveAssetUrl($this->epilogue_logo, asset('assets/images/logo/white-logo.svg'));
    }

    public function getTabLogoUrlAttribute(): string
    {
        return $this->resolveAssetUrl($this->tab_logo, asset('assets/images/favicon.svg'));
    }

    public function getQrCodeUrlAttribute(): string
    {
        return $this->resolveAssetUrl($this->qr_code, asset('assets/images/favicon.svg'));
    }

    public function getInvoiceStampUrlAttribute(): string
    {
        return $this->resolveAssetUrl($this->invoice_stamp, asset('assets/images/favicon.svg'));
    }

    protected function resolveAssetUrl(?string $path, string $fallback): string
    {
        if (!$path) {
            return $fallback;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        $normalizedPath = ltrim($path, '/');

        if (Str::startsWith($normalizedPath, ['assets/']) || File::exists(public_path($normalizedPath))) {
            return asset($normalizedPath);
        }

        return asset('storage/' . $normalizedPath);
    }
}
