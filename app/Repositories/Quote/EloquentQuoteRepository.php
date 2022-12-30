<?php

declare(strict_types=1);

namespace App\Repositories\Quote;

use App\Contracts\QuoteRepositoryContract;
use App\Models\Quote;
use Illuminate\Support\Str;

class EloquentQuoteRepository implements QuoteRepositoryContract
{
    public function getQuotes(string $author, int $limit = 1): array
    {
        return Quote::where('author_slug', Str::slug($author))
            ->orWhere('author', $author)
            ->limit($limit)
            ->pluck('quote')
            ->toArray();
    }
}
