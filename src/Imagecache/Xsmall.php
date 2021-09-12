<?php

namespace Simbamahaba\Upepo\Imagecache;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Xsmall implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(20, 20);
    }
}