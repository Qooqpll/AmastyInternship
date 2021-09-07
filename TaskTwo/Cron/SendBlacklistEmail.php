<?php

namespace Amasty\TaskTwo\Cron;

use Magento\Framework\Mail\Template\FactoryInterface;
use Psr\Log\LoggerInterface;
use Amasty\TaskTwo\Model\BlacklistRepository;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Mail\Template\TransportBuilder;


class SendBlacklistEmail
{

    /**
     * @var StoreManagerInterface
     */
    private $storeManagerInterface;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;
    /**
     * @var BlacklistRepository
     */
    private $blacklistRepository;

    /**
     * @var FactoryInterface
     */
    private $templateFactory;

    /**
     * @var LoggerInterface
     */
    private $looger;

    public function __construct(
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManagerInterface,
        BlacklistRepository $blacklistRepository,
        FactoryInterface $templateFactory,
        LoggerInterface $logger
    )
    {
        $this->transportBuilder = $transportBuilder;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->blacklistRepository = $blacklistRepository;
        $this->templateFactory = $templateFactory;
        $this->logger = $logger;

    }

    public function execute()
    {
        $sku = '24-MB01';
        $blacklist = $this->blacklistRepository->getSku($sku);

        $templateId = "amasty_tasktwo_blacklist_template";
        $senderName = "Admin";
        $senderEmail = "aamstyadmin@amasty.com";
        $toEmail = "user@mail.ru";
        $templateVars = [
            'blacklist' => $blacklist,
            'blacklist_sku' => $blacklist->getSku(),
            'blacklist_qty' => $blacklist->getQty()
        ];
        $storeId = $this->storeManagerInterface->getStore()->getId();
        $from = [
            'email' => $senderEmail,
            'name'=> $senderName
        ];

        $templateOptions = [
            'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            'store' => $storeId
        ];

        /**
         * @var \Magento\Email\Model\Transport $transport
         */
        /*  $transport = $this->transportBuilder->setTemplateIdentifier($templateId, ScopeInterface::SCOPE_STORE)
              ->setTemplateOptions($templateOptions)
              ->setTemplateVars($templateVars)
              ->setFromByScope($from)
              ->addTo($toEmail)
              ->getTransport();

              $transport->sendMessage();*/

        /** @var \Magento\Framework\Mail\EmailMessage $message */
        /* $message = $transport->getMessage();
         $messageText = $message->getBodyText();*/

        $template = $this->templateFactory->get($templateId);
        $template->setVars($templateVars)
            ->setOptions($templateOptions);
        $emailBody = $template->processTemplate();

        $this->blacklistRepository->addEmailToBlacklist($sku, $emailBody);

        $this->logger->debug('Amasty TaskTwo module job ');
    }

}
