<?php

namespace app\admin\controller;
use app\admin\model\Admin;
use app\admin\model\Bills;
use think\App;
use tool\Auth;
use think\Cache;
use think\Db;

class Feizhu extends Base
{
    private $AppKey;
    private $AppSecret;
    private $code;
    private $AccessToken;
    private $redirect_uri;

    public function __construct()
    {
        $this->AppKey = '27983703';
    	$this->AppSecret = '116a58acc6aa86093919bab4103e43ba';
    	// $this->redirect_uri = 'http://192.168.1.110:8089/admin/feizhu/index';//视情况同时更改控制台设置
        $this->redirect_uri = 'http://119.23.49.188:8080/admin/feizhu/index';
    	$Cache = new Cache(['type'=>'file']);
    	$this->AccessToken = $Cache->get('AccessToken');
    	if(empty($this->AccessToken)){
    		if(empty($_GET['code'])){
    			$code_url = 'https://oauth.taobao.com/authorize?response_type=code&client_id='.$this->AppKey;
	    		$code_url = $code_url.'&redirect_uri='.$this->redirect_uri.'&state=1212&view=web';
				$content= file_get_contents($code_url); 
				if($content){
					print_r($content);
					exit();
				}
    		}else{
    			$this->code = $_GET['code'];
                $accesstoken = $this->get_accesstoken();
                $accesstoken = json_decode($accesstoken,true);
                $expires_in = $accesstoken['expires_in'];
                $this->AccessToken = $accesstoken['access_token'];
                $Cache->set('AccessToken',$this->AccessToken,$expires_in);
                return $this->fetch('index');
    		}
    	}
        parent::__construct();
    }
    
    public function index(){
        // $this->sendEmail();
        return $this->fetch();
    }

    /*
    获取订单列表
    */
    public function getorderlist(){
        $status = input('param.status');
        $begin = input('param.begin') ? input('param.begin'):'2000-01-01';
        $end_time = input('param.end_time') ? input('param.end_time'):date('Y-m-d',time());
        $page = input('param.page') ? input('param.page') : 0;
        $size = input('param.size') ? input('param.size') : 20;
        $request['status'] = $status;
        $request['begin'] = $begin;
        $request['end_time'] = $end_time;
        $request['page'] = $page;
        $request['size'] = $size;

        $resp = $this->getorder($request);
        
        $jsonStr = json_encode($resp);
        $jsonArray = json_decode($jsonStr,true);
        $count = $jsonArray['total_results'];
        $list = $jsonArray['trades']['trade'];
        foreach($list as $key => $val){
            $list[$key]['goods_name'] = $val['orders']['order']['title'];
            if($val['status'] == 'WAIT_BUYER_PAY'){
                $list[$key]['status'] = '等待买家付款';
            }elseif($val['status'] == 'WAIT_SELLER_SEND_GOODS'){
                $list[$key]['status'] = '等待卖家发货';
            }elseif($val['status'] == 'SELLER_CONSIGNED_PART'){
                $list[$key]['status'] = '卖家部分发货';
            }elseif($val['status'] == 'WAIT_BUYER_CONFIRM_GOODS'){
                $list[$key]['status'] = '等待买家确认收货';
            }elseif($val['status'] == 'TRADE_BUYER_SIGNED'){
                $list[$key]['status'] = '买家已签收';
            }elseif($val['status'] == 'TRADE_FINISHED'){
                $list[$key]['status'] = '交易成功';
            }elseif($val['status'] == 'TRADE_CLOSED'){
                $list[$key]['status'] = '交易关闭';
            }elseif($val['status'] == 'TRADE_CLOSED_BY_TAOBAO'){
                $list[$key]['status'] = '交易被淘宝关闭';
            }elseif($val['status'] == 'TRADE_NO_CREATE_PAY'){
                $list[$key]['status'] = '没有创建外部交易';
            }elseif($val['status'] == 'WAIT_PRE_AUTH_CONFIRM'){
                $list[$key]['status'] = '余额宝0元购合约中';
            }elseif($val['status'] == 'PAY_PENDING'){
                $list[$key]['status'] = '外卡支付付款确认中';
            }elseif($val['status'] == 'PAID_FORBID_CONSIGN'){
                $list[$key]['status'] = '该状态代表订单已付款但是处于禁止发货状态';
            }
        }

        return json(['code' => 0, 'msg' => 'ok', 'count' =>$count, 'data' => $list]);
    }

