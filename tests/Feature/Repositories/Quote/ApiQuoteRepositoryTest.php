<?php

namespace Tests\Feature\Repositories\Quote;

use App\Contracts\QuoteRepositoryContract;
use App\Repositories\Quote\ApiQuoteRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiQuoteRepositoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Http::fake([
            'https://quotes.rest/qod' => Http::response([
                "success" => [
                    "total" => 1
                ],
                "contents" => [
                    "quotes" => [
                        [
                            "quote" => "If you respect yourself in stressful situations, it will help you see the positive! It will help you see the message in the mess.",
                            "length" => "135",
                            "author" => "Steve Maraboli",
                            "tags" => [
                                "inspire",
                                "self-respect",
                                "stress"
                            ],
                            "category" => "inspire",
                            "language" => "en",
                            "date" => "2020-02-02",
                            "permalink" => "https://theysaidso.com/quote/steve-maraboli-if-you-respect-yourself-in-stressful-situations-it-will-help-you",
                            "id" => "nwW3g7V0xszGDNIehz6yTgeF",
                            "background" => "https://theysaidso.com/img/bgs/man_on_the_mountain.jpg",
                            "title" => "Inspiring Quote of the day"
                        ]
                    ]
                ],
                "baseurl" => "https://theysaidso.com",
                "copyright" => [
                    "year" => 2022,
                    "url" => "https://theysaidso.com"
                ]
            ]),
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_api_random_quote()
    {
        $this->app->bind(QuoteRepositoryContract::class, fn($app) => new ApiQuoteRepository());

        $this->assertEquals(
            ['If you respect yourself in stressful situations, it will help you see the positive! It will help you see the message in the mess.'],
            $this->app->make(QuoteRepositoryContract::class)->getQuotes('anything-for-now')
        );
    }
}
