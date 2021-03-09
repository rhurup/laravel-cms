<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

/**
 * Trait ModelActionsBy
 * This trait tries to maintain who did change a model, by setting:
 * - created_by when a model is created
 * - updated_by when a model is created or saved
 * - deleted_by when a model is deleted
 *
 * Note - This trait requires ModelHelpers trait
 *
 * @package App\Traits
 */
trait ModelActionsBy
{
    /**
     * Add isNew to newly created singular models
     * @see https://hdtuto.com/article/how-to-create-events-for-created-updated-deleted-model-task-in-laravel-5
     */
    protected static function bootModelActionsBy()
    {
        static::creating(function ($item) {
            $default_id = (int)Auth::id();
            $created_by = $item->created_by ?? false;
            $updated_by = $item->updated_by ?? false;

            if ($item->tableHas('created_by') && $created_by === false) {
                $item->created_by = $default_id;
            }

            if ($item->tableHas('updated_by') && $updated_by === false) {
                $item->updated_by = $default_id;
            }

            if ($item->tableHas('deleted_at')) {
                $item->deleted_by = '0';
            }
        });

        static::created(function ($item) {
            $item->isNew = $item->wasRecentlyCreated;
        });

        static::updating(function ($item) {
            if ($item->tableHas('updated_by')) {
                $item->updated_by = (int)Auth::id();
            }
        });

        static::updated(function ($item) {
            // Kept as example
        });

        static::deleting(function ($item) {
            if ($item->tableHas('deleted_by')) {
                $item->deleted_by = (int)Auth::id();
                $item->save(); // Yes - we need to save it: https://laracasts.com/discuss/channels/laravel/laravel-observer-not-adding-deleted-by-soft-delete
            }
        });

        static::deleted(function ($item) {
            // Kept as example
        });
    }
}
