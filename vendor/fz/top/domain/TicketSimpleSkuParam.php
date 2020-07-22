<?php

/**
 * 门票商品下 各个票种的sku信息
 * @author auto create
 */
class TicketSimpleSkuParam
{
	
	/** 
	 * 该票种下使用的价格规则
	 **/
	public $price_rules;
	
	/** 
	 * 门票区域（场次门票专用）
	 **/
	public $ticket_area;
	
	/** 
	 * 门票场次（场次门票专用）
	 **/
	public $ticket_season;
	
	/** 
	 * 门票 票种类型
	 **/
	public $ticket_type;	
}
?>