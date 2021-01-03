<?php

namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;

class ModPackException extends Exception
{
    #[Pure] public static function invalidDisk(string $disk): static
    {
        return new static("Provided disk '$disk' was not configured in 'config/filesystems.php', please choose another one or update the configuration file.");
    }
}
