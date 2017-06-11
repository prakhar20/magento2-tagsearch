<?php
namespace Codilar\ProductTags\Api;

use Codilar\ProductTags\Model\TagsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface TagsRepositoryInterface 
{
    public function save(TagsInterface $page);

    public function getById($id);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(TagsInterface $page);

    public function deleteById($id);
}
