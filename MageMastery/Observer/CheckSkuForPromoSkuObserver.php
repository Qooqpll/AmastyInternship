<?php

namespace Amasty\MageMastery\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Model\Session as CheckoutSession;


class CheckSkuForPromoSkuObserver implements ObserverInterface
{
    /**
     * @var CheckoutSession
     */
    private $productRepository;

    /**
     * @var CheckoutSession
     */
    private $session;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CheckoutSession $session,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->productRepository = $productRepository;
        $this->session = $session;
        $this->scopeConfig = $scopeConfig;
    }

    public function promoSku($sku)
    {
        $promoSku = $this->scopeConfig->getValue('magemastery_config/general/promo_sku');
        $forSku = $this->scopeConfig->getValue('magemastery_config/general/for_sku');
        $arrayForSku = explode(',', $forSku);
        foreach ($arrayForSku as $item) {
            if ($item == $sku) {
                return $promoSku;
            }
        }
    }

    public function addCart($sku, $qty = 1)
    {
        $quote = $this->session->getQuote();
        $product = $this->productRepository->get($sku);
        if($product) {
            $quote->addProduct($sku, $qty);
            $quote->save();
        }
    }

    public function execute(Observer $observer)
    {
        $sku = $observer->getData('promo_sku');
        $quote = $this->session->getQuote();
        if (!$quote->getId()) {
            $quote->save();
        }

        $promoSku = $this->promoSku($sku);
        if($promoSku) {
            $this->addCart($promoSku, 1);
        } else {
            $this->addCart($sku);
        }
    }

}
