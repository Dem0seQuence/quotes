<?php

namespace App\Console\Commands;

use App\Exceptions\QuoteLimitReachedException;
use App\Services\QuoteService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ShoutQuote extends Command
{
    protected $signature = 'quotes:shout {author} {--limit=1}';

    protected $description = 'This command shouts quotes from a given author';

    /**
     * @throws QuoteLimitReachedException
     */
    public function handle(QuoteService $quoteService): int
    {
        $this->output->listing($quoteService->getShoutedQuotes($this->argument('author'), $this->option('limit')));
        return CommandAlias::SUCCESS;
    }
}