    private function getorder($data){
        $begin = $data['begin'];
        $end_time = $data['end_time'];
        $status = $data['status'] ? $data['status'] : '';
        $page = $data['page'] ? $data['page'] :'';
        $size = $data['size'] ? $data['size'] :'';
        $c = new \feizhu\top\TopClient;
        $c->appkey = $this->AppKey;
        $c->secretKey = $this->AppSecret;
        $req = new \feizhu\top\request\TradesSoldGetRequest;
        $req->setFields("tid,title,price,discount_fee,num,created,status,payment,pay_time,buyer_nick,orders");
        $req->setStartCreated($begin.' 00:00:00');
        $req->setEndCreated($end_time.' 23:59:59');
        if(!empty($status)){
            $req->setStatus($status);    
        }
        $req->setPageNo($page);
        $req->setPageSize($size);
        $resp = $c->execute($req,$this->AccessToken);
        return $resp;
    }



    /*
    获取订单详情
    */
    public function orderDetails()
    {
        $data['order_id'] = $_GET['tid'];
        $field = '
            tid,
            payment,
            post_fee,
            receiver_name,
            receiver_state,
            receiver_address,
            receiver_zip,
            receiver_mobile,
            receiver_phone,
            consign_time,
            received_payment,
            promotion_details,
            est_con_time,
            order_tax_fee,
            paid_coupon_fee,
            new_presell,
            you_xiang,
            pay_channel,
            num,
            num_iid,
            status,
            title,
            type,
            price,
            discount_fee,
            has_post_fee,
            total_fee,
            created,
            pay_time,
            modified,
            end_time,
            buyer_message,
            buyer_memo,
            seller_memo,
            buyer_nick,
            credit_card_fee,
            step_trade_status,
            step_paid_fee,
            mark_desc,
            shipping_type,
            buyer_cod_fee,
            adjust_fee,
            service_orders,
            buyer_rate,
            service_tags,
            orders,
            coupon_fee,
            o2o_et_order_id,
            post_gate_declare,
            cross_bonded_declare,
            assembly,
            delivery_time,
            collect_time,
            dispatch_time,
            sign_time';
        $resp = $this->getdetail($data['order_id'],$field);
        $jsonStr = json_encode($resp);
        $jsonArray = json_decode($jsonStr,true);
        if($jsonArray['trade']['status'] == 'WAIT_BUYER_PAY'){
             $jsonArray['trade']['status'] = '等待买家付款';
        }elseif($jsonArray['trade']['status'] == 'WAIT_SELLER_SEND_GOODS'){
            $jsonArray['trade']['status'] = '等待卖家发货';
        }elseif($jsonArray['trade']['status'] == 'SELLER_CONSIGNED_PART'){
            $jsonArray['trade']['status'] = '卖家部分发货';
        }elseif($jsonArray['trade']['status'] == 'WAIT_BUYER_CONFIRM_GOODS'){
            $jsonArray['trade']['status'] = '等待买家确认收货';
        }elseif($jsonArray['trade']['status'] == 'TRADE_BUYER_SIGNED'){
            $jsonArray['trade']['status'] = '买家已签收';
        }elseif($jsonArray['trade']['status'] == 'TRADE_FINISHED'){
            $jsonArray['trade']['status'] = '交易成功';
        }elseif($jsonArray['trade']['status'] == 'TRADE_CLOSED'){
            $jsonArray['trade']['status'] = '交易关闭';
        }elseif($jsonArray['trade']['status'] == 'TRADE_CLOSED_BY_TAOBAO'){
            $jsonArray['trade']['status'] = '交易被淘宝关闭';
        }elseif($jsonArray['trade']['status'] == 'TRADE_NO_CREATE_PAY'){
            $jsonArray['trade']['status'] = '没有创建外部交易';
        }elseif($jsonArray['trade']['status'] == 'WAIT_PRE_AUTH_CONFIRM'){
            $jsonArray['trade']['status'] = '余额宝0元购合约中';
        }elseif($jsonArray['trade']['status'] == 'PAY_PENDING'){
            $jsonArray['trade']['status'] = '外卡支付付款确认中';
        }elseif($jsonArray['trade']['status'] == 'PAID_FORBID_CONSIGN'){
            $jsonArray['trade']['status'] = '该状态代表订单已付款但是处于禁止发货状态';
        }
        $outinfo = $this->get_cusinfo($jsonArray['trade']['buyer_message']);
        $response = $jsonArray['trade'];
        $response['customer_info'] = $outinfo;
        $this->assign('data', $response);
        return $this->fetch();
    }

