<?php

namespace Amasty\TaskTwo\Model;

use Amasty\TaskTwo\Api\Data\NameProviderInterface;

class AlexeyProvider implements NameProviderInterface
{
    public function getName(): string
    {
        return 'Alexey!';
    }
}
