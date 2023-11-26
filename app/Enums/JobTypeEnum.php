<?php
  
namespace App\Enums;
 
enum JobTypeEnum:string {
    case FULL_TIME = 'full-time';
    case PART_TIME = 'part-time';
    case CONTRACT = 'contract';
    case TEMPORARY = 'temporary';


    public static function all(): array
    {
        $arr = [];

        foreach (self::cases() as $case) {
            $arr[] = $case->value;
        }

        return $arr;
    }
}