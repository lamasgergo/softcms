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
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Application\\HomepageBundle\\Controller\\HomeController::indexAction',)), array('_route' => 'homepage'));
        }

        if (0 === strpos($url, '/hello') && preg_match('#^/hello/(?P<name>[^/\.]+?)$#x', $url, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'HelloBundle:Hello:index',)), array('_route' => 'hello'));
        }

        if (0 === strpos($url, '/user/edit') && preg_match('#^/user/edit/(?P<id>[^/\.]+?)$#x', $url, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Application\\UserBundle\\Controller\\UserController::editAction',)), array('_route' => 'user_edit'));
        }

        if (0 === strpos($url, '/user/show') && preg_match('#^/user/show/(?P<id>[^/\.]+?)$#x', $url, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Application\\UserBundle\\Controller\\UserController::detailAction',)), array('_route' => 'user_detail'));
        }

        if (0 === strpos($url, '/user/register') && preg_match('#^/user/register$#x', $url, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Application\\UserBundle\\Controller\\UserController::registerAction',)), array('_route' => 'register'));
        }

        if (0 === strpos($url, '/my') && preg_match('#^/my$#x', $url, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Application\\UserBundle\\Controller\\UserController::indexAction',)), array('_route' => 'my'));
        }

        if (0 === strpos($url, '/login_check') && preg_match('#^/login_check$#x', $url, $matches)) {
            return array_merge($this->mergeDefaults($matches, array ()), array('_route' => '_security_check'));
        }

        if (0 === strpos($url, '/login') && preg_match('#^/login$#x', $url, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Application\\UserBundle\\Controller\\UserController::loginAction',)), array('_route' => '_security_login'));
        }

        if (0 === strpos($url, '/_profiler/search') && preg_match('#^/_profiler/search$#x', $url, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::searchAction',)), array('_route' => '_profiler_search'));
        }

        if (0 === strpos($url, '/_profiler/purge') && preg_match('#^/_profiler/purge$#x', $url, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::purgeAction',)), array('_route' => '_profiler_purge'));
        }

        if (0 === strpos($url, '/_profiler/import') && preg_match('#^/_profiler/import$#x', $url, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::importAction',)), array('_route' => '_profiler_import'));
        }

        if (0 === strpos($url, '/_profiler/export') && preg_match('#^/_profiler/export/(?P<token>[^/\.]+?)\.txt$#x', $url, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::exportAction',)), array('_route' => '_profiler_export'));
        }

        if (0 === strpos($url, '/_profiler') && preg_match('#^/_profiler/(?P<token>[^/\.]+?)/search/results$#x', $url, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::searchResultsAction',)), array('_route' => '_profiler_search_results'));
        }

        if (0 === strpos($url, '/_profiler') && preg_match('#^/_profiler/(?P<token>[^/\.]+?)$#x', $url, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::panelAction',)), array('_route' => '_profiler'));
        }

        if (0 === strpos($url, '/_profiler') && preg_match('#^/_profiler/(?P<token>[^/\.]+?)/(?P<panel>[^/\.]+?)$#x', $url, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::panelAction',)), array('_route' => '_profiler_panel'));
        }

        if (0 === strpos($url, '/test/register') && preg_match('#^/test/register$#x', $url, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'TestBundle:Test:register',)), array('_route' => 'test'));
        }

        return false;
    }
}
