<?php

/**
 * 价格库存同步结果
 * @author auto create
 */
class TicketItemResult
{
	
	/** 
	 * 标准收费项目id
	 **/
	public $ali_product_id;
	
	/** 
	 * 标准景点id
	 **/
	public $ali_scenic_id;
	
	/** 
	 * 预留，扩展字段
	 **/
	public $extend;
	
	/** 
	 * 商品id
	 **/
	public $item_id;
	
	/** 
	 * 修改时间
	 **/
	public $modifyed_time;
	
	/** 
	 * 商户收费项目id
	 **/
	public $out_product_id;
	
	/** 
	 * 商户景点id
	 **/
	public $out_scenic_id;	
}
?>