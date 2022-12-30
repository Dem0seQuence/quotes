<?php

declare(strict_types=1);

namespace App\Mutators;

class Shout extends BaseMutator
{
    public static function get($value): string
    {
        return strtoupper((string)$value) . "!";
    }
}
