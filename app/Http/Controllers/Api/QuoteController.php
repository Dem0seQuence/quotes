<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\QuoteRequest;
use App\Services\QuoteService;
use Illuminate\Http\JsonResponse;

class QuoteController extends Controller
{
    public function shout(QuoteRequest $request, QuoteService $quoteService, string $author): JsonResponse
    {
        return response()->json(
            $quoteService->getShoutedQuotes($author, $request->get('limit', 1))
        );
    }
}
