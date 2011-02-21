<?php
namespace Shop\SettingsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SettingsBundle extends Bundle{
    /**
     * {@inheritdoc}
     */
    public function getNamespace() {
        return __NAMESPACE__;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath() {
        return strtr(__DIR__, '\\', '/');
    }
}