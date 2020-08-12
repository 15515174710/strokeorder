<?php
namespace app\admin\controller;

use app\admin\model\Bills;
use app\admin\model\Shop;
use app\admin\model\Type;
use app\admin\model\Worker;
use app\admin\validate\BillsValidate;
use tool\Log;
use \think\File;

class Billes extends Base
{
    public function index()
    {
        if (request()->isAjax()) {
            $limit = input('param.limit');
            $bill_tittle = input('param.bill_tittle');
            $type = input('param.type');
            $order_num = input('param.order_num');
            $status = input('param.status');
            $get_type = new Type();
            $where = [];
            if (!empty($bill_tittle)) {
                $where[] = ['bill_tittle', 'like', $bill_tittle . '%'];
            }
            if (!empty($type)) {
                $where[] = ['', '=', $type];
            }
            if (!empty($order_num)) {
                $where[] = ['order_num', '=', $order_num];
            }
            if ($status != '') {
                $where[] = ['status', '=', $status];
            }

            $bills = new Bills();
            $list = $bills->getBills($limit, $where);
            foreach ($list['data'] as &$v) {
                $type_list = $get_type->getTypeList($v['type']);
                $v['type_arr'] = implode(',', array_column($type_list, 'name'));
            }
            if (0 == $list['code']) {
                return json(['code' => 0, 'msg' => 'ok', 'count' => $list['data']->total(), 'data' => $list['data']->all()]);
            }
            return json(['code' => 0, 'msg' => 'ok', 'count' => 0, 'data' => $list['data']]);
        }
        return $this->fetch();
    }

    // 添加管理员
    public function addBills()
    {

        if (request()->isPost()) {

            $param = input('post.');
            $param['status'] = 1;

            unset($param['file']);
            $validate = new BillsValidate();
            if (!$validate->scene('edit')->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }
            $param['add_time'] = date('Y-m-d H:i:s');
            $param['type'] = implode(',', $param['type']);
            $param['order_num'] = create_recharge_order_sn();
            $param['bill_url'] = '/uploads/' . $param['bill_url'];
            $validate = new BillsValidate();
            if (!$validate->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }

            $bills = new bills();
            $res = $bills->addBills($param);
            Log::write(json_encode($param), "新增订单");


            return json($res);
        }

        $this->assign([
            'roles' => (new \app\admin\model\Role())->getAllRoles()['data']
        ]);

        $worker = new Worker();
        $worker_list = $worker->getWorkerList();
        $this->assign('worker_list', $worker_list);
        $shop = new Shop();
        $shop_list = $shop->getShopList([]);
        $this->assign('shop_list', $shop_list);

        return $this->fetch('add');
    }

    // 编辑管理员
    public function editBills()
    {

        if (request()->isPost()) {

            $param = input('post.');
            $validate = new BillsValidate();
            if (!$validate->scene('edit')->check($param)) {
                return ['code' => -1, 'data' => '', 'msg' => $validate->getError()];
            }
            $bills = new bills();
            $param['type'] = implode(',', $param['type']);
            if ($param['bill_url']) {
                $param['bill_url'] = '/uploads/' . $param['bill_url'];
                $param['bill_url'] = $param['bill_old_url'] . '|' . $param['bill_url'];
            } else {
                $param['bill_url'] = $param['bill_old_url'];
            }
            $param['add_time'] = date('Y-m-d H:i:s');
            $res = $bills->editBills($param);
            Log::write(json_encode($param), "编辑订单");
            return json($res);
        }

        $bills_id = input('bills_id');

        $billsModel = new Bills();

        $bills = $billsModel->getBillsById($bills_id);

        $bills = $bills['data'];

        $bills['type'] = explode(',', $bills['type']);
        $bills['bill_old_url'] = $bills['bill_url'];
        $bills['bill_url'] = '';
        $this->assign('data', $bills);
        $worker = new Worker();
        $worker_list = $worker->getWorkerList();
        $this->assign('worker_list', $worker_list);
        $shop = new Shop();
        $shop_list = $shop->getShopList([]);
        $this->assign('shop_list', $shop_list);
        return $this->fetch();
    }

    public function detailBills()
    {
        $bills_id = input('bills_id');
        $billsModel = new Bills();

        $bills = $billsModel->getBillsById($bills_id);

        $bills = $bills['data'];

        switch ($bills['status']) {
            case '1':
                $bills['status'] = '待接单';
                break;
            case '2':
                $bills['status'] = '进行中';
                break;
            case '3':
                $bills['status'] = '待评价';
                break;
        }
        $get_type = new Type();
        $type_list = $get_type->getTypeList($bills['type']);
        $bills['type_arr'] = implode(',', array_column($type_list, 'name'));
        $bills['bill_url'] = explode('|', $bills['bill_url']);
        foreach ($bills['bill_url'] as &$v) {
            $v = 'http://' . $_SERVER['HTTP_HOST'] . $v;
        }
        $this->assign('bill_url', $bills['bill_url']);

        $this->assign('data', $bills);
        return $this->fetch();
    }

    /**
     * 删除票据
     * @return \think\response\Json
     */
    public function delBills()
    {

        if (request()->isAjax()) {
            $bills_id = input('bills_id');
            $bills = new bills();
            $res = $bills->delBills($bills_id);

            Log::write($bills_id, "删除订单");

            return json($res);
        }
    }


    public function upload()
    {
        $file = request()->file('file');
        $info = $file->move('../public/uploads');
        if ($info) {
            return json(['code' => 0, 'msg' => 'ok', 'count' => 0, 'data' => $info->getSaveName()]);
        } else {
            return json(['code' => 0, 'msg' => 'ok', 'count' => 0, 'data' => $file->getError()]);
        }
    }


    public function getType()
    {
        $type = new Type();
        $list = $type->getTypeList();
        return json(['code' => 0, 'msg' => 'ok', 'count' => 0, 'data' => $list['data']]);
    }

    public function getShopInfo()
    {
        $param = input('get.');
        $shop = new Shop();
        $shop_info = $shop->getShopInfo($param);
        if (!$shop_info) {
            return reMsg(-2, '', '注册失败');
        }
        return reMsg(0, $shop_info, '成功');

    }

}