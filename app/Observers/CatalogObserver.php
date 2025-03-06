<?php

namespace App\Observers;

use App\Models\Catalog;
use App\Models\DeleteDetail;
use App\Models\DeleteReason;
use App\Models\HistoryAll;
use Illuminate\Support\Facades\Auth;

class CatalogObserver
{
    /**
     * Handle the Catalog "created" event.
     */
    public function created(Catalog $catalog): void
    {
        //
        $user = Auth::user();
        if ($user) {
            HistoryAll::create([
                'user_id' => $user->id,
                'items_id' => $catalog->id,
                'new_value' => json_encode($catalog->getAttributes()), // Convert attributes to JSON
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Handle the Catalog "updated" event.
     */
    public function updated(Catalog $catalog): void
    {
        //
        $changes = $catalog->getChanges();
        foreach ($changes as $field => $newValue) {
            $oldValue = $catalog->getOriginal($field);
            HistoryAll::create([
                'items_id' => $catalog->id,
                'new_value' => $newValue,
                'old_value' => $oldValue,
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Handle the Catalog "deleted" event.
     */
    public function deleted(Catalog $catalog, DeleteDetail $deleteReason): void
    {
        //
        HistoryAll::create([
            'items_id' => $catalog->id,
            'reason' => $deleteReason->reason,
            'deleted_at' => now(),
        ]);
    }

    /**
     * Handle the Catalog "restored" event.
     */
    public function restored(Catalog $catalog): void
    {
        //
    }

    /**
     * Handle the Catalog "force deleted" event.
     */
    public function forceDeleted(Catalog $catalog): void
    {
        //
    }
}
