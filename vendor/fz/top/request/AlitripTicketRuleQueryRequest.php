<?php
/**
 * TOP API: alitrip.ticket.rule.query request
 * 
 * @author auto create
 * @since 1.0, 2018.07.25
 */
class AlitripTicketRuleQueryRequest
{
	/** 
	 * 卖家景点规则编码
	 **/
	private $outRuleId;
	
	private $apiParas = array();
	
	public function setOutRuleId($outRuleId)
	{
		$this->outRuleId = $outRuleId;
		$this->apiParas["out_rule_id"] = $outRuleId;
	}

	public function getOutRuleId()
	{
		return $this->outRuleId;
	}

	public function getApiMethodName()
	{
		return "alitrip.ticket.rule.query";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->outRuleId,"outRuleId");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
