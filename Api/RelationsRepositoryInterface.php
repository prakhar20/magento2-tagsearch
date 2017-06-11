<?php
namespace Codilar\ProductTags\Api;

use Codilar\ProductTags\Model\RelationsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface RelationsRepositoryInterface 
{
    public function save(RelationsInterface $page);

    public function getById($id);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(RelationsInterface $page);

    public function deleteById($id);
}
