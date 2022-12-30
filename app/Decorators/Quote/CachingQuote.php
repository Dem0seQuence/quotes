<?php

declare(strict_types=1);

namespace App\Decorators\Quote;

use App\Contracts\QuoteRepositoryContract;
use App\Jobs\CachingJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CachingQuote implements QuoteRepositoryContract
{
    const TTL = 3600;

    public function __construct(protected QuoteRepositoryContract $quoteRepositoryContract)
    {
    }

    public function getQuotes(string $author, int $limit = 1): array
    {
        if ($value = $this->getFromCache($author, $limit)) {
            return $value;
        }

        $quotes = $this->quoteRepositoryContract->getQuotes($author, $limit);

        CachingJob::dispatch($this->getCacheKey($author, $limit), self::TTL, $quotes);

        return $quotes;
    }

    public function getFromCache(string $author, int $limit = 1): ?array
    {
        return Cache::get($this->getCacheKey($author, $limit));
    }

    public function getCacheKey(string $author, int $limit = 1): string
    {
        $author = Str::slug($author);
        return $this->quoteRepositoryContract::class . ":quotes:$author:$limit";
    }
}
