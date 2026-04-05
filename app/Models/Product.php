<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'category_id',
        'store_id',
        'price',
        'compare_price',
        'quantity',
        'featured',
        'status',
    ];

    protected $hidden = ['image', 'created_at', 'updated_at', 'deleted_at'];

    protected $appends = [
        'image_url', 'url'
    ];
    // Apply model boot logic as soon as the model is initialized.
    protected static function booted()
    {
        static::addGlobalScope('store', function (Builder $builder) {
            $user = Auth::user();
            if ($user && $user->store_id) {
                $builder->where('store_id', '=', $user->store_id);
            }
        });
    }

    public function scopeFilter2(Builder $builder, $filters)
    {
        if ($filters['name'] ?? false) {
            $builder->where('products.name', 'LIKE', "%{$filters['name']}%");
        }
        if ($filters['category_id'] ?? false) {
            $builder->where('products.category_id', '=', $filters['category_id']);
        }
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')->withDefault([
            'name' => '-'
        ]);
    }

    public function images(){
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class, // Apply model boot logic as soon as the model is initialized.
            // 'product_tag',  // Pivot table name
            // Apply model boot logic as soon as the model is initialized.
            // Apply model boot logic as soon as the model is initialized.
            // Apply model boot logic as soon as the model is initialized.
            // Apply model boot logic as soon as the model is initialized.
        );
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', 'active');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://www.incathlab.com/images/products/default_product.png';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        if ($this->isPublicAsset($this->image)) {
            return asset(ltrim($this->image, '/'));
        }

        return Storage::disk('public')->url(ltrim($this->image, '/'));
    }

    public function getUrlAttribute()
    {
        return route('products.show', $this->slug);
    }

    public function getThumbUrlAttribute()
    {
        if (!$this->image) {
            return 'https://www.incathlab.com/images/products/default_product.png';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        if ($this->isPublicAsset($this->image)) {
            return asset(ltrim($this->image, '/'));
        }
        return route('image', [
            'public',
            '243',
            '243', $this->image
        ]);
    }


    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }

        return round(100 - (100 * $this->price / $this->compare_price), 1);
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['status'], function ($query, $status) {
            return $query->where('status', $status);
        });

        $builder->when($options['store_id'], function ($builder, $value) {
            $builder->where('store_id', $value);
        });
        $builder->when($options['category_id'], function ($builder, $value) {
            $builder->where('category_id', $value);
        });
        $builder->when($options['tag_id'], function ($builder, $value) {

            $builder->whereExists(
                function ($query) use ($value) {
                    $query->select(1)
                        ->from('product_tag')
                        ->whereRaw('product_id = products.id')
                        ->where('tag_id', $value);
                }
            );
            // $builder->whereRaw('id IN (SELECT product_id FROM product_tag WHERE tag_id = ?)', [$value]);
            // $builder->whereRaw('EXISTS (SELECT 1 FROM product_tag WHERE tag_id = ? AND product_id = products.id)', [$value]);

            // $builder->whereHas('tags', function($builder) use ($value) {
            //     $builder->where('id', $value);
            // });
        });
    }

    protected function isPublicAsset(string $path): bool
    {
        $normalizedPath = ltrim($path, '/');

        return Str::startsWith($normalizedPath, ['assets/'])
            || File::exists(public_path($normalizedPath));
    }
}

