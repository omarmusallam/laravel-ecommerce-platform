<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function getImageUrlAttribute()
    {
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        $normalizedPath = ltrim($this->image, '/');

        if (
            Str::startsWith($normalizedPath, ['assets/'])
            || File::exists(public_path($normalizedPath))
        ) {
            return asset($normalizedPath);
        }

        return Storage::disk('public')->url($normalizedPath);
    }
}
