<?php
/**
 * TOP API: alitrip.ticket.skus.batch.upload request
 * 
 * @author auto create
 * @since 1.0, 2018.07.25
 */
class AlitripTicketSkusBatchUploadRequest
{
	/** 
	 * 特殊必填，阿里标准收费项目id。ali_product_id, item_id与out_product_id三选一，至少填写其中一个
	 **/
	private $aliProductId;
	
	/** 
	 * 特殊必填，淘宝商品id。ali_product_id, item_id与out_product_id三选一，至少填写其中一个
	 **/
	private $itemId;
	
	/** 
	 * 特殊必填，商户收费项目id。ali_product_id, item_id与out_product_id三选一，至少填写其中一个
	 **/
	private $outProductId;
	
	/** 
	 * 必填，各票种下sku的价格库存参数。
	 **/
	private $ticketPriceRules;
	
	private $apiParas = array();
	
	public function setAliProductId($aliProductId)
	{
		$this->aliProductId = $aliProductId;
		$this->apiParas["ali_product_id"] = $aliProductId;
	}

	public function getAliProductId()
	{
		return $this->aliProductId;
	}

	public function setItemId($itemId)
	{
		$this->itemId = $itemId;
		$this->apiParas["item_id"] = $itemId;
	}

	public function getItemId()
	{
		return $this->itemId;
	}

	public function setOutProductId($outProductId)
	{
		$this->outProductId = $outProductId;
		$this->apiParas["out_product_id"] = $outProductId;
	}

	public function getOutProductId()
	{
		return $this->outProductId;
	}

	public function setTicketPriceRules($ticketPriceRules)
	{
		$this->ticketPriceRules = $ticketPriceRules;
		$this->apiParas["ticket_price_rules"] = $ticketPriceRules;
	}

	public function getTicketPriceRules()
	{
		return $this->ticketPriceRules;
	}

	public function getApiMethodName()
	{
		return "alitrip.ticket.skus.batch.upload";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
