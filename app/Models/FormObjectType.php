<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormObjectType extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $table = 'form_object_types';

    public function formobjgr()
    {
        return $this->hasMany(FormObjectTypeGroup::class);
    }
}
