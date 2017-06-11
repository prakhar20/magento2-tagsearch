<?php 
namespace Codilar\ProductTags\Block\Search;

// use Magento\Catalog\Block\Product\ListProduct;
// use Magento\Catalog\Model\Layer\Resolver as LayerResolver;
// use Magento\CatalogSearch\Helper\Data;
// use Magento\CatalogSearch\Model\ResourceModel\Fulltext\Collection;
// use Magento\Framework\View\Element\Template;
// use Magento\Framework\View\Element\Template\Context;
// use Magento\Search\Model\QueryFactory;
use Codilar\ProductTags\Model\Relations;
use \Magento\Catalog\Model\Product;
use Magento\Catalog\Block\Product\ListProduct;
use Magento\CatalogSearch\Helper\Data;
use \Magento\Framework\App\Request\Http;
class ProductTagSearch
{
	 public function __construct(Relations $tagRelations,Product $productModel , ListProduct $listing , Data $searchHelper ,Http $request){
        $this->_relationModel = $tagRelations;
        $this->_productModel = $productModel;
        $this->_searchHelper = $searchHelper;
        $this->_request = $request;
        $this->_listing = $listing;

    }

    public function afterSetListOrders(\Magento\CatalogSearch\Block\Result $subject,$collection)
    {   
        $searchQuery = $this->_request->getParam('q');
        $products =$this->_relationModel->getProdcutsByTags($searchQuery);
            $realCollection = $this->_listing->getLoadedProductCollection();
            // print_r($realCollection->getData());die;
            $collectionIds = $realCollection->getAllIds()   ;
            foreach($products as $product)
            {
                if(!in_array($product['product_id'],$collectionIds))
                $realCollection->addItem($this->_productModel->load($product['product_id']));
            }
            
            return $realCollection;
    }

  
}