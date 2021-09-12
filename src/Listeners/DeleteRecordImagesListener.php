<?php

namespace Simbamahaba\Upepo\Listeners;

use Simbamahaba\Upepo\Events\RecordDeletedEvent;
use Illuminate\Support\Facades\Storage;

class DeleteRecordImagesListener
{

    /**
     * Removes physical directories from storage
     *
     * @param RecordDeletedEvent $event
     * @return void
     */
    public function handle(RecordDeletedEvent $event)
    {
        foreach($event->records as $record_id){
            Storage::disk('uploads')->deleteDirectory('/'.$event->config['tableName'].'/'.$record_id);
        }
    }
}
