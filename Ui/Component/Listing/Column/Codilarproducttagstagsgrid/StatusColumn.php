<?php
namespace Codilar\ProductTags\Ui\Component\Listing\Column\Codilarproducttagstagsgrid;
class StatusColumn extends \Magento\Ui\Component\Listing\Columns\Column
{
   
    public function prepareDataSource(array $dataSource)
    {
        $response[0] ='Disabled';
        $response[1] ='Approved';
        $response[2] ='Pending';


        if (isset($dataSource["data"]["items"])) {
            foreach ($dataSource["data"]["items"] as & $item) {
                $name = $this->getData("name");
                $item[$name] = $response[$item[$name]];
                
            }
        }

        return $dataSource;
    }    
    
}
