<?php
namespace feizhu\top\request;

require_once str_replace('top\request', 'TopSdk.php', dirname(__FILE__));

/**
 * TOP API: taobao.trade.fullinfo.get request
 * 
 * @author auto create
 * @since 1.0, 2019.08.15
 */
class TradeFullinfoGetRequest
{
	/** 
	 * 需要返回的字段列表，多个字段用半角逗号分隔，可选值为返回示例中能看到的所有字段。
	 **/
	private $fields;
	
	/** 
	 * 交易编号
	 **/
	private $tid;
	
	private $apiParas = array();
	
	public function setFields($fields)
	{
		$this->fields = $fields;
		$this->apiParas["fields"] = $fields;
	}

	public function getFields()
	{
		return $this->fields;
	}

	public function setTid($tid)
	{
		$this->tid = $tid;
		$this->apiParas["tid"] = $tid;
	}

	public function getTid()
	{
		return $this->tid;
	}

	public function getApiMethodName()
	{
		return "taobao.trade.fullinfo.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		\feizhu\top\RequestCheckUtil::checkNotNull($this->fields,"fields");
		\feizhu\top\RequestCheckUtil::checkNotNull($this->tid,"tid");
		\feizhu\top\RequestCheckUtil::checkMaxValue($this->tid,9223372036854775807,"tid");
		\feizhu\top\RequestCheckUtil::checkMinValue($this->tid,1,"tid");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
