<?php

namespace Tests\Feature\Repositories\Quote;

use App\Contracts\QuoteRepositoryContract;
use App\Models\Quote;
use App\Repositories\Quote\EloquentQuoteRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class EloquentQuoteRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_eloquent_repository_one_quote()
    {
        $this->app->bind(QuoteRepositoryContract::class, fn($app) => new EloquentQuoteRepository());

        Quote::create([
            'author' => 'James Bond',
            'author_slug' => Str::slug('James Bond'),
            'quote' => 'My name is Bond, James Bond'
        ]);

        Quote::create([
            'author' => 'Jeff Bezos',
            'author_slug' => Str::slug('Jeff Bezos'),
            'quote' => 'Amazing!'
        ]);

        $this->assertDatabaseCount('quotes', 2);

        $this->assertEquals(
            ['My name is Bond, James Bond'],
            $this->app->make(QuoteRepositoryContract::class)->getQuotes('James Bond')
        );
    }

    public function test_eloquent_repository_multiple_quotes()
    {
        $this->app->bind(QuoteRepositoryContract::class, fn($app) => new EloquentQuoteRepository());

        Quote::create([
            'author' => 'Jeff Bezos',
            'author_slug' => Str::slug('Jeff Bezos'),
            'quote' => 'Amazon'
        ]);

        Quote::create([
            'author' => 'Jeff Bezos',
            'author_slug' => Str::slug('Jeff Bezos'),
            'quote' => 'Amazing!'
        ]);

        $this->assertDatabaseCount('quotes', 2);

        $this->assertEquals(
            [],
            $this->app->make(QuoteRepositoryContract::class)->getQuotes('James Bond')
        );

        $this->assertEquals(
            ['Amazon'],
            $this->app->make(QuoteRepositoryContract::class)->getQuotes('Jeff Bezos')
        );

        $this->assertEquals(
            ['Amazon', 'Amazing!'],
            $this->app->make(QuoteRepositoryContract::class)->getQuotes('Jeff Bezos', 2)
        );

        $this->assertEquals(
            ['Amazon', 'Amazing!'],
            $this->app->make(QuoteRepositoryContract::class)->getQuotes('Jeff Bezos', 10)
        );
    }
}
