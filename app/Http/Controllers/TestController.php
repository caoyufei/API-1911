<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function hello()
    {
        echo "hello world";
    }

    public function getWxToken()
    {
        $appid='wx81daee32b142c95e';
        $appsecret ='cb2ca80424b1bab9b20fb1edcfa59c33';
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
        $cont=file_get_contents($url);
        echo $cont;
    }
}
