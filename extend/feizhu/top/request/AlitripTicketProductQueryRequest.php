<?php
/**
 * TOP API: alitrip.ticket.product.query request
 * 
 * @author auto create
 * @since 1.0, 2018.07.25
 */
class AlitripTicketProductQueryRequest
{
	/** 
	 * 阿里标准收费项目id。与out_product_id，item_id 三者至少填写一个
	 **/
	private $aliProductId;
	
	/** 
	 * 商品ID。与out_product_id，ali_product_id三者至少填写一个
	 **/
	private $itemId;
	
	/** 
	 * 商户自定义收费项目编码。与ali_product_id，item_id 三者至少填写一个
	 **/
	private $outProductId;
	
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

	public function getApiMethodName()
	{
		return "alitrip.ticket.product.query";
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
