<?php
namespace app\index\controller;

use app\admin\model\Type;
use think\Controller;
use think\facade\Cache;
use app\index\model\Bills;

class Order extends Controller
{

    //查看订单
    public function index()
    {
        $status_arr = ['待接单', '进行中', '待评价', '已评价'];
        $order = new Bills();
        $get_type = new Type();
        $shop_info = Cache::get('shop_info');
        $param = input('get.');
        $status = $param['status'] ?? 10;
        $where = [];
        $limit = $param['limit'] ?? 20;
        if ($status != 10) {
            $where['status'] = $status;
        }
        if ($shop_info) {
            //登录账号
            $shop_info = json_decode($shop_info, true);
            $where['shop_id'] = $shop_info['id'];
        }
        $list = $order->getOrder($where, $limit);
        if (empty($list)) {
            return reMsg(-3, '', '暂无订单');
        }
        foreach ($list['data'] as &$v) {
            $v['type_arr'] = $get_type->getTypeList($v['type']);
            $v['price'] = array_sum(array_column($v['type_arr'], 'price'));
        }

        $this->assign('data', $list['data']);
        $this->assign('status_arr', $status_arr);
        $this->assign('status', $status);
        return $this->fetch();
    }


    public function info()
    {
        $param = input('get.');
        $order = new Bills();
        $get_type = new Type();
        $shop_id = $param['shop_id'];
        $info = $order->getInfo($shop_id);

        $info['type_arr'] = $get_type->getTypeList($info['type']);
        $info['price'] = array_sum(array_column($info['type_arr'], 'price'));
        $status_arr = ['待接单', '进行中', '待评价', '已评价'];
        $this->assign('status_arr', $status_arr);
        $this->assign('data', $info);
        return $this->fetch();
    }
}
