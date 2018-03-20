<?php
/**
 * Created by PhpStorm.
 * User: fengchu
 * Date: 18/1/4
 * Time: 下午2:01
 */
namespace app\common\model;

use think\Model;

class OrderModel extends Model
{
    protected $table = "Order";

    /*
     * 订单列表
     * */
    public function getOrderList($orderStatus = 0, $page=1, $limit=10)
    {
        $result['count'] = 0;
        $result['data'] = [];
        $offset = ($page-1)*$limit;
        $where = [
            'isDeleted'=>0,
        ];
        !empty($orderStatus)   &&   $where['orderStatus']   = $orderStatus;
        $result['count'] = db($this->table)->where($where)->count();

        $result['data'] = db($this->table)
            ->where($where)
            ->order('sort DESC')
            ->limit($limit, $offset)
            ->select();

        return $result;
    }

    /*
     * 订单详情
     * */
    public function getOrderInfo($id)
    {
        $result['count'] = 1;
        $result['data'] = [];
        if(empty($id)){
            return $result;
        }
        $query = db($this->table)
            ->where('id',$id)
            //->where('type',2)
            ->where('isDeleted',0)
            ->select();

        //echo $this->db->last_query();
        if($query && $data = $query->row_array()){
            $content = $data['contentUrl']?@file_get_contents($data['contentUrl']):'';
            $data['content'] = [];
            if($content && $content = json_decode($content,true)){
                $data['content'] = $content;
            }
            $result['data'] = $data;
        }
        $this->addRankCount($id);
        return $result;
    }


    /*
     * 查询订单
     * */
    public function seachOrderList($params, $page=1, $limit=10)
    {

    }

    /*
     * 取消订单
     * */
    public function cancelOrder()
    {

    }

    /*
     * 批量导出订单
     * */
    public function exportOrderList()
    {

    }








}