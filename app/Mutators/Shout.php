<?php

declare(strict_types=1);

namespace App\Mutators;

class Shout extends BaseMutator
{
    public static function get($value): string
    {
        if (empty($value)) {
            return '';
        }

        if (!is_numeric($value) && !is_string($value)) {
            return '';
        }

        if (str_ends_with($value, '!')) {
            return strtoupper($value);
        }

        return strtoupper((string)$value) . "!";
    }
}
