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
        $data['created_at'] = date('Y-m-d H:i:s',time());
        return $this->insert($data);
    }
}