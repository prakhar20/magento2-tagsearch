<?php
namespace Codilar\ProductTags\Helper;
use \Magento\Framework\HTTP\Client\Curl;
use \Magento\Framework\App\Config\ScopeConfigInterface;
class TextRazor extends \Magento\Framework\App\Helper\AbstractHelper
{
	protected $_APIKEY = 'c27c6e6d3a9dced185ccab2707ba4d28a2687e1f9195d2ea5d4f49f5';
	public function __construct(Curl $curl , ScopeConfigInterface $scopeConfig)
	{

		$this->_httpCurl = $curl; 
		$this->_scopeConfig = $scopeConfig;
		$this->_url = "http://api.textrazor.com/";
	}

	private function createCall($queryString)
	{
		$extract=  	array(
						'classifiers',
						// 'entities',
						'entailments',
						// 'phrases',
						// 'topics',
						// 'senses',
						// 'words'
						// 'relations',
						); 

		// entities, topics, words, phrases, dependency-trees, relations, entailments, senses, spelling
		$this->_httpCurl->addHeader("x-textrazor-key",$this->_APIKEY);
		$data['extractors'] = implode(',',$extract);
		$data['text'] = $queryString;

		$this->_httpCurl->post($this->_url,$data);

		return $this->_httpCurl->getBody();
	}


	public function analyze($text="Made In India")
	{
		$response =json_decode($this->createCall($text),true);
		// $response =$this->createCall($text);
		echo "<pre>";
		print_r($response);
		// echo $response;
		die;
		foreach($response['response']['entailments']  as $entailment)
		{
			print_r($entailment);
		}


		die;

	}

}