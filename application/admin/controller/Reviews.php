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
use app\admin\model\Shop;
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
        if (request()->isAjax()) {
            $limit = input('param.limit');
            $where = [];
            $bills = new Shop();
            $list = $bills->getList($limit, $where);

            if (0 == $list['code']) {
                return json(['code' => 0, 'msg' => 'ok', 'count' => $list['data']->total(), 'data' => $list['data']->all()]);
            }
            return json(['code' => 0, 'msg' => 'ok', 'count' => 0, 'data' => $list['data']]);
        }
        return $this->fetch();
    }




}
