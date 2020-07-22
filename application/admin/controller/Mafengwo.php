<?php
/**
 * Created by PhpStorm.
 * User: NickBai
 * Email: 876337011@qq.com
 * Date: 2019/2/17
 * Time: 11:33 AM
 */

namespace app\admin\controller;
use app\admin\model\Admin;
use think\App;
use tool\Auth;
use mafengwo\MSDK_Php_Openapi;
class Mafengwo extends Base
{
    private $apiobj;
    public function __construct(MSDK_Php_Openapi $openapi)
    {
        $this->apiobj = $openapi;
        parent::__construct();
    }
    public function index()
    {
        return $this->fetch();
    }

    public function getOrders()
    {
        $action = 'sales.order.list.get';
        $data = [];
        $data['page_no'] = input('param.page');
        $data['page_size'] = input('param.limit');
        if (!empty($_GET['tid'])){
            $data['params']['order_status'] = $_GET['tid'];
        }
        $this->apiobj->send($action, $data);
        $data = $this->apiobj->getData();
        if(empty($data['total'])) {
            return json(['code' => 0, 'msg' => 'ok', 'count' => 0, 'data' => []]);
        }
        $count = $data['total'];
        foreach ($data['list'] as $datum){
            switch ($datum['status']['orderStatus']) {
                case 1:
                    $status = "待支付";
                    break;
                case 2:
                    $status = "待出单";
                    break;
                case 4:
                    $status = "已出单";
                    break;
                case 5:
                    $status = "已完成";
                    break;
                case 6:
                    $status = "已关闭";
                    break;
            }
            $ordata[] = [
                'orderId' => $datum['orderId'],
                'orderStatus' => $status,
                'goDate' => $datum['goDate'],
                'name' => $datum['bookingPeople']['name'],
                'phone' => $datum['bookingPeople']['phone'],
                'wechat' => $datum['bookingPeople']['wechat'],
                'salesName' => $datum['salesName'],
                'skuName' => $datum['skuName'],
                'totalPrice' => $datum['totalPrice'],
                'paymentFee' => $datum['paymentFee']
            ];
        }
        return json(['code' => 0, 'msg' => 'ok', 'count' => $count, 'data' => $ordata]);
    }
    public function orderDetails()
    {
        $action = 'sales.order.detail.get';
        $data['order_id'] = $_GET['oid'];
        $this->apiobj->send($action, $data);
        $data = $this->apiobj->getData();
        if (empty($data)){
            $this->assign('data', $data);
            return $this->fetch();
        }
        $response = [
            'orderId' => $data['orderId'],
            'orderStatus' => $this->swichStates($data['status']['orderStatus'],'1'),
            'allRefundFlag' => $this->swichStates($data['status']['allRefundFlag'],'2'),
            'refundStatus' => $this->swichStates($data['status']['refundStatus'],'3'),
            'paytime' => $data['paytime'],
            'ctime' => $data['ctime'],
            'name' => $data['bookingPeople']['name'],
            'email' => $data['bookingPeople']['email'],
            'phone' => $data['bookingPeople']['phone'],
            'remark' => $data['bookingPeople']['remark'],
            'uid' => $data['bookingPeople']['uid'],
            'salesId' => $data['salesId'],
            'salesName' => $data['salesName'],
            'otaSalesName' => $data['otaSalesName'],
            'skuId' => $data['skuId'],
            'otaSkuId' => $data['otaSkuId'],
            'skuName' => $data['skuName'],
            'stockName' => $data['skus'][0]['stockName'],
            'totalPrice' => $data['totalPrice'],
            'paymentFee' => $data['paymentFee'],
            'remain_payment_fee' => $data['items'][0]['remain_payment_fee'],
            'remain_num' => $data['items'][0]['remain_num'],
            'total_price' => $data['items'][0]['total_price'],
            'payment_fee' => $data['items'][0]['payment_fee'],
            'price' => $data['items'][0]['price'],
            'num' => $data['items'][0]['num'],
            'id' => $data['items'][0]['id'],
            'reduce_mfw' => $data['promotionDetail']['reduce_mfw'],
            'reduce_ota' => $data['promotionDetail']['reduce_ota'],

        ];
        $this->assign('data', $response);
        return $this->fetch();
    }
    public function updateOrderState()
    {
        $data['order_id'] = input('param.order_id');
//        $data['order_id'] = '306255201712015311112';
        $data['status'] = input('param.status');
        $data['add_status'] = input('param.ostatus');
        $action = 'sales.order.status.update';
        $this->apiobj->send($action, $data);
        $data = $this->apiobj->getData();
        if (empty($data['order_id'])){
            return json(['code' => 0]);
        }
        return json(['code' => 1]);
    }
    public function updateRemarks()
    {
        $data['order_id'] = input('param.order_id');
//        $data['order_id'] = '306255201712015311112';
        $data['memo'] = input('param.memo');
        $action = 'sales.order.memo.add';
        $this->apiobj->send($action, $data);
        $data = $this->apiobj->getData();
        if (empty($data['order_id'])){
            return json(['code' => 0]);
        }
        return json(['code' => 1]);
    }
    public function getTraveler()
    {
        $action = 'sales.order.traveler.get';
        $data['order_id'] = $_GET['oid'];
        $this->apiobj->send($action, $data);
        $data = $this->apiobj->getData();
        $response = $data['travel_people']['traveler'];
        $this->assign('order_id', $_GET['oid']);
        $this->assign('data', $response);
        return $this->fetch();
    }
    public function updateTraveler()
    {
        $response = '';
        $this->assign('data', $response);
    }
    public function getRemarks()
    {
        $action = 'sales.order.memo.get';
        $data['order_id'] = $_GET['oid'];
        $this->apiobj->send($action, $data);
        $response = $this->apiobj->getData();
        $this->assign('order_id', $data['order_id']);
        $this->assign('data', $response);
        return $this->fetch();
    }
    public function getColor()
    {
        $order_id = $_GET['oid'];
        $this->assign('order_id', $order_id);
        return $this->fetch();
    }
    public function restColor()
    {
        $action = 'sales.order.color.add';
        $data['order_id'] = input('param.order_id');
        $data['color'] = input('param.color');
        $this->apiobj->send($action, $data);
        $data = $this->apiobj->getData();
        if (empty($data['order_id'])){
            return json(['code' => 0]);
        }
        return json(['code' => 1]);
    }
    public function swichStates($data,$type)
    {
        if ($type == '1'){
            switch ($data) {
                case 1:
                    $status = "待支付";
                    break;
                case 2:
                    $status = "待出单";
                    break;
                case 4:
                    $status = "已出单";
                    break;
                case 5:
                    $status = "已完成";
                    break;
                case 6:
                    $status = "已关闭";
                    break;
            }
        }elseif ($type == '2'){
            switch ($data) {
                case 0:
                    $status = "无退款";
                    break;
                case 1:
                    $status = "未全部退款";
                    break;
                case 2:
                    $status = "已全部退款";
                    break;
            }
        }else{
            switch ($data) {
                case 0:
                    $status = "可发起退款";
                    break;
                case 1:
                    $status = "已完成退款";
                    break;
                case 2:
                    $status = "已申请退款";
                    break;
                case 3:
                    $status = "拒绝退款";
                    break;
                case 4:
                    $status = "已确认退款";
                    break;
            }
        }
        return $status;
    }
    public function searchOrder()
    {
        return $this->fetch();
    }



}
