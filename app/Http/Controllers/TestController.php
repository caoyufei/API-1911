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

    public function ase1()
    {
        $data='hello world';    //原始数据
        $method='AES-256-CBC';   //加密算法
        $key='1911api';   //加密密钥
        $iv='aaaabbbbccccdddd';   //初始化iv  cbc加密方式使用

        echo "原始数据：".$data;echo '</br>';

        $enc_data=openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);
        echo "加密的密文：".$enc_data;echo '</br>';

        echo '<hr>';

        $dec_data=openssl_decrypt($enc_data,$method,$key,OPENSSL_RAW_DATA,$iv);

        echo "解密的密文：".$dec_data;
    }

        //post解密
    public function dec1(Request $request)
    {
        $key='1911api';
        $iv='aaaabbbbccccdddd';
        $method='AES-256-CBC';

        $enc_data=$request->post('data');

        //解密数据
        $dec_data=openssl_decrypt($enc_data,$method,$key,OPENSSL_RAW_DATA,$iv);
        var_dump($dec_data);

    }

    //解密
    public function dec(Request $request)
    {
        $method='AES-256-CBC';
        $key='1911api';
        $iv='aaaabbbbccccxxxx';
        $option=OPENSSL_RAW_DATA;


       // $content=file_get_contents("php://input"); //接受post原始数据
        echo '<pre>';print_r($_POST);echo '</pre>';echo '</br>';

        //echo $content;die;
        $enc_data=base64_decode($_POST['data']);


//        $enc_data=base64_decode($request->get('data'));

        //解密数据
        $dec_data=openssl_decrypt($enc_data,$method,$key,$option,$iv);

        echo "解密数据：".$dec_data;

    }

    public  function  rsa1()
    {
        $data="长江长江我是黄河";

        $content=file_get_contents(storage_path('keys/pub.key'));
        $pub_key=openssl_get_publickey($content);
        //var_dump($pub_key);die;
        openssl_public_encrypt($data,$enc_data,$pub_key);
        var_dump($enc_data);


    }

    public  function sign1(Request $request)
    {
        $key='1911api';  //计算签名的key

        //接收数据
        $data=$request->get('data');
        $sign=$request->get('sign');  //接收到的签名

        //计算签名
        $sign_str1=md5($data.$key);
    }

}
