<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ScrapProductList;

class ScrapDigikala extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:digikala {page}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $toPage = (int)$this->argument('page');
        for ($i=1;$i<=$toPage;$i++) {
            $url = "https://www.digikala.com/treasure-hunt/products/?pageno=${i}&sortby=1";
            ScrapProductList::dispatch($url);
        }
        return Command::SUCCESS;
    }
}
