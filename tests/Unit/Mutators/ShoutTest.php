<?php

namespace Tests\Unit\Mutators;

use App\Mutators\Shout;
use PHPUnit\Framework\TestCase;

class ShoutTest extends TestCase
{
    public function test_shouting_mutator(): void
    {
        $this->assertEquals('MY QUOTE!', Shout::get('my quote'));
    }
}
