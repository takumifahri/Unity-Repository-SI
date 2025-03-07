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
        $user = Auth::user();
        if ($user) {
            $changes = $catalog->getChanges();
            $newValues = [];
            $oldValues = [];
            foreach ($changes as $field => $newValue) {
                $oldValue = $catalog->getOriginal($field);
                $newValues[$field] = $newValue;
                $oldValues[$field] = $oldValue;
            }
            HistoryAll::create([
                'user_id' => $user->id,
                'items_id' => $catalog->id,
                'new_value' => json_encode($newValues), // Convert new values to JSON
                'old_value' => json_encode($oldValues), // Convert old values to JSON
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
            'user_id' => Auth::id(),
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
