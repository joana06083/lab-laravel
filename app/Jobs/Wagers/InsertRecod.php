<?php

namespace App\Jobs\Wagers;

use App\ExternalApi\Wagers\Record;
use App\Models\WagersRecordInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertRecod implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $record = new Record;
        $arr = $record->GetWagersRecord($this->data);
        $record_data = [];

        if (!isset($arr->Message)) {
            foreach ($arr as $key => $value) {
                $arr_data = [
                    'WagersID' => $value->WagersID,
                    'WagersDate' => $value->WagersDate,
                    'GameType' => $value->GameType,
                    'Result' => $value->Result,
                    'BetAmount' => $value->BetAmount,
                    'Commissionable' => $value->Commissionable,
                    'Payoff' => $value->Payoff,
                    'Currency' => $value->Currency,
                    'ExchangeRate' => $value->ExchangeRate,
                    'ModifiedDate' => $value->ModifiedDate,
                    'Origin' => $value->Origin,
                    'userNo' => $value->UserName,
                ];

                if (!isset($value->Star)) {
                    $arr_data['Star'] = null;
                } else {
                    $arr_data['Star'] = $value->Star;
                }
                if (!isset($value->SerialID)) {
                    $arr_data['SerialID'] = null;
                } else {
                    $arr_data['Star'] = $value->SerialID;
                }
                array_push($record_data, $arr_data);
            }

            $recordCheck = WagersRecordInfo::whereIn('WagersID', array_column($record_data, 'WagersID'))->get();
            $recordCheckarr = json_decode($recordCheck, true);
            $diff = array_diff(array_map('serialize', $record_data), array_map('serialize', $recordCheckarr));
            $result = array_map('unserialize', $diff);
            WagersRecordInfo::insert($result);

            printf("Insert into article success!");
        } else {
            printf("Insert into article fail!");
        }

    }
}
