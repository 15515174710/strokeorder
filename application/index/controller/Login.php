<?php
namespace app\index\controller;

use app\admin\model\LoginLog;
use app\index\model\Shop;
use app\index\validate\LoginValidate;
use think\Controller;
use think\facade\Cache;

class Login extends Controller
{
//登录
    public function login()
    {
        return $this->fetch();
    }


    // 处理登录
    public function doLogin()
    {

        if (request()->isPost()) {
            $param = input('post.');
            $shop = new Shop();
            $shopInfo = $shop->getShopInfo(['phone' => $param['phone']]);

            if (!$shopInfo) {
                return reMsg(-2, '', '手机号错误');
            }

            if (!checkPassword($param['password'], $shopInfo['password'])) {
                return reMsg(-3, '', '密码错误');
            }
            // cache
            session('shop_info', json_encode($shopInfo));

//            Cache::set('shop_info', json_encode($shopInfo), 3600);
            return reMsg(0, url('index/order/index'), '登录成功');
        }
    }

    //注册
    public function register()
    {
        if (request()->post()) {
            $shop = new Shop();

            $data['shop_name'] = input('param.shop_name');
            $data['site'] = input('param.site');
            $data['shop_user'] = input('param.shop_user');
            $data['phone'] = input('param.phone');
            $data['purifier'] = input('param.purifier');
            $param = input('post.');
            $check_phone = $shop->getShopInfo(['phone' => $data['phone']]);
            $shop_name = $shop->getShopInfo(['shop_name' => $data['shop_name']]);
            if ($check_phone || $shop_name) {
                return reMsg(-2, '', '该手机号或商户已经注册');
            }
            $validate = new LoginValidate();
            if (!$validate->scene('edit')->check($param)) {
                return reMsg(-2, '', $validate->getError());
            }
            if (input('param.check_password') != input('param.password')) {
                return reMsg(-2, '', '两次输入密码不一致');
            }
            $data['password'] = makePassword(input('param.password'));
            $data['token'] = getRoundToken();
            $res = $shop->registerShop($data);
            if ($res) {
                return reMsg(0, url('index/login/login'), '注册成功');
            }
            return reMsg(-2, '', '注册失败');
        }
        return $this->fetch();
    }
}
