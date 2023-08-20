<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\ProcessItem;

class FetchTopStories implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
          //Gets all 
          $url = 'https://hacker-news.firebaseio.com/v0/topstories.json';
          $json = file_get_contents($url);
          $itemsIds = json_decode($json);
  
          foreach ($itemsIds as $key => $itemId) {
            ProcessItem::dispatch($itemId);
          }
    }
}
