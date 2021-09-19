<?php

namespace Simbamahaba\Upepo\Observers;

use Simbamahaba\Upepo\Models\Image;
use Simbamahaba\Upepo\Helpers\Traits\Pics;
use Illuminate\Support\Facades\Storage;
class ImageObserver
{
    use Pics;
    /**
     * Monitors "images" table
     * Removes physical image
     *
     * @param Image $image
     */
    public function deleted(Image $image)
    {
        Storage::disk('uploads')->delete([
            '/'.$image->name,
            '/'.$this->prepend_picture_name($image->name),
        ]);
    }
}
