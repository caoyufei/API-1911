<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Model\GoodsModel;
use Illuminate\Support\Facades\Redis;
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

    public function  userInfo()
    {
        echo 'userinfo11';
    }

    public function test2()
    {
        $url='http://www.1911.com/test2';
        $response=file_get_contents($url);
        var_dump($response);
    }



    //接口登录
    public function login(Request $request)
    {
        //echo '<prev>';print_r($_POST);echo '<prev>';die;
        $name=$request->post('name');
        $pass=$request->post('pass');
    }


    //商品详情
    public function goods(Request $request)
    {
        $goods_id = $request->get('id');
        $key = 'h:goods_info:' . $goods_id;

        //先判断缓存
        $goods_info = Redis::hgetAll($key);

        if (empty($info)) {
            echo "商品的ID:" . $goods_id;
            echo '<br>';
            $g = GoodsModel::select('goods_id', 'goods_sn', 'cat_id', 'goods_name')->find($goods_id);
            // dd($g);
            //缓存到redis
            $goods_info = $g->toArray();
            Redis::hmset($key, $goods_info);
            echo "无缓存";
            echo '<pre>';
            print_r($goods_info);
            echo '</pre>';
            die;
        } else {
            echo "缓存";
            echo '<pre>';
            print_r($goods_info);
            echo '</pre>';
            die;
            }
        }

    public function test1()
    {
        echo __METHOD__;
    }

}
