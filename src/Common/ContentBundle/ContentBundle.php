<?php

namespace Common\ContentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ContentBundle extends Bundle {
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
