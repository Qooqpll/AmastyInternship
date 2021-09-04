<?php

namespace Amasty\MageMastery\Model;

use Amasty\TaskTwo\Api\Data\NameProviderInterface;

class VasyaProvider implements NameProviderInterface
{

    public function getName(): string
    {
        return 'Vasya';
    }

}
