<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Cache;

class Index extends Controller
{

    //公司简介
    public function index()
    {

        return $this->fetch();
    }

    //店铺信息
    public function info()
    {
        $shop_info = session('shop_info');


        if (!$shop_info) {
            return $this->view->fetch('login/login');
        }
        //登录账号
        $shop_info = json_decode($shop_info, true);
        $this->assign('data', $shop_info);
        return $this->fetch();
    }
}
