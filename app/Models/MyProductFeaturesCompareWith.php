<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyProductFeaturesCompareWith extends Model
{
    use HasFactory;
    protected $table = "my_product_features_compares";
    public function myProduct()
    {
        return $this->belongsTo(MyProduct::class, 'my_product_id');
    }

    public function myProductWith()
    {
        return $this->belongsTo(MyProduct::class, 'my_product_with_id');
    }
}

