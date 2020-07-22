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
class Reviews extends Base
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

    public function mafengwo()
    {
        return $this->fetch();
    }
    public function mafengwo_list()
    {
        $action = 'sales.order.comment.list.get';
        $data['page_no'] = input('param.page');
//        $data['page_no'] = '1';
        $this->apiobj->send($action, $data);
        $data = $this->apiobj->getData();
        if(empty($data['total'])) {
            return json(['code' => 0, 'msg' => 'ok', 'count' => 0, 'data' => []]);
        }
        $count = $data['total'];
        foreach ($data['list'] as $key => $value){
            if ($value['star'] == 1 || $value['star'] == 2 ) {
                $star = '差评';
            }elseif ($value['star'] == 3){
                $star = '中评';
            }else{
                $star = '好评';
            }
            $star_tags = implode(",", array_column($value['star_tags'], 'name'));
            $response[] = [
                'username' => $value['username'],
                'sales_name' => $value['sales_name'],
                'star' => $star,
                'star_tags' => $star_tags,
                'content' => $value['content'],
                'reply' => $value['reply'],
            ];
        }
        return json(['code' => 0, 'msg' => 'ok', 'count' => $count, 'data' => $response]);
    }

}
