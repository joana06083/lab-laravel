<?php
namespace App\Enums;

enum Param
{
    case WEBSITE;
    case UPPERNAME;
    case DATE;
    public function Param(): string
    {
        date_default_timezone_set("America/New_York");
        return match($this) 
        {
            Param::WEBSITE => 'bbinbgp',   
            Param::UPPERNAME =>  'dpidtest',  
            Param::DATE =>  date("Ymd"),  
        };
    }
}
