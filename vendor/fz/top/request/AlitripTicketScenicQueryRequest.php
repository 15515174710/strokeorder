<?php
/**
 * TOP API: alitrip.ticket.scenic.query request
 * 
 * @author auto create
 * @since 1.0, 2018.07.25
 */
class AlitripTicketScenicQueryRequest
{
	/** 
	 * 标准景点ID。ali_scenic_id，out_scenic_id二者至少需要填写一个
	 **/
	private $aliScenicId;
	
	/** 
	 * 当前分页。每页默认最多返回20条数据
	 **/
	private $currentPage;
	
	/** 
	 * 商家景点ID。ali_scenic_id，out_scenic_id二者至少需要填写一个
	 **/
	private $outScenicId;
	
	private $apiParas = array();
	
	public function setAliScenicId($aliScenicId)
	{
		$this->aliScenicId = $aliScenicId;
		$this->apiParas["ali_scenic_id"] = $aliScenicId;
	}

	public function getAliScenicId()
	{
		return $this->aliScenicId;
	}

	public function setCurrentPage($currentPage)
	{
		$this->currentPage = $currentPage;
		$this->apiParas["current_page"] = $currentPage;
	}

	public function getCurrentPage()
	{
		return $this->currentPage;
	}

	public function setOutScenicId($outScenicId)
	{
		$this->outScenicId = $outScenicId;
		$this->apiParas["out_scenic_id"] = $outScenicId;
	}

	public function getOutScenicId()
	{
		return $this->outScenicId;
	}

	public function getApiMethodName()
	{
		return "alitrip.ticket.scenic.query";
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
