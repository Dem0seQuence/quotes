<?php

namespace Tests\Feature\Repositories\Quote;

use App\Contracts\QuoteRepositoryContract;
use App\Repositories\Quote\JsonQuoteRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Tests\TestCase;

class JsonQuoteRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_json_repository_one_quote()
    {
        $jsonQuoteRepository = $this->partialMock(JsonQuoteRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('getJson')->once()->andReturn('{"quotes":[{"quote": "Nice quote", "author": "Steve Jobs"}]}');
        });

        $this->app->bind(QuoteRepositoryContract::class, fn($app) => $jsonQuoteRepository);

        $this->assertEquals(
            ['Nice quote'],
            $this->app->make(QuoteRepositoryContract::class)->getQuotes('Steve Jobs')
        );
    }

    public function test_json_repository_multiple_quotes()
    {
        $jsonQuoteRepository = $this->partialMock(JsonQuoteRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('getJson')->once()->andReturn('{"quotes":[{"quote": "Nice quote", "author": "Steve Jobs"}, {"quote": "Nice quote2", "author": "Steve Jobs"}, {"quote": "Nice quote3", "author": "Steve Jobs"}]}');
        });

        $this->app->bind(QuoteRepositoryContract::class, fn($app) => $jsonQuoteRepository);

        $this->assertEquals(
            ['Nice quote'],
            $this->app->make(QuoteRepositoryContract::class)->getQuotes('Steve Jobs')
        );

        $this->assertEquals(
            ['Nice quote', 'Nice quote2'],
            $this->app->make(QuoteRepositoryContract::class)->getQuotes('Steve Jobs', 2)
        );

        $this->assertEquals(
            ['Nice quote', 'Nice quote2', 'Nice quote3'],
            $this->app->make(QuoteRepositoryContract::class)->getQuotes('Steve Jobs', 4)
        );
    }
}