    private function getdetail($order_id,$field){
        $c = new \feizhu\top\TopClient;
        $c->appkey = $this->AppKey;
        $c->secretKey = $this->AppSecret;
        $req = new \feizhu\top\request\TradeFullinfoGetRequest;
        $req->setFields($field);
        $req->setTid($order_id);
        $resp = $c->execute($req,$this->AccessToken);
        return $resp;
    }



    /*
    获取用户信息
    */
    private function get_cusinfo($outinfo){
        $strsta = strrpos($outinfo,'姓名');
        $strout = substr($outinfo, $strsta);
        $strout = str_replace('姓名', '', $strout);
        $strout = str_replace('电话', '', $strout);
        $strout = str_replace('邮箱', '', $strout);
        $strout = str_replace('出行日期', '', $strout);
        $strout = trim($strout);
        $outinfo = explode(':', $strout);
        @$res['name'] = $outinfo[1];
        @$res['phone'] = $outinfo[2];
        @$res['email'] = $outinfo[3];
        @$res['begin_date'] = $outinfo[4];
        return $res;
    }
    /*
    获取通讯密匙
    */
    private function get_accesstoken(){
         $url = 'https://oauth.taobao.com/token';
         $postfields= array('grant_type'=>'authorization_code',
         'client_id'=>$this->AppKey,
         'client_secret'=>$this->AppSecret,
         'code'=>$this->code,
         'redirect_uri'=>$this->redirect_uri);
         $post_data = '';
         foreach($postfields as $key=>$value){
            $post_data .="$key=".urlencode($value)."&";
         }
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
         curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, substr($post_data,0,-1));
         $output = curl_exec($ch);
         $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
         echo $httpStatusCode;
         curl_close($ch);
         return $output;
    }


    /* 修改订单状态 */
    private function editOrder($order_id){
        $order_id = '577642022447085991';
        $c = new \feizhu\top\TopClient;
        $c->appkey = $this->AppKey;
        $c->secretKey = $this->AppSecret;
        $req = new  \feizhu\top\request\LogisticsDummySendRequest;
        $req->setTid($order_id);
        $resp = $c->execute($req,$this->AccessToken);
        $jsonStr = json_encode($resp);
        $jsonArray = json_decode($jsonStr,true);
        if($jsonArray['shipping']['is_success'] == true){
            return 'success';
        }else{
            return 'fail';
        }
    }

    /*
    发送邮件修改订单
    */
    private function sendEmail(){
        echo '<pre>';
        /*获取需要操作的订单ID信息*/
        $order = $this->getorder(['status'=>'WAIT_SELLER_SEND_GOODS','begin'=>'2000-01-01','end_time'=>date('Y-m-d',time()),'page'=>1,'size'=>20]);
        $jsonStr = json_encode($order);
        $jsonArray = json_decode($jsonStr,true);
        

        $totalPageNum = ceil($jsonArray['total_results']/100);
        $order_list = [];
        foreach ($jsonArray['trades']['trade'] as $key => $value) {
            $order_list[$key]['order_id'] = $value['tid'];
            $order_list[$key]['order_num'] = $value['num'];
            $order_list[$key]['title'] = $value['orders']['order']['title'];
        }

        if($totalPageNum > 1){
            for ($i=2; $i < $totalPageNum+1; $i++) { 
                $order = $this->getorder(['status'=>'WAIT_SELLER_SEND_GOODS','begin'=>'2000-01-01','end_time'=>date('Y-m-d',time()),'page'=>$i,'size'=>100]);
                $jsonStr = json_encode($order);
                $jsonArray = json_decode($jsonStr,true);
                foreach ($jsonArray['trades']['trade'] as $key => $value) {
                    $k = ($i-1)*100+$key;
                    $order_list[$k]['order_id'] = $value['tid'];
                    $order_list[$k]['order_num'] = $value['num'];
                    $order_list[$k]['title'] = $value['orders']['order']['title'];
                }
            }
        }


        /*匹配票据信息*/
        foreach ($order_list as $k => $v) {
            $detail = $this->getdetail($v['order_id'],'buyer_message');
            $jsonStr = json_encode($detail);
            $jsonArray = json_decode($jsonStr,true);

            $outinfo = $this->get_cusinfo($jsonArray['trade']['buyer_message']);
            if(empty($outinfo['name']) || empty($outinfo['phone'])||empty($outinfo['email'])||empty($outinfo['begin_date'])){
                continue;
            }

            $bwhere = ['title'=>$v['title'],'go_time'=>$outinfo['begin_date'].' 23:59:59','num'=>$v['order_num']];
            // exit;
            $bills = $this->get_billes($bwhere,$v['order_num']);
            if($bills && $bills != 'nopass'){
                //发送邮件信息
                // $sendE = $this->sendMyEmail($outinfo,$bills,$v);
                $sendE = 1;
                if($sendE == false){
                    continue;
                }else{
                    /*更改票据状态*/
                    $res = $this->editBills($bills);
                    if($res == 'fail'){
                        continue;
                    }
                    /*更改订单状态*/
                    $res = $this->editOrder($v['order_id']);
                }
            }else{
                continue;
            }

        }
        
    }

    /* 匹配票据 */
    public function get_billes($data,$num){
        $bills = new Bills();
        $where[] = ['bill_tittle','=',$data['title']];
        $where[] = ['status','=',1];
        $where[] = ['is_deleted','=',0];
        $where[] = ['end_time','>',$data['go_time']];
        $bills_list = $bills->getBillst($where);
        if($bills_list['code'] == 0 && $bills_list['msg'] == 'ok'){
            $data = $bills_list['data'];
            if(count($data) < $num){
                return 'nopass1';
            }else{
                for ($i=0; $i < $num; $i++) { 
                    $res[$i] = $data[$i];
                }
            }
        }else{
            return 'nopass2';
        }
        return $res;

    }

    /* 更新票据*/
    public function editBills($Bills){
        foreach ($Bills as $key => $value) {
            $Bills[$key]['status']=2;
        }
        Db::startTrans();
        foreach ($Bills as $key => $value) {
            $bills = new Bills();
            $res = $bills->editBills($value);
            if($res['code'] !=0){
                Db::rollback();
                return 'fail';
            }
        }
        Db::commit();
        return 'success';
    }

    
    

    /* 编辑邮件内容发送邮件 */
    public function sendMyEmail($cusInfo,$billsInfo,$orderInfo){
        echo '<pre>';
        $message = "
            {$cusInfo['name']} 你好,
            
                    你预订的 {$orderInfo['order_id']} 订单已经确认。
                    
                    Your reservation about {$orderInfo['order_id']} is confirmed.
                    
                    商品名称：{$orderInfo['title']}
                    
                    出行时间：{$cusInfo['begin_date']}
    
                    数量：{$orderInfo['order_num']}

                    以下您的票据信息：";
                    
                    foreach ($billsInfo as $key => $value) {
                        $message .= '

                        标题：'.$value['bill_tittle'].'

                        票据详情：'.$value['bill_url'].'

                        有效截止日期为：'.$value['end_time'].'

                                        ';
                    }
        return true;
        echo $message;exit();
        $res = SendMail($cusInfo['email'],$orderInfo['title'],$message);
        
    }



}
