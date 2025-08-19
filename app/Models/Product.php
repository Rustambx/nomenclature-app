<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\SoftDeleteIsActive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeleteIsActive, Auditable;
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'supplier_id',
        'price',
        'file_url',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected $attributes = [
        'is_active' => true,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
