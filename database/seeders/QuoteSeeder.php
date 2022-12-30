<?php

namespace Database\Seeders;

use App\Models\Quote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quotes')->truncate();

        $dump = json_decode(file_get_contents(storage_path('app/quotes.json')), true)['quotes'] ?? [];

        Quote::insert(array_map(fn($quote) => [...$quote, 'author_slug' => Str::slug($quote['author'])], $dump));
    }
}
