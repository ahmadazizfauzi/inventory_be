<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'sku',
        'name',
        'purchase_price',
        'selling_price',
        'stock',
        'min_stock',
    ];

    protected $appends = [
        'stock_status',
    ];

    protected function casts(): array
    {
        return [
            'purchase_price' => 'float',
            'selling_price' => 'float',
            'stock' => 'integer',
            'min_stock' => 'integer',
        ];
    }

    // Product belongs to a single category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Product has historical stock mutations
    public function stockMutations(): HasMany
    {
        return $this->hasMany(StockMutation::class);
    }

    // Dynamic stock status based on current stock level
    public function getStockStatusAttribute(): string
    {
        if ($this->stock <= 0) {
            return 'out_of_stock';
        }

        if ($this->stock <= $this->min_stock) {
            return 'low_stock';
        }

        return 'in_stock';
    }
}
