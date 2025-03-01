<?php

namespace App\Listeners;

use App\Events\CatalogChanged;
use App\Models\History;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogCatalogChange
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
        // History::create([
        //     'action' => $event->action,
        //     'old_data' => $event->old_data,
        //     'new_data' => $event->new_data,
        // ]);
    }

    /**
     * Handle the event.
     */
    public function handle(CatalogChanged $event): void
    {
        //
        History::create([
            'action' => $event->action,
            'old_data' => $event->old_data,
            'new_data' => $event->new_data,
        ]);
    }
}
