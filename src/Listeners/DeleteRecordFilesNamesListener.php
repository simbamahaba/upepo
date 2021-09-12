<?php

namespace Simbamahaba\Upepo\Listeners;

use Simbamahaba\Upepo\Events\RecordDeletedEvent;
use Simbamahaba\Upepo\Models\File;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteRecordFilesNamesListener
{
    /**
     * Removes file(s) name(s) from "files" table
     *
     * @param  RecordDeletedEvent  $event
     * @return void
     */
    public function handle(RecordDeletedEvent $event)
    {
        File::where('table_id', $event->config['tableId'])->whereIn('record_id',$event->records)->delete();
    }
}
