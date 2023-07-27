<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyProductGalleries extends Model
{
    use HasFactory;
    protected $table = "my_product_galleries";
    protected $fillable = [
        'is_deleted'
    ];

}
