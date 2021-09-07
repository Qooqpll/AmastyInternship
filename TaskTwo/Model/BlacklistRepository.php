<?php

namespace Amasty\TaskTwo\Model;

use Amasty\TaskTwo\Model\Blacklist;
use Amasty\TaskTwo\Model\BlacklistFactory;
use Amasty\TaskTwo\Model\ResourceModel\Blacklist as BlacklistResource;

class BlacklistRepository
{
    /**
     * @var BlacklistFactory
     */
    private $blacklistFactory;

    /**
     * @var BlacklistResource
     */
    private $blacklistResource;

    public function __construct(
        BlacklistFactory $blacklistFactory,
        BlacklistResource $blacklistResource
    )
    {
        $this->blacklistResource = $blacklistResource;
        $this->blacklistFactory = $blacklistFactory;

    }

    public function getById(int $id)
    {
        $blacklist = $this->blacklistFactory->create();
        $this->blacklistResource->load(
            $blacklist,
            $id
        );

        return $blacklist;
    }

    public function deleteById(int $id)
    {
        $blacklist = $this->getById($id);
        $this->blacklistResource->delete($blacklist);
    }

    public function getSku($sku)
    {
        $blacklist = $this->blacklistFactory->create();
        $this->blacklistResource->load(
            $blacklist,
            $sku
        );
        return $blacklist;
    }

    public function addEmailToBlacklist($sku, $emailBody)
    {
        $blacklist = $this->getSku($sku);
        $blacklist->setData('email_body', $emailBody);
        $this->blacklistResource->save($blacklist);
    }

}
