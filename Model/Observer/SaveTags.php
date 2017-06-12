<?php
namespace Codilar\ProductTags\Model\Observer;
use \Codilar\ProductTags\Model\Tags;
use \Codilar\ProductTags\Model\Relations;
use \Codilar\ProductTags\Helper\TextRazor;
use \Codilar\ProductTags\Helper\Textgain;
use \Magento\Customer\Model\Session ;
use \Magento\Framework\Message\ManagerInterface;
class SaveTags implements \Magento\Framework\Event\ObserverInterface
{
	protected $_tagsModel, $_relationsModel ,$_customerSession ,$_messgeManager;
	

	public function __construct(Tags $tags , Relations $relations , Session $customerSession , ManagerInterface $messageManager, TextRazor $textrazor, Textgain $textgain)
	{
		$this->_tagsModel = $tags;
		$this->_relationsModel = $relations;
		$this->_customerSession = $customerSession;
		$this->_messgeManager = $messageManager;
		$this->_analyticsHelper = $textrazor;
		$this->_textGainHelper = $textgain;
	}
    public function execute(\Magento\Framework\Event\Observer $observer){
    	// $request = $observer->getEvent()->getRequest()->getParams();
	    if($this->_customerSession->isLoggedIn()) {
	    	$request = $observer->getEvent()->getRequest()->getParams();
    		
	    	
    		if($request['tags'] != '')
    		{
	    		$tags = explode(',',trim($request['tags']));
			
				if(count($tags) > 0)
				{
					// echo count($tags);die;
					foreach($tags as $tag)
					{
						if(!empty($tag))
						{
							$existingTag = $this->_tagsModel->loadByTitle($tag);
						
						// echo count($existingTag->getData());die;

							if(!count($existingTag->getData()))
							{
								$data = array(
									'title'=>$tag,
									'created_by' => $this->_customerSession->getCustomerId(),
									'status'=>'2');
								try{
									$newTag = $this->_tagsModel->addData($data)->save();
									$relationData = array(
										 	'tag_id'=> $newTag->getId(),
											'product_id'=>$request['id'],
											'customer_id'=>$this->_customerSession->getCustomerId()
									);
									$this->_relationsModel->setData($relationData)->save();
									$this->_messgeManager->addSuccess("New Product Tag ".$existingTag->getTitle()."Created And Added To This Product (Status Pending)");
									}

								catch (\Exception $e){
									$this->_messgeManager->addWarning($existingTag->getTitle().' Tag All Ready Added By You.');
								}
							}

							else
							{
								//Tag Is Already Created Only Add Association With Product
								try
								{
								$relationData = array(
									 'tag_id'=> $existingTag->getTagId(),
									 'product_id'=>$request['id'],
									 'customer_id'=>$this->_customerSession->getCustomerId()
									);
									$this->_relationsModel->addData($relationData);
									$this->_relationsModel->save();
									$this->_messgeManager->addSuccess("All Ready Existing Product Tag".$existingTag->getTitle()."Added To This Product");
								}
								
								catch (\Exception $e)
								{
								$this->_messgeManager->addWarning("Tag ".$existingTag->getTitle().' Tag All Ready Added By You.');
								
								}
							
							}
						}
					
					}
				}
			}

			// if no tags are sent ad is blank;
			// else
			// {
			// 	// $this->_textGainHelper->getSentiments($request['detail']);
			// 	$this->_analyticsHelper->analyze($request['detail']);
			// }
		
		}

		else
		{
			$this->_messgeManager->addError('Only Logged-In Users Can Created/Add Tags To Product');
		} 

		  	
    }
}
