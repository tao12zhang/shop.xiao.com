<?php
/**
 * Created by PhpStorm.
 * User: fengchu
 * Date: 18/1/16
 * Time: 下午6:14
 */
namespace common\service;

use think\Model;
use common\model\CategorysModel;
use common\service\BaseService as BaseService;

class Goods extends BaseService
{
    private $CategorysModel;

    function __construct()
    {
        parent::__construct();
        $this->CategorysModel = new CategorysModel();

    }

    /*
     * 商品分组列表
     * */
    public function getCategorysList($page, $pageSize)
    {
        $result['count'] = 0;
        $result['list'] = [];
        $data = $this->CategorysModel->getCategorysList($page, $pageSize);
        if (!is_array($data['data']) || empty($data['data'])) {
            return $result;
        }

        foreach ($data as $info) {
            $list[] = [
                'id'            =>$info['id'],
                'name'          =>$info['name'],
                'number'         =>$info['price'],
                'detailPicture' =>getFullImageUrl($info['detailPicture']),
                'totalStock'    =>$info['totalStock'],

            ];
        }
        $result['count'] = $data['count'];
        $result['list'] = $list;

        return $result;
    }





}
