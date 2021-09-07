<?php

namespace Amasty\MageMastery\Plugin;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Event\ManagerInterface as EventManager;

class addCartPlugin
{

    /**
     * @var CheckoutSession
     */
        private $session;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var EventManager
     */
    private $eventManager;

    public function __construct(
        EventManager $eventManager,
        ProductRepositoryInterface $productRepository,
        CheckoutSession $session
    )
    {
        $this->eventManager = $eventManager;
        $this->productRepository = $productRepository;
        $this->session = $session;
    }

    public function beforeExecute(
        $subject
    )
    {
        $quote = $this->session->getQuote();
        if (!$quote->getId()) {
            $quote->save();
        }

        $params = $subject->getRequest()->getParams();

        if(!isset($params['product']) && isset($params['sku']) && isset($params['qty'])) {
            $sku = $params['sku'];
            $qty = $params['qty'];
            $product = $this->productRepository->get($sku);
            $quote->addProduct($product, $qty);
            $quote->save();

            $this->eventManager->dispatch(
                'amasty_magemastery_sku',
                ['promo_sku', $sku],
            );
        }




    }

   /* public function after_initProduct(
        $subject
    )
    {
        $productId = (int)$subject->getRequest()->getParam('product');
        if ($productId) {
            $storeId = $this->_objectManager->get(
                \Magento\Store\Model\StoreManagerInterface::class
            )->getStore()->getId();
            try {
                return $this->productRepository->getById($productId, false, $storeId);
            } catch (NoSuchEntityException $e) {
                return false;
            }
        }
        return false;
    }*/





}
