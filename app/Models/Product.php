<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'external_id',
        'sku',
        'name',
        'slug',
        'brand',
        'description',
        'supplier_price',
        'price',
        'stock',
        'stock_status',
        'thumbnail',
        'is_active',
        'last_synced_at',
    ];

    protected function casts(): array
    {
        return [
            'supplier_price' => 'decimal:2',
            'price' => 'decimal:2',
            'stock' => 'integer',
            'is_active' => 'boolean',
            'last_synced_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }

    public function isInStock(): bool
    {
        return $this->stock > 0 && $this->stock_status === 'in_stock';
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
