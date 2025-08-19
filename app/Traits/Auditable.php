<?php

namespace App\Traits;

use App\Models\ChangeHistory;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            self::logAction($model, 'created');
        });

        static::updated(function ($model) {
           $changes = $model->getChanges();
           unset($changes['updated_at']);

           if (!empty($changes)) {
               self::logAction($model, 'updated', $changes);
           }
        });

        static::deleted(function ($model) {
            self::logAction($model, 'deleted');
        });
    }
    protected static function logAction($model, string $action, array $changes = [])
    {
        ChangeHistory::create([
            'user_id' => request()->user()->id,
            'entity_type' => $model->getTable(),
            'entity_id' => $model->id,
            'action' => $action,
            'changes' => $changes,
        ]);
    }
}
