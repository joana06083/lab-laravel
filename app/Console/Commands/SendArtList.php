<?php

namespace App\Console\Commands;

// use App\Jobs\artInsertList;
use App\Models\ArticleInfo;
use Illuminate\Console\Command;

class SendArtList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    //command 指令 example php artisan articleInsert:userNo userNo
    protected $signature = 'articleInsert:userNo{userNo} {count}';

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
        $count = $this->argument('count');

        $this->info('Hello ' . $userNo . '!開始寫入資料共' . $count . '筆');
        $this->info('Start insert into article');
        if ($this->confirm('Do you wish to continue inserting data? [Y|N]')) {
            // command inserinto article
            for ($i = 1; $i <= $count; $i++) {
                ArticleInfo::insert([
                    'articleNo' => date('YmdHis', time()) . $i,
                    'articleTitle' => '寫入資料第' . $i . '筆',
                    'articleContent' => '寫入資料測試內容' . $i,
                    'userNo' => $userNo,
                ]);
            }
            $this->info('Insert into article success!');

            // using queue job
            // artInsertList::dispatch($userNo, $count)->onConnection('database')->onQueue('artInsertList');

        } else {
            $this->info('End');
        }
    }

}
