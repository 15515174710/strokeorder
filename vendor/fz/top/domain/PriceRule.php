<?php

/**
 * 必填，该票种下使用的价格规则。
 * @author auto create
 */
class PriceRule
{
	
	/** 
	 * 必填，每日价格库存。
	 **/
	public $date_inventorys;
	
	/** 
	 * 必填，商户票种规则id
	 **/
	public $out_rule_id;
	
	/** 
	 * 可选，sku的商家编码（用于区分在 不同票种下使用同一outRuleId的情况）
	 **/
	public $out_sku_id;
	
	/** 
	 * 可选，1-全量更新，2-增量更新（增加或覆盖某一天的价格库存），不传默认为1。
	 **/
	public $upload_type;	
}
?>