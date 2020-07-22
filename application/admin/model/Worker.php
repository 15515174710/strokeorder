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

class Worker extends Model
{
    protected $table = 'bsa_worker';

    /**
     * 获取类型
     * @param $status
     * @return array
     */
    public function getWorkerList()
    {
        $where['status'] = 1;
        return $this->where($where)->select()->toArray();
    }


}