<?php

namespace App\Http\Controllers\Admin\Validators;

use App\Models\Alergen;
use App\Models\Lang;
use Throwable;

class Validator
{
    public $failed;


    private static function array_equal($a, $b)
    {
        array_multisort($a);
        array_multisort($b);
        return ( serialize($a) === serialize($b) );
    }

    public function validateLang($langParams)
    {
        $lang = Lang::all()->pluck('lang_code');
        if(!$this->array_equal($lang->toArray(), $langParams)){
            $this->failed = true;
        }
    }
    public function validateAlergen($alergenParams)
    {
        $alergen = Alergen::whereIn('id', $alergenParams)->pluck('id');
        if(!$this->array_equal($alergen->toArray(), $alergenParams)){
            $this->failed = true;
        }
    }
    public function createTranslations($params)
    {
        $lang = Lang::all()->pluck('lang_code');
        $arr = [];
        foreach ($lang as $l) {
            try {
                $arr[$l] = $params[$l];
            } catch (Throwable $e) {
                abort(404, 'Error setting translations');
            }
        }
        return $arr;
    }
}
