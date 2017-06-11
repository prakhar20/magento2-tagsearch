<?php
namespace Codilar\ProductTags\Ui\Component\Listing\DataProviders\Codilar\Producttags;

class Tagsgrid extends \Magento\Ui\DataProvider\AbstractDataProvider
{    
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Codilar\ProductTags\Model\ResourceModel\Tags\CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }
}
