<?php

declare(strict_types=1);

namespace App\Repositories\Quote;

use App\Contracts\QuoteRepositoryContract;
use Illuminate\Support\Facades\Http;

class ApiQuoteRepository implements QuoteRepositoryContract
{
    public function getQuotes(string $author, int $limit = 1): array
    {
//        dd(Http::asJson()->acceptJson()->withHeaders([
//            'X-TheySaidSo-Api-Secret' => '123'
//        ])->get('https://quotes.rest/quote/search.json', ['author' => $author])->json());

        return collect(Http::asJson()->acceptJson()->get('https://quotes.rest/qod')->json('contents.quotes'))
            ->pluck('quote')
            ->toArray();
    }
}
