<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function getTreatedImage($imgName){
        $url = 'storage/img/'.$imgName;
        $treatedUrl = str_replace('public/','', url($url));
        return $treatedUrl;
    }

    function toArray($object){
        return array_values((array) $object);
    }
}
