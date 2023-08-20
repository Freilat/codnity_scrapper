<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\FetchTopStories;

class RunScrapper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrapper:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs job to fetch top stories from https://news.ycombinator.com/';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        FetchTopStories::dispatch();
    }
}
