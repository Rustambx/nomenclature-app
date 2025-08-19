<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait SoftDeleteIsActive
{
    public static function bootSoftDeleteIsActive()
    {
        static::addGlobalScope('is_active', function (Builder $builder) {
            $builder->where('is_active', true);
        });
    }

    public function delete()
    {
        $this->is_active = false;
        $this->save();

        return true;
    }

    public function restore()
    {
        $this->is_active = true;
        $this->save();

        return true;
    }

    public function forceDelete()
    {
        return parent::delete();
    }

    public function trashed()
    {
        return $this->is_active === false;
    }

    public function scopeWithTrashed($query)
    {
        return $query->withoutGlobalScope('is_active');
    }

    public function scopeOnlyTrashed($query)
    {
        return $query->withoutGlobalScope('is_active')
            ->where('is_active', false);
    }
}
