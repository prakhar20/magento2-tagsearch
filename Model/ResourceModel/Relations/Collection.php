<?php
namespace Codilar\ProductTags\Model\ResourceModel\Relations;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Codilar\ProductTags\Model\Relations','Codilar\ProductTags\Model\ResourceModel\Relations');
    }

}
