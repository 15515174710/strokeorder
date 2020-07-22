<?php

/**
 * 必填，每日价格库存。
 * @author auto create
 */
class DateInventory
{
	
	/** 
	 * 日期。格式：2016-12-10 23:59:00
	 **/
	public $date;
	
	/** 
	 * 可选，日期级别自定义商家编码，为该sku下每一天都设置一个自定义商家编码。如果outSkuDateId不传，则该天的商家自定义编码将以outSkuId为准
	 **/
	public $out_sku_date_id;
	
	/** 
	 * 价格，以分为单位，必须大于0。
	 **/
	public $price;
	
	/** 
	 * 库存，必须大于等于0
	 **/
	public $stock;	
}
?>