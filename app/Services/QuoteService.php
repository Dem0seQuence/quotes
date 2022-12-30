<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\QuoteRepositoryContract;
use App\Decorators\Quote\ShoutingQuote;

class QuoteService
{
    public function __construct(protected QuoteRepositoryContract $quoteRepository)
    {
    }

    public function getShoutedQuotes(string $author, int $limit = 1): array
    {
        return app(ShoutingQuote::class, [$this->quoteRepository])->getQuotes($author, $limit);
    }
}
