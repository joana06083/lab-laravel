<?php

namespace App\Console\Commands;

use App\Jobs\artInsertList;
use Illuminate\Console\Command;

class SendArtList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    //command 指令 example php artisan articleInsert:userNo userNo
    protected $signature = 'articleInsert:userNo{userNo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command description';

    /**
     * 創建命令
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        printf("%s: created a worker start\n", now()->format('Y-m-d H:i:s'));
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userNo = $this->argument('userNo');
        $this->info('Hello ' . $userNo);
        if ($this->confirm('Do you wish to continue inserting data? [Y|N]')) {
            $this->info('Start insert into article');

            // using queue job
            artInsertList::dispatch()->onQueue('artInsertList');

        } else {
            $this->info('End');
        }
    }

}
