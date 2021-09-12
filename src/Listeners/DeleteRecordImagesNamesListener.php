<?php

namespace Simbamahaba\Upepo\Listeners;

use Simbamahaba\Upepo\Events\RecordDeletedEvent;
use Simbamahaba\Upepo\Models\Image;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteRecordImagesNamesListener
{
    /**
     * Removes image(s) name(s) from "images" table
     *
     * @param  RecordDeletedEvent  $event
     * @return void
     */
    public function handle(RecordDeletedEvent $event)
    {
        Image::where('table_id', $event->config['tableId'])->whereIn('record_id',$event->records)->delete();
    }
}
