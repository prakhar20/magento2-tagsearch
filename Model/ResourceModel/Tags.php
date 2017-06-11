<?php
namespace Codilar\ProductTags\Model\ResourceModel;
class Tags extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('codilar_producttags_tags','codilar_producttags_tags_id');
    }
}
