<?php

/**
 * app_devUrlGenerator
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class app_devUrlGenerator extends Symfony\Component\Routing\Generator\UrlGenerator
{
    /**
     * Constructor.
     */
    public function __construct(array $context = array(), array $defaults = array())
    {
        $this->context = $context;
        $this->defaults = $defaults;
    }

    public function generate($name, array $parameters, $absolute = false)
    {
        static $routes = array(
            'homepage' => true,
            'hello' => true,
            'user_edit' => true,
            'user_detail' => true,
            'register' => true,
            'my' => true,
            '_security_check' => true,
            '_security_login' => true,
            '_profiler_search' => true,
            '_profiler_purge' => true,
            '_profiler_import' => true,
            '_profiler_export' => true,
            '_profiler_search_results' => true,
            '_profiler' => true,
            '_profiler_panel' => true,
            'test' => true,
        );

        if (!isset($routes[$name])) {
            throw new \InvalidArgumentException(sprintf('Route "%s" does not exist.', $name));
        }

        list($variables, $defaults, $requirements, $tokens) = $this->{'get'.$name.'RouteInfo'}();

        return $this->doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $absolute);
    }

    protected function gethomepageRouteInfo()
    {
        return array(array (), array_merge($this->defaults, array (  '_controller' => 'Application\\HomepageBundle\\Controller\\HomeController::indexAction',)), array (), array (  0 =>   array (    0 => 'text',    1 => '/',    2 => '',    3 => NULL,  ),));
    }

    protected function gethelloRouteInfo()
    {
        return array(array (  'name' => ':name',), array_merge($this->defaults, array (  '_controller' => 'HelloBundle:Hello:index',)), array (), array (  0 =>   array (    0 => 'variable',    1 => '/',    2 => ':name',    3 => 'name',  ),  1 =>   array (    0 => 'text',    1 => '/',    2 => 'hello',    3 => NULL,  ),));
    }

    protected function getuser_editRouteInfo()
    {
        return array(array (  'id' => ':id',), array_merge($this->defaults, array (  '_controller' => 'Application\\UserBundle\\Controller\\UserController::editAction',)), array (), array (  0 =>   array (    0 => 'variable',    1 => '/',    2 => ':id',    3 => 'id',  ),  1 =>   array (    0 => 'text',    1 => '/',    2 => 'edit',    3 => NULL,  ),  2 =>   array (    0 => 'text',    1 => '/',    2 => 'user',    3 => NULL,  ),));
    }

    protected function getuser_detailRouteInfo()
    {
        return array(array (  'id' => ':id',), array_merge($this->defaults, array (  '_controller' => 'Application\\UserBundle\\Controller\\UserController::detailAction',)), array (), array (  0 =>   array (    0 => 'variable',    1 => '/',    2 => ':id',    3 => 'id',  ),  1 =>   array (    0 => 'text',    1 => '/',    2 => 'show',    3 => NULL,  ),  2 =>   array (    0 => 'text',    1 => '/',    2 => 'user',    3 => NULL,  ),));
    }

    protected function getregisterRouteInfo()
    {
        return array(array (), array_merge($this->defaults, array (  '_controller' => 'Application\\UserBundle\\Controller\\UserController::registerAction',)), array (), array (  0 =>   array (    0 => 'text',    1 => '/',    2 => 'register',    3 => NULL,  ),  1 =>   array (    0 => 'text',    1 => '/',    2 => 'user',    3 => NULL,  ),));
    }

    protected function getmyRouteInfo()
    {
        return array(array (), array_merge($this->defaults, array (  '_controller' => 'Application\\UserBundle\\Controller\\UserController::indexAction',)), array (), array (  0 =>   array (    0 => 'text',    1 => '/',    2 => 'my',    3 => NULL,  ),));
    }

    protected function get_security_checkRouteInfo()
    {
        return array(array (), array_merge($this->defaults, array ()), array (), array (  0 =>   array (    0 => 'text',    1 => '/',    2 => 'login_check',    3 => NULL,  ),));
    }

    protected function get_security_loginRouteInfo()
    {
        return array(array (), array_merge($this->defaults, array (  '_controller' => 'Application\\UserBundle\\Controller\\UserController::loginAction',)), array (), array (  0 =>   array (    0 => 'text',    1 => '/',    2 => 'login',    3 => NULL,  ),));
    }

    protected function get_profiler_searchRouteInfo()
    {
        return array(array (), array_merge($this->defaults, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::searchAction',)), array (), array (  0 =>   array (    0 => 'text',    1 => '/',    2 => 'search',    3 => NULL,  ),  1 =>   array (    0 => 'text',    1 => '/',    2 => '_profiler',    3 => NULL,  ),));
    }

    protected function get_profiler_purgeRouteInfo()
    {
        return array(array (), array_merge($this->defaults, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::purgeAction',)), array (), array (  0 =>   array (    0 => 'text',    1 => '/',    2 => 'purge',    3 => NULL,  ),  1 =>   array (    0 => 'text',    1 => '/',    2 => '_profiler',    3 => NULL,  ),));
    }

    protected function get_profiler_importRouteInfo()
    {
        return array(array (), array_merge($this->defaults, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::importAction',)), array (), array (  0 =>   array (    0 => 'text',    1 => '/',    2 => 'import',    3 => NULL,  ),  1 =>   array (    0 => 'text',    1 => '/',    2 => '_profiler',    3 => NULL,  ),));
    }

    protected function get_profiler_exportRouteInfo()
    {
        return array(array (  'token' => ':token',), array_merge($this->defaults, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::exportAction',)), array (), array (  0 =>   array (    0 => 'text',    1 => '.',    2 => 'txt',    3 => NULL,  ),  1 =>   array (    0 => 'variable',    1 => '/',    2 => ':token',    3 => 'token',  ),  2 =>   array (    0 => 'text',    1 => '/',    2 => 'export',    3 => NULL,  ),  3 =>   array (    0 => 'text',    1 => '/',    2 => '_profiler',    3 => NULL,  ),));
    }

    protected function get_profiler_search_resultsRouteInfo()
    {
        return array(array (  'token' => ':token',), array_merge($this->defaults, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::searchResultsAction',)), array (), array (  0 =>   array (    0 => 'text',    1 => '/',    2 => 'results',    3 => NULL,  ),  1 =>   array (    0 => 'text',    1 => '/',    2 => 'search',    3 => NULL,  ),  2 =>   array (    0 => 'variable',    1 => '/',    2 => ':token',    3 => 'token',  ),  3 =>   array (    0 => 'text',    1 => '/',    2 => '_profiler',    3 => NULL,  ),));
    }

    protected function get_profilerRouteInfo()
    {
        return array(array (  'token' => ':token',), array_merge($this->defaults, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::panelAction',)), array (), array (  0 =>   array (    0 => 'variable',    1 => '/',    2 => ':token',    3 => 'token',  ),  1 =>   array (    0 => 'text',    1 => '/',    2 => '_profiler',    3 => NULL,  ),));
    }

    protected function get_profiler_panelRouteInfo()
    {
        return array(array (  'token' => ':token',  'panel' => ':panel',), array_merge($this->defaults, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::panelAction',)), array (), array (  0 =>   array (    0 => 'variable',    1 => '/',    2 => ':panel',    3 => 'panel',  ),  1 =>   array (    0 => 'variable',    1 => '/',    2 => ':token',    3 => 'token',  ),  2 =>   array (    0 => 'text',    1 => '/',    2 => '_profiler',    3 => NULL,  ),));
    }

    protected function gettestRouteInfo()
    {
        return array(array (), array_merge($this->defaults, array (  '_controller' => 'TestBundle:Test:register',)), array (), array (  0 =>   array (    0 => 'text',    1 => '/',    2 => 'register',    3 => NULL,  ),  1 =>   array (    0 => 'text',    1 => '/',    2 => 'test',    3 => NULL,  ),));
    }
}
