<?php

namespace App\Traits;

use Illuminate\Http\Request; 
use DB;
use App\Models\Language;
use Carbon\Carbon;
use Session;

trait GeneralTrait
{
    
    public static function getLanguage($locale = null){
        if ($locale) {
            $languages = Language::where('status','Active')->where('language_code', $locale)->first();
        } else {
            $languages = Language::where('status','Active')->get();
        }
        if(!empty($languages)){
            return $languages;
        }
    }  

    public static function getDefaultLanguage(){
        
        $languages = Language::where('status','Active')->where('by_default', 1)->first();
        
        if(!empty($languages)){
            return $languages;
        }
    }

    

}
