<?php
namespace Codilar\ProductTags\Helper;
use \Magento\Framework\HTTP\Client\Curl;
use \Magento\Framework\App\Config\ScopeConfigInterface;
class Textgain extends \Magento\Framework\App\Helper\AbstractHelper
{
		public function __construct(Curl $curl , ScopeConfigInterface $scopeConfig)
	{

		$this->_httpCurl = $curl; 
		$this->_scopeConfig = $scopeConfig;
		$this->_url = "https://api.textgain.com/";
	}

	private function createCall($queryString)
	{
		$data['q'] =  $queryString;
		$data['top'] = 3;
		$this->_httpCurl->addHeader("origin","https://www.textgain.com");
		// $this->_httpCurl->addHeader("referer","https://www.textgain.com");
		$this->_httpCurl->get($this->_url,$data);
		return $this->_httpCurl->getBody();
	}

	public function getSentiments($text = "I Love My India")
	{
		$this->_url = $this->_url."1/en/sentiment";
		echo $this->createCall($text);
		die;
	}
}