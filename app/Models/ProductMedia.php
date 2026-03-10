<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMedia extends Model
{

    protected $table = 'product_media';


    protected $fillable = [
        "product_id",
        "media_type",
        "url",


    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
