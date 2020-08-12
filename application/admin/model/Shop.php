<?php
/**
 * Created by PhpStorm.
 * User: NickBai
 * Email: 876337011@qq.com
 * Date: 2019/3/17
 * Time: 4:48 PM
 */
namespace app\admin\model;

use think\Model;
use think\facade\Cache;
use think\facade\Log;
use think\Db;

class Shop extends Model
{
    protected $table = 'bsa_shop';

    /*
     * 获取类型
     * @param $status
     * @param $ids
     * @return array
     */
    public function getShopInfo($where)
    {
        return $this->where($where)->find();
    }

    /*
     * 注册商铺
     * @param $data
     * @return array
     */
    public function registerShop($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s', time());
        return $this->insert($data);
    }


    public function getShopList($where)
    {
        return $this->where($where)->select()->toArray();

    }

    public function getList($limit, $where)
    {
        $prefix = config('database.prefix');

        try {

            $res = $this->field($prefix . 'bills.*')->where($where)->order('bills_id', 'desc')->paginate($limit);

        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, $res, 'ok');
    }

}