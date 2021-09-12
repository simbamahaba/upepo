<?php

namespace Decoweb\Panelpack\Observers;

use Simbamahaba\Upepo\Models\File;
use Illuminate\Support\Facades\Storage;
class FileObserver
{
    /**
     * Monitors 'files' table
     * Removes physical file
     *
     * @param File $file
     */
    public function deleted(File $file)
    {
        Storage::disk('uploaded_files')->delete('/'.$file->table->table_name.'/'.$file->record_id.'/'.$file->name);
    }
}
