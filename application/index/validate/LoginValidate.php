<?php

namespace app\index\validate;

use think\Validate;

class LoginValidate extends Validate
{
    protected $rule = [
        'shop_name' => 'require',
        'site' => 'require',
        'shop_user' => 'require',
        'phone' => 'require|max:11|/^1[3-8]{1}[0-9]{9}$/',
        'password' => 'require',
        'check_password' => 'require',
    ];

    protected $message = [
        'shop_name.require' => '饭店名称不能为空',
        'site.require' => '地址不能为空',
        'shop_user.require' => '请填写联系人名称',
        'phone' => '请输入11位正确手机号码',
        'password.require' => '密码不能为空',
        'check_password.require' => '请重复输入密码',
    ];

    protected $scene = [
        'edit' => ['shop_name', 'site', 'shop_user', 'phone', 'password']
    ];
}