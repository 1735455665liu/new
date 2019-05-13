<?php

namespace App\Http\Controllers\Test;

use Encore\Admin\Grid\Filter\StartsWith;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    //对称加密
    public function getencrypt(){
        // 加密算法
        $encryptMethod = 'aes-256-cbc';
        // 明文数据
        $arr=[
            'nickname'=>'zhansan',
            'email'=>'zhansan@qq.com'
        ];
        $json=json_encode($arr);
        // 生成IV
        $iv='bbbbbbbbbbbbbbbq';
        // 加密
        $encrypted = openssl_encrypt($json, $encryptMethod, 'secret', 1,$iv);

        $base64en= base64_encode($encrypted);
        $url='http://api.1809a.com/getdncrypt';
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$base64en);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plian']);
        //发送
        $Arr=curl_exec($ch);
        var_dump($Arr);
        curl_close($ch);


    }

    public function test(){
        $text='Hllo word';
        $n=3;
        $this->ksen($text,$n);echo '恺撒加密';echo '<hr>';
        echo '恺撒解密'.$this->ksdn($text,$n);echo '<hr>';


      echo   date('Y-m-d H:i:s',Strtotime('-1 day'));

    }
    //凯撒加密
    public function ksen($text,$n){
          //要传输的数据
        $lenth=strlen($text); //获取数据的长度
        for ($i=0;$i<$lenth;$i++){
            $str0=ord($text[$i]);
            $pass = chr($str0+$n);
            echo $pass;
        }
    }
    //凯撒解密
    public function ksdn($text){
        $lenth=strlen($text);
        for ($i=0;$i<$lenth;$i++){
            $ord=ord($text[$i]);
            $pass=chr($ord);
            echo $pass;
        }

    }
    //非对称加密
    public function nocrypt(){

        $data=[
            'nickname'=>'liuziye',
            'age'=>'nan',
            'sex'=>1,
            'email'=>'liuziye@qq.com'
        ];
        $json_str=json_encode($data);
        //读私钥
        $private=openssl_pkey_get_private('file://'.storage_path('openssl/private.pem'));
        //私钥加密
        openssl_private_encrypt($json_str,$json_private,$private);
        $base64=base64_encode($json_private);
        $url="http://api.1809a.com/getnocrypt";
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$base64);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plian']);
        //发送
        $res=curl_exec($ch);
//        var_dump($res);
        curl_close($ch);



        $public=openssl_get_publickey('file://'.storage_path('openssl/public.pem'));
        openssl_public_decrypt($json_private,$json_public,$public);
//        echo '<pre>';print_r($json_public);echo '<pre>';
    }
    //非对称加密签名
    public function nosign(){
        //对订单数据进行签名
        $data=[
            'oid'=>1,
            'name'=>'订单',
            'order_id'=>12323123
        ];
        $json=json_encode($data);//转化为json串
        $url='http://api.1809a.com/sign?sign='.urlencode($json);//通过url把数据传过去
        //读私钥
        $private=openssl_pkey_get_private('file://'.storage_path('openssl/private.pem'));
        //生成签名
        openssl_sign($json,$value,$private);
        $base64=base64_encode($value);//转换成base64传输数据
//        echo '<pre>';print_r($base64);echo '<pre>';
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$base64);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plian']);

        //发送
        curl_exec($ch);
        $error=curl_errno($ch);
        if($error>0){
            echo '错误码'.$error;
            exit;
        }

        //结束会话
        curl_close($ch);


    }

    //注册
    public function reg(Request $request){
        $data=$request->all();
        $arr=[
          'name'=>$data['name'],
          'pass'=>$data['pass'],
          'email'=>$data['email']
        ];
        $jsonen=json_encode($arr,JSON_UNESCAPED_UNICODE);
        //非对称加密        //读私钥
        $pri=openssl_pkey_get_private('file://'.storage_path('openssl/private.pem'));
        //加密
        openssl_private_encrypt($jsonen,$value,$pri);
        $base=base64_encode($value);

        $url='http://api.1809a.com/regdo';    //传输数据地址
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$base);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plian']);

        //发送
        curl_exec($ch);
        $eerror=curl_errno($ch);
        if($eerror>0){
            echo '状态码错误'.$eerror;
            exit;
        }
        //结束会话
        curl_close($ch);
        return view('reg');
    }


    //登录
    public function login(Request $request){
        $data=$request->all();
//        var_dump($data);
        return view('login');
    }


}
