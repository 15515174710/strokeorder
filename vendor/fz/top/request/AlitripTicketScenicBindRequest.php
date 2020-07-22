<?php
/**
 * TOP API: alitrip.ticket.scenic.bind request
 * 
 * @author auto create
 * @since 1.0, 2018.07.25
 */
class AlitripTicketScenicBindRequest
{
	/** 
	 * 商户景点地址
	 **/
	private $address;
	
	/** 
	 * 必填，阿里旅行对应的景点编码
	 **/
	private $aliScenicId;
	
	/** 
	 * 商户景点城市
	 **/
	private $city;
	
	/** 
	 * 必填，商户系统中的景点编码，用于与ali_scenic_id建立映射关系
	 **/
	private $outScenicId;
	
	/** 
	 * 商户景点名称
	 **/
	private $outScenicName;
	
	/** 
	 * 商户景点省份
	 **/
	private $province;
	
	/** 
	 * 可选，如果需要更新out_scenic_id与ali_scenic_id的映射关系时 需要填写
	 **/
	private $updateOutScenicId;
	
	private $apiParas = array();
	
	public function setAddress($address)
	{
		$this->address = $address;
		$this->apiParas["address"] = $address;
	}

	public function getAddress()
	{
		return $this->address;
	}

	public function setAliScenicId($aliScenicId)
	{
		$this->aliScenicId = $aliScenicId;
		$this->apiParas["ali_scenic_id"] = $aliScenicId;
	}

	public function getAliScenicId()
	{
		return $this->aliScenicId;
	}

	public function setCity($city)
	{
		$this->city = $city;
		$this->apiParas["city"] = $city;
	}

	public function getCity()
	{
		return $this->city;
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

	public function setOutScenicName($outScenicName)
	{
		$this->outScenicName = $outScenicName;
		$this->apiParas["out_scenic_name"] = $outScenicName;
	}

	public function getOutScenicName()
	{
		return $this->outScenicName;
	}

	public function setProvince($province)
	{
		$this->province = $province;
		$this->apiParas["province"] = $province;
	}

	public function getProvince()
	{
		return $this->province;
	}

	public function setUpdateOutScenicId($updateOutScenicId)
	{
		$this->updateOutScenicId = $updateOutScenicId;
		$this->apiParas["update_out_scenic_id"] = $updateOutScenicId;
	}

	public function getUpdateOutScenicId()
	{
		return $this->updateOutScenicId;
	}

	public function getApiMethodName()
	{
		return "alitrip.ticket.scenic.bind";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->aliScenicId,"aliScenicId");
		RequestCheckUtil::checkNotNull($this->outScenicId,"outScenicId");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
