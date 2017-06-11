<?php
namespace Codilar\ProductTags\Model\ResourceModel\Tags;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Codilar\ProductTags\Model\Tags','Codilar\ProductTags\Model\ResourceModel\Tags');
    }
}
