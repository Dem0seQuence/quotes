<?php

namespace App\Providers;

use App\Contracts\QuoteRepositoryContract;
use App\Decorators\Quote\CachingQuote;
use App\Repositories\Quote\ApiQuoteRepository;
use App\Repositories\Quote\EloquentQuoteRepository;
use App\Repositories\Quote\JsonQuoteRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
//        $this->app->bind(
//            QuoteRepositoryContract::class,
//            fn($app) => new CachingQuote(new JsonQuoteRepository())
//        );
        $this->app->bind(
            QuoteRepositoryContract::class,
            fn($app) => new CachingQuote(new ApiQuoteRepository())
        );
//        $this->app->bind(
//            QuoteRepositoryContract::class,
//            fn($app) => new CachingQuote(new EloquentQuoteRepository())
//        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
