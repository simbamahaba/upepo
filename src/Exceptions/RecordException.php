<?php


namespace Simbamahaba\Upepo\Exceptions;


class RecordException extends \Exception
{
    public static function notFound($id)
    {
        return new static(get_called_class().": The record id #$id was not found.");
    }
}
