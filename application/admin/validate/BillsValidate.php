<?php

namespace app\admin\validate;

use think\Validate;

class BillsValidate extends Validate
{
    protected $rule = [
        'bill_tittle' => 'require',
//        'bill_url'   => 'require',
        'end_time' => 'require',
        'status' => 'require',
        'type' => 'require',
    ];

    protected $message = [
        'bill_tittle.require' => '饭店名称不能为空',
//        'bill_url.require'   => '票据图片不能为空',
        'end_time.require' => '清洗日期不能为空',
        'status.require' => '清洗状态不能为空',
        'type.require' => '服务类型不能为空'
    ];

    protected $scene = [
        'edit' => ['bill_tittle', 'bill_url', 'end_time', 'status', 'type']
    ];
}