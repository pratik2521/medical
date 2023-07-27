<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormObjectTypeGroup extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $table = 'form_object_type_groups';
    public function formObjectType()
    {
        return $this->belongsTo(FormObjectType::class,'form_object_type_id');
    }
}
