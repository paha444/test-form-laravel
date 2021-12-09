<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Validator;

use DB;

class Packages extends Model
{
    use HasFactory;
    
    
    public static function ValidateFields($data)
    {
        
            $validator = Validator::make($data, [
                'TTN' => ['required', 'max:17'],
                'Sender' => ['required'],
                'Recipient' => ['required'],
                'Sender_city' => ['required'],
                'Recipient_city' => ['required']
            ]);
            
            
            return $validator; 
        

    }

    public static function ValidateFields2($data)
    {
        
            $validator = Validator::make($data, [
                'Sender' => ['required'],
                'Recipient' => ['required'],
                'Sender_city' => ['required'],
                'Recipient_city' => ['required']
            ]);
            
            
            return $validator; 
        

    }
    

    public static function getPackageId($TTN)
    {
        $result = self::where('TTN', $TTN)->select('id')->first();
        if($result):
            return $result->id;
        else:
            return false;
        endif;
    }  
    
    
    public static function getCountryCode($name)
    {

        $result = DB::table('cities')
                  ->leftJoin('countries', 'countries.id', '=', 'cities.country_id')
                  ->where('cities.name', $name)
                  
                  ->select('countries.*')                  
                  
                  
                  ->first(); 
                  
        //return $result; 
        
        
        if($result):
            return $result->code;
        else:
            return '(NO_CODE)';
        endif;        
        
        
        

/*
        $result = self::where('TTN', $TTN)->select('id')->first();
        if($result):
            return $result->id;
        else:
            return false;
        endif;
        
*/        
    }
       
    
}
