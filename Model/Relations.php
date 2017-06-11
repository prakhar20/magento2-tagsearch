<?php
namespace Codilar\ProductTags\Model;
class Relations extends \Magento\Framework\Model\AbstractModel implements RelationsInterface, \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'codilar_producttags_relations';

    protected function _construct()
    {
        $this->_init('Codilar\ProductTags\Model\ResourceModel\Relations');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
    public function getProdcutsByTags($tags=null)
    {
        $collection = $this->getCollection();
        // $collection->addFieldToSelect('');
        $collection->removeAllFieldsFromSelect();
        $collection->getSelect()->join(
                    //2nd table name by which you want to join mail table
                    ['tags' => $collection->getTable('codilar_producttags_tags')], 
                    // common column which available in both table 
                    'main_table.tag_id = tags.tag_id',
                    // '*' define that you want all column of 2nd table. if you want some particular column then you can define as ['column1','column2']
                    ['main_table.product_id'] 
                    );
        if($tags != null)
        {
            $tags = explode(' ',$tags);
            if(count($tags)> 0 )
            {  
                $collection->addFieldToFilter('tags.title',array('in'=>$tags));
            }
        }
        $collection->getSelect()->group('product_id');
        return $collection;
    	
    }
}
