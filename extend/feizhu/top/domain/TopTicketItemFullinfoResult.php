<?php

/**
 * 门票商品详情
 * @author auto create
 */
class TopTicketItemFullinfoResult
{
	
	/** 
	 * 阿里旅行提供的收费项目编码
	 **/
	public $ali_product_id;
	
	/** 
	 * 阿里旅行收费项目名称
	 **/
	public $ali_product_name;
	
	/** 
	 * 阿里旅行提供的景点编码
	 **/
	public $ali_scenic_id;
	
	/** 
	 * 联票的场景，则该收费项目可能关联多个景点，以英文逗号分隔
	 **/
	public $ali_scenic_ids;
	
	/** 
	 * 门票商品发码方式
	 **/
	public $code_sending_info;
	
	/** 
	 * 商品详情描述
	 **/
	public $desc;
	
	/** 
	 * 门票有效期：指定入园日期后 多少天内有效。当为数字时，表示多少天内有效；当为日期时，表示到某日期有效，日期格式：yyyy-MM-dd
	 **/
	public $expire_date;
	
	/** 
	 * 门票商品 库存类型。1、每日库存， 2、区间总库存
	 **/
	public $inventory_type;
	
	/** 
	 * 商品ID
	 **/
	public $item_id;
	
	/** 
	 * 商品状态 0-下架，1-上架
	 **/
	public $item_status;
	
	/** 
	 * 是否需要买家指定入园日期。1、需要，2-不需要
	 **/
	public $need_enter_date;
	
	/** 
	 * 商户自定义收费项目编码
	 **/
	public $out_product_id;
	
	/** 
	 * 商户收费项目名称
	 **/
	public $out_product_name;
	
	/** 
	 * 商户系统中景点编码
	 **/
	public $out_scenic_id;
	
	/** 
	 * 商品主图
	 **/
	public $pic_urls;
	
	/** 
	 * 门票 预定时间限制规则。格式：1_18_00_3，含义：必须提前1天拍下，且在18点00分前支付成功，订单才生效。当为提前0天时（即当日票），最后一个数字才有用，指当日票需要在预定3小时后入园。
	 **/
	public $reserve_limit_rule;
	
	/** 
	 * 门票 预定时间限制。1、表示无限制 购买后可立即入园，2、有限制，此时预定时间限制规则必填。
	 **/
	public $reserve_limit_type;
	
	/** 
	 * 门票商品下 各个票种的sku信息
	 **/
	public $ticket_types;
	
	/** 
	 * 商品标题
	 **/
	public $title;
	
	/** 
	 * 手机描述
	 **/
	public $wap_desc;	
}
?>