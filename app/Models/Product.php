<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'promo_price',
        'is_promo',
        'promo_start_date',
        'promo_end_date',
        'stock_quantity',
        'description',
        'brand',
        'dimensions',
        'reference',
        'images',
    'size_prices',
    ];

    protected $casts = [
        'price'          => 'float',
        'promo_price'    => 'float',
        'is_promo'       => 'boolean',
        'promo_start_date' => 'datetime',
        'promo_end_date'   => 'datetime',
        'images'         => 'array',
    'size_prices'    => 'array',
    ];

    /* ============================
       RELATIONSHIPS
    ============================ */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /* ============================
       SCOPES
    ============================ */


    public function scopePromotions($query)
    {
        return $query->where('is_promo', true);
    }

    /* ============================
       ACCESSORS
    ============================ */

    protected function averageRating(): Attribute
    {
        return Attribute::make(
            get: fn() => round($this->reviews()->avg('rating') ?? 0, 1)
        );
    }

    protected function reviewsCount(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->reviews()->count()
        );
    }

    /* ============================
       SIZE PRICING HELPERS
    ============================ */

    /**
     * Return the size/price list normalized as an array of ['size' => string, 'price' => float].
     */
    protected function normalizedSizePrices(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->size_prices)) {
                    return [];
                }
                // Accept either associative (size=>price) or list of objects
                if (array_is_list($this->size_prices)) {
                    return collect($this->size_prices)
                        ->map(function ($row) {
                            if (is_array($row) && isset($row['size'], $row['price'])) {
                                return ['size' => (string)$row['size'], 'price' => (float)$row['price']];
                            }
                            return null;
                        })
                        ->filter()
                        ->values()
                        ->all();
                }
                // Associative form
                return collect($this->size_prices)
                    ->map(fn($price, $size) => ['size' => (string)$size, 'price' => (float)$price])
                    ->values()
                    ->all();
            }
        );
    }

    /**
     * Base price accessor override: if size prices exist, pick the lowest unless an explicit price stored.
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (!is_null($value)) {
                    return (float)$value; // explicit base price kept
                }
                $sizes = $this->normalized_size_prices; // accessor name auto kebab -> underscore
                if (!empty($sizes)) {
                    return collect($sizes)->min('price');
                }
                return null;
            }
        );
    }
}
