<?php

namespace Tests\Unit\Mutators;

use App\Mutators\Shout;
use PHPUnit\Framework\TestCase;
use stdClass;

class ShoutTest extends TestCase
{
    public function test_shouting_mutator_with_simple_quote(): void
    {
        $this->assertEquals('MY QUOTE!', Shout::get('my quote'));
        $this->assertEquals('MY QUOTE!', Shout::get('my quote!'));
    }

    public function test_shouting_mutator_with_empty_quote(): void
    {
        $this->assertEquals('', Shout::get(''));
    }

    public function test_shouting_mutator_with_non_shoutable_value(): void
    {
        $this->assertEquals('', Shout::get([]));
        $this->assertEquals('', Shout::get(new stdClass()));
    }
}
