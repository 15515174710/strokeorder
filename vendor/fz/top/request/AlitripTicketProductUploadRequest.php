<?php
/**
 * TOP API: alitrip.ticket.product.upload request
 * 
 * @author auto create
 * @since 1.0, 2018.07.25
 */
class AlitripTicketProductUploadRequest
{
	/** 
	 * 新发布门票商品时必填。阿里旅行提供的收费项目编码，与商户收费项目编码进行绑定。注：一个收费项目编码对应了一个淘宝商品
	 **/
	private $aliProductId;
	
	/** 
	 * 新发布门票商品时必填。门票商品发码方式
	 **/
	private $codeSendingInfo;
	
	/** 
	 * 可选，商品详情描述，不超过50000个字符。详情描述支持纯文本描述，也支持html格式的详情描述。html格式的详情描述中 图片链接支持外链图片（必须外网可访问， 且格式为png、jpg或jpeg，大小在500k以内）和淘宝图片空间链接。
	 **/
	private $desc;
	
	/** 
	 * 新发布门票商品时必填。门票有效期：指定入园日期后 多少天内有效。当为数字时，表示多少天内有效；当为日期时，表示到某日期有效，日期格式：yyyy-MM-dd。发布时不填则默认设置30天内有效
	 **/
	private $expireDate;
	
	/** 
	 * 新发布门票商品时必填。门票商品 库存类型。1、日历库存， 2、非日历库存
	 **/
	private $inventoryType;
	
	/** 
	 * inventory_type=2时必填，指定该收费项目在购买时是否需要买家指定入园日期。1、需要，2-不需要
	 **/
	private $needEnterDate;
	
	/** 
	 * 可选，商户自定义收费项目编码。注：如果商户上传了自定义收费项目编码，则在价格库存同步接口可以使用该自定义编码更新价格库存。
	 **/
	private $outProductId;
	
	/** 
	 * 商户收费项目名称
	 **/
	private $outProductName;
	
	/** 
	 * 可选，商品主图，最多支持5张。图片链接支持外链图片（即商家系统中图片链接，必须外网可访问，且格式为png、jpg或jpeg，大小在500k以内），或者用户淘宝空间内的图片链接。对于外链图片，将自动下载并上传用户淘宝图片空间，上传失败的外链图片将自动忽略不计。
	 **/
	private $picUrls;
	
	/** 
	 * 特殊选填，门票 预定时间限制规则。格式：1_18_00_3 或者 1_18_00_3_30，含义：必须提前1天拍下，且在18点00分前支付成功，订单才生效。当为提前0天时（即当日票），最后两个数字才生效，指当日票需要在出票后3小时30分钟后方可入园。
	 **/
	private $reserveLimitRule;
	
	/** 
	 * 新发布门票商品时必填。门票 预定时间限制。1、表示无限制 购买后可立即入园，2、有限制，此时预定时间限制规则必填。
	 **/
	private $reserveLimitType;
	
	/** 
	 * 可选，商品标题
	 **/
	private $title;
	
	/** 
	 * 可选，商家想要更新映射关系的时候，用于更新商户自定义收费项目编码。
	 **/
	private $updateOutProductId;
	
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

	public function setCodeSendingInfo($codeSendingInfo)
	{
		$this->codeSendingInfo = $codeSendingInfo;
		$this->apiParas["code_sending_info"] = $codeSendingInfo;
	}

	public function getCodeSendingInfo()
	{
		return $this->codeSendingInfo;
	}

	public function setDesc($desc)
	{
		$this->desc = $desc;
		$this->apiParas["desc"] = $desc;
	}

	public function getDesc()
	{
		return $this->desc;
	}

	public function setExpireDate($expireDate)
	{
		$this->expireDate = $expireDate;
		$this->apiParas["expire_date"] = $expireDate;
	}

	public function getExpireDate()
	{
		return $this->expireDate;
	}

	public function setInventoryType($inventoryType)
	{
		$this->inventoryType = $inventoryType;
		$this->apiParas["inventory_type"] = $inventoryType;
	}

	public function getInventoryType()
	{
		return $this->inventoryType;
	}

	public function setNeedEnterDate($needEnterDate)
	{
		$this->needEnterDate = $needEnterDate;
		$this->apiParas["need_enter_date"] = $needEnterDate;
	}

	public function getNeedEnterDate()
	{
		return $this->needEnterDate;
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

	public function setOutProductName($outProductName)
	{
		$this->outProductName = $outProductName;
		$this->apiParas["out_product_name"] = $outProductName;
	}

	public function getOutProductName()
	{
		return $this->outProductName;
	}

	public function setPicUrls($picUrls)
	{
		$this->picUrls = $picUrls;
		$this->apiParas["pic_urls"] = $picUrls;
	}

	public function getPicUrls()
	{
		return $this->picUrls;
	}

	public function setReserveLimitRule($reserveLimitRule)
	{
		$this->reserveLimitRule = $reserveLimitRule;
		$this->apiParas["reserve_limit_rule"] = $reserveLimitRule;
	}

	public function getReserveLimitRule()
	{
		return $this->reserveLimitRule;
	}

	public function setReserveLimitType($reserveLimitType)
	{
		$this->reserveLimitType = $reserveLimitType;
		$this->apiParas["reserve_limit_type"] = $reserveLimitType;
	}

	public function getReserveLimitType()
	{
		return $this->reserveLimitType;
	}

	public function setTitle($title)
	{
		$this->title = $title;
		$this->apiParas["title"] = $title;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setUpdateOutProductId($updateOutProductId)
	{
		$this->updateOutProductId = $updateOutProductId;
		$this->apiParas["update_out_product_id"] = $updateOutProductId;
	}

	public function getUpdateOutProductId()
	{
		return $this->updateOutProductId;
	}

	public function getApiMethodName()
	{
		return "alitrip.ticket.product.upload";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkMaxListSize($this->picUrls,5,"picUrls");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
