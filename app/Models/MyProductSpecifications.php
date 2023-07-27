<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyProductSpecifications extends Model
{
    use HasFactory;
    protected $table = "my_product_specifications";
    protected $primaryKey = 'id'; 

    public function subspecification()
    {
        return $this->hasMany(MyProductSubSpecification::class, 'my_subtitle_id');
    }
}
