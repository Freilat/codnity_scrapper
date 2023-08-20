<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Item;
use Illuminate\Support\Facades\Validator;

class ProcessItem implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $itemId;

    /**
     * Create a new job instance.
     */
    public function __construct($itemId)
    {
        $this->itemId = $itemId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $itemUrl = 'https://hacker-news.firebaseio.com/v0/item/' . $this->itemId . '.json';
        $itemJson = file_get_contents($itemUrl);
        $jsonDecoded = json_decode($itemJson,true);

        $validator = Validator::make($jsonDecoded, [
            'id' => ['present', 'integer'],
            'url' => ['present', 'string',],
            'title' => ['present', 'string',],
            'score' => ['present', 'integer',],
            'time' => ['present', 'integer',],
        ]);

                
        if ($validator->fails()) {
            return;
        }

        $validated = $validator->validated();
        

        $item = Item::withTrashed()->firstOrNew(
            ['id' => $validated['id']],
            ['title' => $validated['title'], 'url' => $validated['url'], 'time' => $validated['time']]
        );

        if (!$item->trashed()) {
            $item->score = $validated['score'];
            $item->save();
        }     
    }
}
