<?php
namespace Simbamahaba\Upepo\Helpers\Traits;

trait Pics{

    public function prepend_picture_name(string $pictureName, string $stringBefore = 'thumb_'): string
    {
        return substr_replace($pictureName, $stringBefore, strrpos($pictureName, '/') +1 ) . ltrim(strrchr($pictureName, '/'),'/');
    }

}
