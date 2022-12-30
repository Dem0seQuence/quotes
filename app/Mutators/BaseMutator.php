<?php

namespace App\Mutators;

abstract class BaseMutator
{
    abstract static function get($value): mixed;
}
