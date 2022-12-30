<?php

declare(strict_types=1);

namespace App\Decorators\Quote;

use App\Contracts\QuoteRepositoryContract;
use App\Jobs\CachingJob;
use Illuminate\Support\Facades\Cache;

class CachingQuote implements QuoteRepositoryContract
{
    const TTL = 3600;

    public function __construct(protected QuoteRepositoryContract $quoteRepositoryContract)
    {
    }

    public function getQuotes(string $author, int $limit = 1): array
    {
        $cacheKey = $this->getKeyPrefix() . "quotes:$author:$limit";

        if ($value = Cache::get($cacheKey)) {
            return $value;
        }

        $quotes = $this->quoteRepositoryContract->getQuotes($author, $limit);

        CachingJob::dispatch($cacheKey, self::TTL, $quotes);

        return $quotes;
    }

    private function getKeyPrefix(): string
    {
        return get_class($this->quoteRepositoryContract) . ':';
    }
}
