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

class Type extends Model
{
    protected $table = 'bsa_type';
    protected $worker_table = 'bsa_worker';

    /**
     * 获取类型
     * @param $status
     * @param $ids
     * @return array
     */
    public function getTypeList($ids = '1,2,3,4', $status = 1)
    {
        $where['status'] = $status;
        return $this->where($where)->whereIn('id', $ids)->order('price','asc')->select()->toArray();
    }

    public function getWorkerList()
    {

        
    }


}