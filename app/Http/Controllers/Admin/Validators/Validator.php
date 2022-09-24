<?php

namespace App\Http\Controllers\Admin\Validators;

use App\Models\Lang;
use Throwable;

class Validator {
    public $failed;
    
    protected function validateLang($langParams){
        $lang = Lang::all()->pluck('lang');
        if($lang = $langParams){
            return true;
        }
        else{
            return false;
        }
    }
    public function validateKeys($langs)
    {
        if ($this->validateLang($langs)) {
            $this->failed = false;
        } else {
            $this->failed = true;
        }
    }
    public function createTranslations($params)
    {
        $lang = Lang::all()->pluck('lang');
        $arr = [];
        foreach ($lang as $l) {
            try{
                $arr[$l] = $params[$l];
            }
            catch(Throwable $e){
                abort(404, 'Error setting translations');
            }
            }
        return $arr;
    }
}