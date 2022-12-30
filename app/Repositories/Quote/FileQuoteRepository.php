<?php

declare(strict_types=1);

namespace App\Repositories\Quote;

use App\Contracts\QuoteRepositoryContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FileQuoteRepository implements QuoteRepositoryContract
{
    protected Collection $data;

    public function __construct()
    {
        $this->data = collect(json_decode(file_get_contents(storage_path('app/quotes.json')), true)['quotes'] ?? [])
            ->map(fn($quote) => [...$quote, 'author_slug' => Str::slug($quote['author'] ?? '')]);
    }

    public function getQuotes(string $author, int $limit = 1): array
    {
        return $this->data->where('author_slug', Str::slug($author))->take($limit)->pluck('quote')->toArray();
    }
}
