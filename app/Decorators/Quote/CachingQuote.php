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
        if ($value = Cache::get($this->getKeyPrefix() . "quotes:$author")) {
            return array_slice($value, 0, $limit);
        }

        $quotes = $this->quoteRepositoryContract->getQuotes($author, $limit);

        CachingJob::dispatch($this->getKeyPrefix() . "quotes:$author", self::TTL, $quotes);

        return $quotes;
    }

    private function getKeyPrefix(): string
    {
        return get_class($this->quoteRepositoryContract) . ':';
    }
}
