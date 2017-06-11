<?php
namespace Codilar\ProductTags\Controller\Adminhtml\Tags;

use Magento\Backend\App\Action;
use Codilar\ProductTags\Model\Page;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
            
class Save extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'codilar_producttags::tagsAddNew';

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Codilar\ProductTags\Model\Tags::STATUS_ENABLED;
            }
            if (empty($data['codilar_producttags_tags_id'])) {
                $data['codilar_producttags_tags_id'] = null;
            }

            /** @var Codilar\ProductTags\Model\Tags $model */
            $model = $this->_objectManager->create('Codilar\ProductTags\Model\Tags');

            $id = $this->getRequest()->getParam('tag_id');
            if ($id) {
                $model->load($id);
            }

            $model->setData($data);

            try {
                
                if(!count($model->loadByTitle($data['title']))){
                $model->save();
                $this->messageManager->addSuccess(__('You saved Tag.'));
                }
                else
                {
                $this->messageManager->addError(__('This Tag Already Exist'));
                }

                $this->dataPersistor->clear('codilar_producttags_tags');
                
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['tags_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }

            $this->dataPersistor->set('codilar_producttags_tags', $data);
            return $resultRedirect->setPath('*/*/edit', ['codilar_producttags_tags_id' => $this->getRequest()->getParam('codilar_producttags_tags_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }    
}
