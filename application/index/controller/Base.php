<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Cache;

class Base extends Controller
{
    public function initialize()
    {
        $shop_info = Cache::get('shop_info');
        if (empty($shop_info)) {
            return reMsg(0, url('index/login/login'), '您还未登录，请登录后查看');
        }

    }
}