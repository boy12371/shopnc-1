<?php
/**
 * 商品与属性对应
 *
 *
 *
 *
 * by shopjl 网店技术交流中心  www.corecreate.cn 开发
 */
defined('InShopNC') or exit('Access Invalid!');

class goods_attr_indexModel extends Model {
    public function __construct() {
        parent::__construct('goods_attr_index');
    }
    
    /**
     * 对应列表
     * 
     * @param array $condition
     * @param string $field
     * @return array
     */
    public function getGoodsAttrIndexList($condition, $field = '*') {
        return $this->where($condition)->field($field)->select();
    }
}