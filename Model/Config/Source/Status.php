<?php
namespace Codilar\ProductTags\Model\Config\Source;
use \Magento\Framework\App\Request\Http;
class Status implements \Magento\Framework\Option\ArrayInterface
{

	public function toOptionArray()
	{
		$response[]=array('value'=>'0','label'=>'Disabled');
		$response[]=array('value'=>'1','label'=>'Approved');
		$response[]=array('value'=>'2','label'=>'Pending');
		return $response;
	}
}