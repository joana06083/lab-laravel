<?php
namespace App\Enums;

enum ApiName
{
    case SESSION;
    case BALANCE;
    case TRANSFER;
    case GAMEURL;
    case GAMETYPE;
    case RECORD;
    case RECORDDETAIL;

    public function Name(): string
    {
        return match($this) 
        {
            ApiName::SESSION => 'CreateSession',   
            ApiName::BALANCE =>  'CheckUsrBalance',   
            ApiName::TRANSFER => 'Transfer',   
            ApiName::GAMEURL => 'GameUrlBy',
            ApiName::GAMETYPE =>'GetGameTypeList',
            ApiName::RECORD =>'WagersRecordBy',
            ApiName::RECORDDETAIL =>'GetWagersSubDetailUrlBy',
        };
    }
}
