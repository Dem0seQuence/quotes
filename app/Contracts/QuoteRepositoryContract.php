<?php

declare(strict_types=1);

namespace App\Contracts;

interface QuoteRepositoryContract
{
    public function getQuotes(string $author, int $limit = 1): array;
}
