<?php

namespace Amasty\MageMastery\Plugin;

class ChangeName
{
    public function beforeHelloWorld(
        $subject,
        $name
    )
    {
        $name = 'Wazzup,' . $name;

        return [$name];
    }

    public function aroundHelloWorld(
        $subject,
        callable $proceed,
        $name
    )
    {
        return $proceed($name);
    }

    public function afterHelloWorld(
        $subject,
        $result
    )
    {
        return $result . ' How are you?';
    }

}
