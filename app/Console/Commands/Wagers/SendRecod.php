<?php

namespace App\Console\Commands\Wagers;

use App\ExternalApi\Game\TypeList;
use App\Jobs\Wagers\InsertRecod;
use Illuminate\Console\Command;

class SendRecod extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //command 指令 example
    //改成自行輸入時間php artisan Record:Time 2022-05-25 00:00:00 23:59:59
    protected $signature = 'Record:Time {date? } {starttime? } {endtime? }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
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
        $type_list = new TypeList;
        $date = $this->argument('date');
        $starttime = $this->argument('starttime');
        $endtime = $this->argument('endtime');
        $game_kinds = ['3', '5', '12', '30', '31', '38', '66', '73', '75', '76', '93', '107', '109'];

        $data = [
            'action' => 'BetTime',
            'date' => $date ?? date("Y-m-d"),
            'starttime' => $starttime ?? '00:00:00',
            'endtime' => $endtime ?? '23:59:59',
        ];

        foreach ($game_kinds as $kind) {
            $data['gamekind'] = $kind;
            $type_request = ['lang' => 'zh-tw', 'gamekind' => $kind];
            foreach ($type_list->GetGameTypeList($type_request) as $list) {
                $data['gametype'] = $list->GameType;
                InsertRecod::dispatch($data)->onQueue('InsertRecod');
            }
        }

    }
}
