<?php
namespace  Simbamahaba\Upepo\Exceptions;

class TableDefinition extends \Exception
{

    public static function notFound($tableName)
    {
        return new static(get_called_class().": The table definition for '$tableName' was not found.", 6);
    }

    public static function tableAcceptsNoFiles($tableName)
    {
        return new static(get_called_class().": The table '$tableName' doesn't accept files.", 7);
    }

}
