<?php

namespace App\Exceptions;

use Exception;

class ModpackException extends Exception
{
    public static function invalidDisk(string $disk)
    {
        return new static("Provided disk '$disk' was not configured in 'config/filesystems.php', please choose another one or update the configuration file.");
    }
}
