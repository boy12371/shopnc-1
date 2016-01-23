<?php
/**
 * 支付宝通知地址
 *
 * 
 * by shopjl 网店技术交流中心  www.corecreate.cn 开发
 */
$_GET['act']	= 'payment';
$_GET['op']		= 'notify';
$_GET['payment_code'] = 'alipay';
require_once(dirname(__FILE__).'/../../../index.php');
?>