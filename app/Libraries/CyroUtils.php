<?php

namespace App\Libraries;

use Ramsey\Uuid\Uuid;

class CyroUtils
{
    function generateRandomID(?string $prefix)
    {
        $uuid = Uuid::uuid4()->toString();
        if ($prefix === null) {
            return $uuid;
        }
        return "$prefix-$uuid";
    }
}
