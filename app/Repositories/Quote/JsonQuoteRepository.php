<?php

declare(strict_types=1);

namespace App\Repositories\Quote;

use App\Contracts\QuoteRepositoryContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class JsonQuoteRepository implements QuoteRepositoryContract
{
    protected ?Collection $data = null;

    public function getQuotes(string $author, int $limit = 1): array
    {
        return $this->getData()
            ->filter(fn($quote) => $quote['author'] === $author || $quote['author_slug'] === Str::slug($author))
            ->take($limit)
            ->pluck('quote')
            ->toArray();
    }

    private function getData(): Collection
    {
        if ($this->data) {
            return $this->data;
        }

        return $this->data = collect(json_decode($this->getJson(), true)['quotes'] ?? [])
            ->map(fn($quote) => [...$quote, 'author_slug' => Str::slug($quote['author'] ?? '')]);
    }

    public function getJson(): string
    {
        return File::get(storage_path('app/quotes.json'));
    }
}
