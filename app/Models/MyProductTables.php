<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyProductTables extends Model
{
    use HasFactory;
    protected $table = "my_product_tablesequences";
    public function child()
    {
     return $this->belongsTo(MyProductSqnc::class, 'sequence_id');
    }

}
