<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
    protected $table = 'user'; // 資料表名稱
    protected $primaryKey = 'user_no'; // 主鍵
    public $timestamps = false; //沒有設定 created_at 或 updated_at 的欄位，不需要時間戳記
    protected $fillable =
        ['user_no', 'user_name', 'password', 'sex'];
}

class User extends Model
{
    protected $fillable = ['user_no', 'user_name', 'password', 'sex'];
    protected $guarded = ['password'];
}
