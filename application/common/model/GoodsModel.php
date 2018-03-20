<?php
/**
 * Created by PhpStorm.
 * User: fengchu
 * Date: 18/1/3
 * Time: 上午11:44
 */
namespace app\common\model;

use think\Model;

class GoodsModel extends Model
{
    protected $table = "Goods";

    /*
     * 商品列表
     * */
    public function getGoodsList($goodsStatus=0, $page=1, $limit=10)
    {
        $result['count'] = 0;
        $result['data'] = [];
        $offset = ($page-1)*$limit;
        $where = [
            'isDeleted'=>0,
        ];
        !empty($goodsStatus)   &&   $where['goodsStatus']   = $goodsStatus;
        $result['count'] = db($this->table)->where($where)->count();

        $result['data'] = db($this->table)
            ->where($where)
            ->order('sort DESC')
            ->limit($limit, $offset)
            ->select();

        return $result;
    }

    /*
     * 添加商品信息
     * */
    public function addGoodsInfo($data)
    {
        if(!is_array($data)){
            $this->msg = '数据格式异常！';
            return false;
        }
        //$data = $this->checkColumn($data,$this->getISnobAuthorColumn());
        if(empty($data)){
            $this->msg = '无新增数据信息！';
            return false;
        }
        $data['created'] = time();
        $status = db($this->table)->insert($data);
        $this->status=$status;

        return $status;

    }

    /*
     * 更新商品信息
     * */
    public function updateGoodsInfo($data = [])
    {
        if(!isset($data['id'])){
            $this->msg = '无修改主键！';
            return false;
        }
        if(!is_array($data)){
            $this->msg = '数据格式异常！';
            return false;
        }

        $where = ['id'=>$data['id']];
        //$data = $this->checkColumn($data,$this->getISnobAuthorColumn());
        if(empty($data)){
            $this->msg = '无修改数据信息！';
            return false;
        }
        $data['updated'] = time();
        $status = db($this->table)->where($where)->update($data);
        $this->status=$status;

        return $status;
    }

    /*
     * 删除商品
     * */
    public function delGoodsInfo($id)
    {
        if(empty($id)){
            $this->msg = '无删除主键！';
            return false;
        }
        $where = ['id'=>$id];
        $data['isDeleted'] = 1;
        $data['updated'] = time();
        $status = db($this->table)->where($where)->update($data);
        $this->status=$status;

        return $status;
    }

    /*
     * 查询商品信息
     * */
    public function seachGoodsList($condition, $page=1, $limit=10)
    {
        $result['count'] = 0;
        $result['data'] = [];
        $offset = ($page-1)*$limit;
        $where = [
            'isDeleted'=>0,
        ];
        !empty($condition['categoryId'])   &&      $where['categoryId']        = (int)$condition['categoryId'];
        !empty($condition['name'])         &&      $where['name']  = ['like','%'.$condition['name'].'%'];
        !empty($condition['goodsStatus'])  &&      $where['goodsStatus']        = $condition['goodsStatus'];
        //排序类型
        $condition['sortType'] = 2 ? $order['weight'] = 'DESC' : $order['sort'] = 'DESC';

        $result['count'] = db($this->table)->where($where)->count();
        $result['data'] = db($this->table)
            ->where($where)
            ->order($order)
            ->limit($limit, $offset)
            ->select();

        return $result;
    }

    /*
     * 商品上架
     * */
    public function goodsShelves($id)
    {
        if(!isset($id)){
            $this->msg = '无修改主键！';
            return false;
        }

        $where = ['id'=>$id];
        $data['goodsStatus'] = 1;
        $data['updated'] = time();
        $status = db($this->table)->where($where)->update($data);
        $this->status=$status;

        return $status;
    }

    /*
     * 商品下架
     * */
    public function goodsOffShelves($id)
    {
        if(!isset($id)){
            $this->msg = '无修改主键！';
            return false;
        }

        $where = ['id'=>$id];
        $data['goodsStatus'] = 2;
        $data['updated'] = time();
        $status = db($this->table)->where($where)->update($data);
        $this->status=$status;

        return $status;

    }


}
