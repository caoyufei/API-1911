<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
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

    public function getWxToken2()
    {
        $appid='wx81daee32b142c95e';
        $appsecret ='cb2ca80424b1bab9b20fb1edcfa59c33';
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;

        $ch=curl_init();  //创建一个新的url资源

        //设置url和相应的选项
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        //抓取url并把它传递给浏览器
        $response=curl_exec($ch);

        //关闭url资源，并且释放系统资源
        curl_close($ch);
        echo $response;
    }

    public function getWxToken3()
    {
        $appid='wx81daee32b142c95e';
        $appsecret ='cb2ca80424b1bab9b20fb1edcfa59c33';
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;

        $client=new Client();
        $response=$client->request('GET',$url);

        $data=$response->getBody();

        echo $data;
    }
}
