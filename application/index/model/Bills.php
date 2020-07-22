<?php
/**
 * Created by PhpStorm.
 * User: NickBai
 * Email: 876337011@qq.com
 * Date: 2019/3/17
 * Time: 4:48 PM
 */
namespace app\index\model;

use think\Model;
use think\Db;

class Bills extends Model
{
    protected $table = 'bsa_bills';

    /*
     * 订单
     * @param $where
     * @param $limit
     * @return array
     */
    public function getOrder($where, $limit = 20)
    {
        return $this->where($where)
            ->order('bills_id', 'desc')->paginate($limit)->toArray();
    }

    public function getInfo($shop_id)
    {
        $where['bills_id'] = $shop_id;
//        $where['bill_tittle'] = $shop_name;
        return $this->where($where)
            ->field('bsa_bills.*,worker.name,worker.phone as w_phone')
            ->leftJoin('worker', 'worker.id = bsa_bills.user_id')
            ->findOrEmpty()->toArray();
    }
}