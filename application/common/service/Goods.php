<?php
/**
 * Created by PhpStorm.
 * User: fengchu
 * Date: 18/1/16
 * Time: 下午3:09
 */
namespace common\service;

use think\Model;
use common\model\GoodsModel;
use common\service\BaseService as BaseService;

class Goods extends BaseService
{
    private $GoodsModel;

    function __construct()
    {
        parent::__construct();
        $this->GoodsModel = new GoodsModel();

    }

    /*
     * 商品列表
     * */
    public function getOpGoodsList($goodsStatus,$page, $pageSize)
    {
        $result['count'] = 0;
        $result['list'] = [];
        $data = $this->GoodsModel->getGoodsList($goodsStatus,$page, $pageSize);
        if (!is_array($data['data']) || empty($data['data'])) {
            return $result;
        }

        foreach ($data as $info) {
            $list[] = [
                'id'            =>$info['id'],
                'name'          =>$info['name'],
                'price'         =>$info['price'],
                'detailPicture' =>getFullImageUrl($info['detailPicture']),
                'totalStock'    =>$info['totalStock'],
                'totalSales'    =>$info['totalSales'],
                'weight'        =>$info['weight'],
                'sort'          =>$info['sort'],
                'recommend'     =>$info['recommends']?1:0,

            ];
        }
        $result['count'] = $data['count'];
        $result['list'] = $list;

        return $result;
    }






}