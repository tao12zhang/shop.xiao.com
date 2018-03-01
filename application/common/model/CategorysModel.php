<?php
/**
 * Created by PhpStorm.
 * User: fengchu
 * Date: 18/1/12
 * Time: 上午11:42
 */

namespace app\common\model;

use think\Model;

class CategorysModel extends Model
{

    protected $table = "Categorys";

    /*
     * 商品分组列表
     * */
    public function getCategorysList($page=1, $limit=10)
    {
        $result['count'] = 0;
        $result['data'] = [];
        $offset = ($page-1)*$limit;
        $where = [
            'isDeleted'=>0,
        ];
        //!empty($goodsStatus)   &&   $where['goodsStatus']   = $goodsStatus;
        $result['count'] = db($this->table)->where($where)->count();

        $result['data'] = db($this->table)
            ->where($where)
            ->order('sort DESC')
            ->limit($limit, $offset)
            ->select();

        return $result;
    }

    /*
     * 新增商品分组
     * */
    public function addCategorysInfo($data)
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
     * 编辑商品分组
     * */

    public function updateCategorysInfo($data = [])
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
     * 删除商品分组
     * */
    public function delCategorysInfo($id)
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
}