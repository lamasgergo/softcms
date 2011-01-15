<?php

/**
 * appUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appUrlMatcher extends Symfony\Component\Routing\Matcher\UrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(array $context = array(), array $defaults = array())
    {
        $this->context = $context;
        $this->defaults = $defaults;
    }

    public function match($url)
    {
        $url = $this->normalizeUrl($url);

        if (preg_match('#^/$#x', $url, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\DefaultController::indexAction',)), array('_route' => 'homepage'));
        }

        if (0 === strpos($url, '/hello') && preg_match('#^/hello/(?P<name>[^/\.]+?)$#x', $url, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Application\\HelloBundle\\Controller\\HelloController::indexAction',)), array('_route' => 'hello'));
        }

        return false;
    }
}
