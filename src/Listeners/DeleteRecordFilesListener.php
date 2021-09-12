<?php

namespace Simbamahaba\Upepo\Listeners;

use Simbamahaba\Upepo\Events\RecordDeletedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class DeleteRecordFilesListener
{
    /**
     * Handle the event.
     *
     * @param RecordDeletedEvent $event
     * @return void
     */
    public function handle(RecordDeletedEvent $event)
    {
        foreach($event->records as $record_id){
            Storage::disk('uploaded_files')->deleteDirectory('/'.$event->config['tableName'].'/'.$record_id);
        }
    }
}
