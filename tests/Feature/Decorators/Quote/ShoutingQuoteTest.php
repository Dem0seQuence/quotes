<?php

namespace Tests\Feature\Decorators\Quote;

use App\Contracts\QuoteRepositoryContract;
use App\Decorators\Quote\ShoutingQuote;
use App\Models\Quote;
use App\Repositories\Quote\EloquentQuoteRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Mockery\MockInterface;
use Tests\TestCase;

class ShoutingQuoteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_shouting_decorator()
    {
        $eloquentRepository = $this->mock(EloquentQuoteRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('getQuotes')->once()->andReturn(['My name is Bond, James Bond!']);
        });

        $this->app->bind(QuoteRepositoryContract::class, fn($app) => new ShoutingQuote($eloquentRepository));

        $this->assertEquals(
            ['MY NAME IS BOND, JAMES BOND!'],
            $this->app->make(QuoteRepositoryContract::class)->getQuotes('James Bond')
        );
    }
}
