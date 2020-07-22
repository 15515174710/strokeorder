<?php

/**
 * 门票规则信息
 * @author auto create
 */
class TicketRuleParam
{
	
	/** 
	 * 阿里旅行景点编码
	 **/
	public $ali_scenic_id;
	
	/** 
	 * 景区入园地址
	 **/
	public $enter_address;
	
	/** 
	 * 入园类型。1-用兑换凭证直接入园，2-用兑换凭证换票入园
	 **/
	public $enter_type;
	
	/** 
	 * 入园使用的凭证类型。1、二维码，2、身份证，3、二维码或身份证，4:数字码，5、手机号，6、其它
	 **/
	public $enter_voucher_type;
	
	/** 
	 * 其他入园凭证类型。
	 **/
	public $enter_voucher_value;
	
	/** 
	 * 补充说明
	 **/
	public $extra_desc;
	
	/** 
	 * 门票费用包含
	 **/
	public $fee_include;
	
	/** 
	 * 卖家景点规则编码
	 **/
	public $out_rule_id;
	
	/** 
	 * 卖家景点规则名称
	 **/
	public $out_rule_name;
	
	/** 
	 * 商户景点编码
	 **/
	public $out_scenic_id;
	
	/** 
	 * 退票描述
	 **/
	public $refund_desc;
	
	/** 
	 * 退票类型。1-无条件退改， 2-有条件退改， 3-不可退改。
	 **/
	public $refund_type;
	
	/** 
	 * 规则状态（0：有效，-1：失效）
	 **/
	public $rule_status;
	
	/** 
	 * 票种规则类型(0实体票规则；1电子票规则)
	 **/
	public $rule_type;
	
	/** 
	 * 换票地址
	 **/
	public $ticket_change_adderss;
	
	/** 
	 * 需要的出游人信息，2:手机号,3:身份证,4:姓名,5:护照号码 6:护照姓名拼音。
	 **/
	public $visitor_infos;
	
	/** 
	 * 出游人 是否限购。1:限购,2:不限购
	 **/
	public $visitor_limit_able;
	
	/** 
	 * 限购模式。mode为1按天, mode为2按周, mode为3按月
	 **/
	public $visitor_limit_mode;
	
	/** 
	 * 限购数量
	 **/
	public $visitor_limit_num;
	
	/** 
	 * 限购类型。0-身份证限购， 1-手机号限购
	 **/
	public $visitor_limit_type;
	
	/** 
	 * 游客信息设置 1:不需要,2:仅需一位游客信息,3:需要所有游客信息
	 **/
	public $visitor_require;	
}
?>