<?php
/**
 * 物流自提服务站首页
 *
 **by 网店技术交流中心 www.corecreate.cn 运营版*/

defined('InShopNC') or exit('Access Invalid!');

class indexControl extends BaseDeliveryControl{
    public function __construct(){
        parent::__construct();
        @header('location: index.php?act=login');die;
    }
}

