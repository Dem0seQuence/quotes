<?php

namespace Tests\Feature\Decorators\Quote;

use App\Contracts\QuoteRepositoryContract;
use App\Decorators\Quote\CachingQuote;
use App\Jobs\CachingJob;
use App\Repositories\Quote\EloquentQuoteRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use Mockery\MockInterface;
use Tests\TestCase;

class CachingQuoteTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_cache_missed_and_caching_job_pushed()
    {
        Queue::fake();

        $eloquentRepository = $this->mock(EloquentQuoteRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('getQuotes')->once()->andReturn(['My name is Bond, James Bond']);
        });

        $this->app->bind(QuoteRepositoryContract::class, fn($app) => new CachingQuote($eloquentRepository));

        /** @var CachingQuote $cachingQuote */
        $cachingQuote = $this->app->make(QuoteRepositoryContract::class);

        $this->assertEquals(
            ['My name is Bond, James Bond'],
            $cachingQuote->getQuotes('James Bond'),
        );

        Queue::assertPushed(CachingJob::class);
    }
}
