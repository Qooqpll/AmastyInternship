<?php

namespace Amasty\TaskTwo\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;


class Autocomplete extends Action
{
    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @var ProductCollectionFactory
     */
    private $productCollection;

    public function __construct(
        Context $context,
        ProductCollectionFactory $productCollection,
        JsonFactory $jsonFactory
    )
    {
        $this->productCollection = $productCollection;
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $response = $this->getRequest()->getParam('q');
        //die($response);
        $dataProduct = [];
        $productCollection = $this->productCollection->create();
        $productCollection->addAttributeToFilter('sku', array('like' => '%'."$response".'%'));

        foreach ($productCollection as $product) {
            $dataProduct [] = $product->getSku();
        }


        $json = $this->jsonFactory->create();
        $json->setData($dataProduct);
        return $json;
    }

}
