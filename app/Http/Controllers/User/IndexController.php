<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Model\UserModel;
use Illuminate\Support\Str;
use App\Model\TokenModel;
class IndexController extends Controller
{
    //注册
    public function reg(Request $request)
    {
        $name=$request->post('name');
        $email=$request->post('email');
        $pass1=$request->post('pass1');
        $pass2=$request->post('pass2');

        //todo  验证用户名  email   密码

        $pass=password_hash($pass1,PASSWORD_BCRYPT);

        $user_info=[
            'name'=>$name,
            'email'=>$email,
            'password'=>$pass,
            'time'=>time()
        ];
        $result=UserModel::insertGetId($user_info);
        $response=[
            'errno'=>0,
            'msg'=>"ok"
        ];
        return $response;
    }


    //登录
    public function login(Request $request)
    {
        $name=$request->post('name');
        $pass=$request->post('password');

        //验证登录信息
        $res=UserModel::where(['name'=>$name])->first();
        if($res){

            //验证密码
            if(password_verify($pass,$res->password)){

                //生成token
                $token=Str::random(32);
                $expire_seconds=3600;   //token的有效期
                $data=[
                    'token'=>"$token",
                    'uid'=>$res->uid,
                    'expire_at'=>time()+7200,
                ];
                //入库
               $result=TokenModel::insertGetId($data);

                $response=[
                    'errno'=>0,
                    'msg'=>'ok',
                    'data'=>[
                        'token'=>$token,
                        'expire_in'=>$expire_seconds
                    ]
                ];

            }else{
                $response=[
                    'errno'=>50001,
                    'msg'=>'密码错误'
                ];
            }
        }else{
            $response=[
                'errno'=>'40001',
                'msg'=>'用户不存在'
            ];
        }
        return $response;
    }

    public function center(Request $request)
    {
        //验证是否有token
        $token=$request->get('token');
       if(empty($token)){
           $response=[
               'errno'=>40003,
               'msg'=>'未授权'
           ];
           return $response;
       }

        //验证token是否有效
        $t=TokenModel::where(['token'=>$token])->first();
       //未找到token信息
        if(empty($t)){
            $response=[
                'errno'=>40003,
                'msg'=>'token无效'
            ];
            return $response;
        }
        $user_info=UserModel::where("uid",$t->uid)->first();
        $response=[
            'errno'=>0,
            'msg'=>'ok',
            'data'=>[
                'user_info'=>$user_info
            ]
        ];
        return $response;
    }

    public function test2()
    {

    }

}
