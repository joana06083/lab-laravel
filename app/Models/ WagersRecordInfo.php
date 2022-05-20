<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WagersRecordInfo extends Model
{
    protected $table = 'wagersRecord'; // 資料表名稱
    protected $primaryKey = 'WagersID'; // 主鍵
    public $timestamps = false; // 沒有設定時間 created_at 或 updated_at 的欄位，不需要時間戳記
    public $incrementing = false; // 主鍵不是數字要設置
}
