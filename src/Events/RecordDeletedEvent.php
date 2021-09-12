<?php

namespace Simbamahaba\Upepo\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecordDeletedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $config;
    public $records;

    /**
     * RecordDeletedEvent constructor.
     * Fired when a record is deleted.
     *
     * @param $config
     * @param $record_id
     */
    public function __construct($config, $record_id)
    {
        $this->config = $config;
        $this->records = is_array($record_id)?$record_id:(array)$record_id;
    }

}
