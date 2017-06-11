<?php
namespace Codilar\ProductTags\Model;
class Tags extends \Magento\Framework\Model\AbstractModel implements TagsInterface, \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'codilar_producttags_tags';

    protected function _construct()
    {
        $this->_init('Codilar\ProductTags\Model\ResourceModel\Tags');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function loadByTitle($title = null)
    {
    	return $this->getCollection()->addFieldToFilter('title',$title)->getFirstItem();
    }
}
