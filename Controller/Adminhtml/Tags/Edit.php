<?php
namespace Codilar\ProductTags\Controller\Adminhtml\Tags;

class Edit extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'codilar_producttags::tagsAddNew';       
    protected $resultPageFactory;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;        
        return parent::__construct($context);
    }
    
    public function execute()
    {
        return $this->resultPageFactory->create();  
    }    
}
