<?php
/**
 * 邀请返利页面
 * by 网店技术交流中心 ww w.33 ha o.c om 
 */
defined('InShopNC') or exit('Access Invalid!');
class inviteControl extends BaseHomeControl{
	public function indexOp(){
		Tpl::showpage('invite');
	}
}
