<?php

/**
 * 电子凭证信息，code_mode=1时必填。
 * @author auto create
 */
class ItemEleCertInfo
{
	
	/** 
	 * 可选，售中自动退款比例，0~100。默认为0，即不支持售中自动退款；当值为1~100时表示售中自动退款的比例
	 **/
	public $auto_refund_rate;
	
	/** 
	 * 可选，过期自动退款比例，0~100。默认为0，即不支持过期自动退款比例；当值为1~100时表示过期自动退款的比例
	 **/
	public $expired_refund_rate;
	
	/** 
	 * 特殊必填（expiryDateType为1或2时必填），电子凭证 有效期 结束时间
	 **/
	public $expiry_date_end;
	
	/** 
	 * 特殊必填（expiryDateType为1时必填），电子凭证 有效期 开始时间
	 **/
	public $expiry_date_start;
	
	/** 
	 * 必填，电子凭证有效期 过期类型。1：xxxx-xx-xx 到 xxxx-xx-xx； 2：购买成功日 至 xxxx-xx-xx； 3：购买成功 xx 天内有效
	 **/
	public $expiry_date_type;
	
	/** 
	 * 特殊必填（expiryDateType为3时必填），电子凭证 有效期 天数
	 **/
	public $expiry_days;
	
	/** 
	 * 必填，核销服务提供商
	 **/
	public $merchant_name;
	
	/** 
	 * 必填，核销门店库id
	 **/
	public $package_id;
	
	/** 
	 * 必填，店铺联系方式
	 **/
	public $shop_tel;	
}
?>