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

class Bills extends Model
{
    protected $table = 'bsa_bills';

    /**
     * 获取票据
     * @param $limit
     * @param $where
     * @return array
     */
    public function getBills($limit, $where)
    {
        $prefix = config('database.prefix');

        try {

            $res = $this->field($prefix . 'bills.*')->where($where)->order('bills_id', 'desc')->paginate($limit);
            
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, $res, 'ok');
    }

    /**
     * 获取票据
     * @param $limit
     * @param $where
     * @return array
     */
    public function getBillst($where)
    {
        $prefix = config('database.prefix');
       
        try {

            $res = $this->field($prefix . 'bills.*')->where($where)->order('end_time', 'asc')->select()->toArray();

        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, $res, 'ok');
    }

    /**
     * 增加票据
     * @param $bills
     * @return array
     */
    public function addBills($bills)
    {
        try {
            $this->insert($bills);
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '添加票据成功');
    }

    /**
     * 获取票据详情
     * @param $bills_id
     * @return array
     */
    public function getBillsById($bills_id)
    {
        try {
            $info = $this->where('bills_id','=', $bills_id)->findOrEmpty()->toArray();
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, $info, 'ok');
    }

    /**
     * 编辑票据
     * @param $bills
     * @return array
     */
    public function editBills($bills)
    {
        try {
            $this->save($bills, ['bills_id'=>$bills['bills_id']]);
        }catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '编辑管票据成功');
    }

    /**
     * 删除票据
     * @param $bills_id
     * @return array
     */
    public function delBills($bills_id)
    {   

        try {
            $this->where('bills_id', '=',$bills_id)->delete();
        } catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, '', '删除成功');
    }

    /**
     * 获取票据信息
     * @param $name
     * @return array
     */
    public function getBillsByName($bill_tittle)
    {
        try {

            $info = $this->where('bill_tittle', $bill_tittle)->findOrEmpty()->toArray();
        } catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, $info, 'ok');
    }

    /**
     * 获取票据信息
     * @param $id
     * @return array
     */
    public function getBillsInfo($id)
    {
        try {

            $info = $this->where('bills_id', $id)->findOrEmpty()->toArray();
        } catch (\Exception $e) {

            return modelReMsg(-1, '', $e->getMessage());
        }

        return modelReMsg(0, $info, 'ok');
    }


    /**
     * 根据类型 获取票据信息
     * @param $type
     * @return array
     */
    public function getBillsInfoByType($type)
    {
        try {

            $info = $this->where('type', $type)->select()->toArray();
        } catch (\Exception $e) {

            return modelReMsg(-1, [], $e->getMessage());
        }

        return modelReMsg(0, $info, 'ok');
    }



    /**
     * 根据状态 获取票据信息
     * @param $status
     * @return array
     */
    public function getBillsInfoByStatus($status)
    {
        try {

            $info = $this->where('status', $status)->select()->toArray();
        } catch (\Exception $e) {

            return modelReMsg(-1, [], $e->getMessage());
        }

        return modelReMsg(0, $info, 'ok');
    }








}