<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'userData'; // 資料表名稱
    protected $primaryKey = 'userNo'; // 主鍵
    public $timestamps = false; //沒有設定時間 created_at 或 updated_at 的欄位，不需要時間戳記
    //
    protected $fillable =
        ['userNo', 'userName', 'account', 'password', 'sex', 'email'];
    // protected $guarded = ['password'];
}
