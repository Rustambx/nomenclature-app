<?php

namespace App\Traits;

use App\Models\ChangeHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $userId =
            Auth::id()
            ?? optional(request()->user())->id
            ?? $model->created_by
            ?? $model->updated_by
            ?? null;

        try {
            ChangeHistory::create([
                'user_id'     => $userId,
                'entity_type' => $model->getTable(),
                'entity_id'   => $model->getKey(),
                'action'      => $action,
                'changes'     => $changes,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Audit log failed', [
                'model' => get_class($model),
                'id'    => $model->getKey(),
                'err'   => $e->getMessage(),
            ]);
        }
    }
}
