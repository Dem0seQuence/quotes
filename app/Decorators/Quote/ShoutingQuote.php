<?php

declare(strict_types=1);

namespace App\Decorators\Quote;

use App\Contracts\QuoteRepositoryContract;
use App\Mutators\Shout;

class ShoutingQuote implements QuoteRepositoryContract
{
    public function __construct(protected QuoteRepositoryContract $quoteRepositoryContract)
    {
    }

    public function getQuotes(string $author, int $limit = 1): array
    {
        return array_map(fn($quote) => $this->shout($quote), $this->quoteRepositoryContract->getQuotes($author, $limit));
    }

    public function shout(string $quote): string
    {
        return Shout::get($quote);
    }
}
