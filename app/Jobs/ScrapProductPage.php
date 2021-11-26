<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class ScrapProductPage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $url;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = Http::get($this->url);
        $crawler = (new Crawler($response->body()))->filter('.c-remodal-gallery__thumb.js-image-thumb img');
        $crawler->each(function ($node) {
            $src = $node->attr('data-src');
            $src = explode('?', $src)[0];
            $matches = [];
            \preg_match('/_(.*).jpg/i', $src, $matches);
            $name = $matches[1];
        });
    }
}
