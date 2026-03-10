<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{

    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'sku',
        'price',
        'stock_quantity',
        'low_stock_threshold',
        'description',
        'dimensions',
        'energy_rating',
        'is_available',
    ];

    public function media()
    {
        return $this->hasMany(ProductMedia::class, 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock_quantity <= 0) {
            return 'Out of Stock!';
        }

        if ($this->stock_quantity <= $this->low_stock_threshold) {
            return 'Low Stock';
        }

        return 'In Stock!';
    }
}
