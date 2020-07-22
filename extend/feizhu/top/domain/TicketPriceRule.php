<?php

/**
 * 必填，各票种下sku的价格库存参数。
 * @author auto create
 */
class TicketPriceRule
{
	
	/** 
	 * 必填，该票种下使用的价格规则。
	 **/
	public $price_rules;
	
	/** 
	 * 可选，门票区域（场次门票专用，对于场次门票必选）
	 **/
	public $ticket_area;
	
	/** 
	 * 可选，门票场次（场次门票专用，对于场次门票必选）
	 **/
	public $ticket_season;
	
	/** 
	 * 必填，门票 票种类型
	 **/
	public $ticket_type;	
}
?>