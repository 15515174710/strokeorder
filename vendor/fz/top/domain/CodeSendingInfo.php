<?php

/**
 * 新发布门票商品时必填。门票商品发码方式
 * @author auto create
 */
class CodeSendingInfo
{
	
	/** 
	 * 发码方式。1、电子票自动发码 需设置电子凭证信息，2、电子票手工发码，3、实体票
	 **/
	public $code_mode;
	
	/** 
	 * 电子凭证信息，code_mode=1时必填。
	 **/
	public $elec_info;
	
	/** 
	 * 手工发码 是否需要买家邮箱，code_mode=2时选填，不填则默认不需要邮箱信息。
	 **/
	public $has_email;	
}
?>