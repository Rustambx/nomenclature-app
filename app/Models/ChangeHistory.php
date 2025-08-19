<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChangeHistory extends Model
{
    public $timestamps = true;

    const UPDATED_AT = null;

    protected $fillable = [
        "user_id",
        "entity_type",
        "entity_id",
        "action",
        "changes",
        "created_at",
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

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
