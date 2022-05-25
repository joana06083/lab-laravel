<?php
namespace App\Enums;

enum Key
{
    case SESSION;
    case BALANCE;
    case TRANSFER;
    case GAMEURL;
    case GAMETYPE;
    case RECORD;
    case RECORDDETAIL;

    public function KeyB(): string
    {
        return match($this) 
        {
            Key::SESSION => '4GZ2qQ',   
            Key::BALANCE =>  'D5zIM6',   
            Key::TRANSFER => 'yb89lxTRVB',   
            Key::GAMEURL => '09fJb0vYem',
            Key::GAMETYPE =>'601gyM',
            Key::RECORD =>'7uK3nZ6Y9',
            Key::RECORDDETAIL =>'51Rk82i',
        };
    }
}
