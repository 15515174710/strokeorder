<?php
/**
 * Created by PhpStorm.
 * User: NickBai
 * Email: 876337011@qq.com
 * Date: 2019/2/17
 * Time: 11:33 AM
 */
namespace app\admin\controller;
use app\admin\controller\Feizhu;
use mafengwo\MSDK_Php_Openapi;
class sendmail
{
    private $apiobj;
    public function __construct(MSDK_Php_Openapi $openapi)
    {
        $this->apiobj = $openapi;
    }
    public function mafengwo()
    {
        $action = 'sales.order.list.get';
        $data = [];
//        $data['page_no'] = input('param.page');
        $data['page_no'] = 1;
        $data['params']['order_status'] = '4';
        $this->apiobj->send($action, $data);
        $data = $this->apiobj->getData();
        if(empty($data['total'])) {
            return json(['code' => 0, 'msg' => 'ok', 'count' => 0, 'data' => []]);
        }
        $order_data = [];
            for ($x=1; $x<=ceil($data['total']/20); $x++){
                $data['page_no'] = $x;
                $data['params']['order_status'] = '4';
                $this->apiobj->send($action, $data);
                $data = $this->apiobj->getData();
                foreach ($data['list'] as $datum){
                    $order_data[] = [
                        'orderId' => $datum['orderId'],
                        'name' => $datum['bookingPeople']['name'],
                        'email' => $datum['bookingPeople']['email'],
                        'salesName' => $datum['salesName'],
                        'goDate' => $datum['goDate'],
                        'skuName' => $datum['skuName'],
                        'num' => $datum['items'][0]['num'],
                        'price' => $datum['items'][0]['price']
                    ];
                }
            }
            $billobj = new Feizhu();
            $order_arr = [];
            foreach ($order_data as $v){

                $billobj->get_billes($v['salesName'],$v['num']);
            }

            $this->syncSend($order_data);
//        $i = 0;
//        foreach ($order_data as $v){
//            $i++;
//            $message = "
//            {$v['name']} 你好,
//
//                    你预订的 {$v['orderId']} 订单已经确认。
//
//                    Your reservation about {$v['orderId']} is confirmed.
//
//                    商品名称：{$v['salesName']}
//
//                    出行时间：{$v['goDate']}
//
//                    票种类型：{$v['skuName']}
//
//                    数量：{$v['num']}
//
//                    单价：￥{$v['price']} /份";
//
//            $res = SendMail($v['email'],$v['salesName'],$message);
//            echo $i;
//            var_dump($res);die;  2000 2000
//        }
    }
    /**
     * description:服务端
     */
    public function syncSend($order_data){
        $serv = new \swoole_server('0.0.0.0',8082);

        $serv->set(array('task_worker_num' => 4));

        $serv->on('receive', function($serv, $fd, $from_id, $data) {
            $task_id = $serv->task($data);
        });

        $serv->on('task', function ($serv, $task_id, $from_id, $data) use ($order_data) {
            foreach ($order_data as $i => $v){
                $message = "
              {$v['name']} 你好,

                    你预订的 {$v['orderId']} 订单已经确认。

                    Your reservation about {$v['orderId']} is confirmed.

                    商品名称：{$v['salesName']}

                    出行时间：{$v['goDate']}

                    票种类型：{$v['skuName']}

                    数量：{$v['num']}

                    单价：￥{$v['price']} /份";

                if(SendMail($v['email'],$v['salesName'],$message)){
                    echo 'send'.$i.' success'."\n";
                }else{
                    echo 'send'.$i.' fail'."\n";
                }
            }
            $serv->finish('');
        });

        $serv->on('finish', function ($serv, $task_id, $data) {
            echo "异步任务[id=$task_id]完成".PHP_EOL;
        });

        $serv->start();
    }
    /**
     * description:客户端
     */
    public function index()
    {
        $client = new \swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_SYNC);
        $ret = $client->connect("127.0.0.1", 8082);
        if(empty($ret)){
            echo 'error!connect to swoole_server failed';
        } else {
            $client->send('');//这里只是简单的实现了发送的内容
        }
    }
}
