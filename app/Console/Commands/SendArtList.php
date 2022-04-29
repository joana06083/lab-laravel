<?php

namespace App\Console\Commands;

use app\Models\ArticleInfo;
use App\Support\DripEmailer;
use Illuminate\Console\Command;

class SendArtList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send drip artList';

    /**
     * 創建命令
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
    public function handle(DripEmailer $drip)
    {
        $drip->send(ArticleInfo::find($this->argument('art')));
    }
}
