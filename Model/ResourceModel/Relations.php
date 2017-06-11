<?php
namespace Codilar\ProductTags\Model\ResourceModel;
class Relations extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('tag_relation','value_id');
    }
}
