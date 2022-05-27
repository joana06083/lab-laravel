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
        if (!isset($arr->Message)) {
            $insert_data = [];
            $update_data = [];

            foreach ($arr as $value) {
                $arr_data = [
                    'WagersID' => $value->WagersID,
                    'WagersDate' => $value->WagersDate,
                    'SerialID' => $value->SerialID ?? null,
                    'GameType' => $value->GameType,
                    'Result' => $value->Result,
                    'BetAmount' => $value->BetAmount,
                    'Commissionable' => $value->Commissionable,
                    'Payoff' => $value->Payoff,
                    'Currency' => $value->Currency,
                    'ExchangeRate' => $value->ExchangeRate,
                    'ModifiedDate' => $value->ModifiedDate,
                    'Origin' => $value->Origin,
                    'Star' => $value->Star ?? null,
                    'userNo' => $value->UserName,
                ];
                $record_check = WagersRecordInfo::where('WagersID', $value->WagersID)->get();
                $check_arr = json_decode($record_check, true);
                if (empty($check_arr)) {
                    array_push($insert_data, $arr_data);
                } else {
                    array_push($update_data, $arr_data);
                }

            }
            // 非重複id insert ,重複id＆資料異動 update
            WagersRecordInfo::insert($insert_data);

            foreach ($update_data as $key => $value) {
                $update[] = collect($update_data[$key]);
                $table = WagersRecordInfo::where('WagersID', $update_data[$key]['WagersID'])->get();
                $diff = collect($table[0])->diff($update[$key])->keys();

                foreach ($diff as $k => $v) {
                    $key_arr[] = $diff[$k];
                    $value_arr[] = $update_data[$key][$v];
                }
                if (!empty($key_arr) && !empty($value_arr)) {
                    $merge_list = array_combine($key_arr, $value_arr);
                    WagersRecordInfo::where('WagersID', $update_data[$key]['WagersID'])
                        ->update($merge_list);
                }
            }
            printf("Insert/update WagersRecord success!");
        } else {
            printf("Insert/update  WagersRecord fail!");
        }

    }
}
