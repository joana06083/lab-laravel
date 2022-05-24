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
    //command 指令 example php artisan Record
    protected $signature = 'Record';

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
        $game_kinds = ['3', '5', '12', '30', '31', '38', '66', '73', '75', '76', '93', '107', '109'];

        $data = [
            'action' => 'BetTime',
            'date' => date("Y-m-d"),
            'starttime' => '00:00:00',
            'endtime' => '23:59:59',
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
