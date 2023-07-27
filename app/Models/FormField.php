<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class FormField extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
    public function formObjectType()
    {
        return $this->belongsTo(FormObjectType::class,'object_id');
    }

    public function formObjectTypeGroup()
    {
        return $this->belongsTo(FormObjectTypeGroup::class,'group_id');
    }
}
