<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function failedLang()
    {
        return response(['errors' => 'Sent languages do not match existing languages'], 400);
    }
    public function failedAlergen()
    {
        return response(['errors' => 'Sent alergens do not match existing alergens'], 400);
    }
    public function successResponse(){
        return response(['status' => 'success'], 200);
    }
}
