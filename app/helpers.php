<?php

use Illuminate\Support\Facades\Config;

if (!function_exists('thisSuccess')) {
    function thisSuccess($msg, $content=null, $code=200) {
        return response()->json([
            'status' => true,
            'content' => $content,
            'message' => $msg
        ], $code);
    }
}

if (!function_exists('thisError')) {
    function thisError($msg, $content=null, $code=400) {
        return response()->json([
            'status' => false,
            'content' => $content,
            'message' => $msg
        ], $code);
    }
}

if (!function_exists('waFormater')) {
    function waFormater($nohp) {
        $nohp = str_replace(".", "", $nohp);
        $nohp = str_replace(",", "", $nohp);
        $hp = null;
        if(!preg_match('/[^0-9]/', trim($nohp))){
            if(substr(trim($nohp), 0, 2)=='62'){
                $hp = trim($nohp);
            }elseif(substr(trim($nohp), 0, 1)=='0'){
                $hp = '62'.substr(trim($nohp), 1);
            }
        }

        return $hp;
    }
}