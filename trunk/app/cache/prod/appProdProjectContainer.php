<?php
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\TaggedContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;
class appProdProjectContainer extends Container implements TaggedContainerInterface {
    public function __construct() {
        parent::__construct(new FrozenParameterBag($this->getDefaultParameters())); }
    protected function getControllerNameConverterService() {
        return $this->services['controller_name_converter'] = new \Symfony\Bundle\FrameworkBundle\Controller\ControllerNameConverter($this->get('kernel'), $this->get('logger', ContainerInterface::NULL_ON_INVALID_REFERENCE)); }
    protected function getControllerResolverService() {
        return $this->services['controller_resolver'] = new \Symfony\Bundle\FrameworkBundle\Controller\ControllerResolver($this, $this->get('controller_name_converter'), $this->get('logger', ContainerInterface::NULL_ON_INVALID_REFERENCE)); }
    protected function getRequestListenerService() {
        return $this->services['request_listener'] = new \Symfony\Bundle\FrameworkBundle\RequestListener($this, $this->get('router'), $this->get('logger', ContainerInterface::NULL_ON_INVALID_REFERENCE)); }
    protected function getEsiService() {
        return $this->services['esi'] = new \Symfony\Component\HttpKernel\Cache\Esi(); }
    protected function getEsiListenerService() {
        return $this->services['esi_listener'] = new \Symfony\Component\HttpKernel\Cache\EsiListener($this->get('esi', ContainerInterface::NULL_ON_INVALID_REFERENCE)); }
    protected function getResponseListenerService() {
        return $this->services['response_listener'] = new \Symfony\Component\HttpKernel\ResponseListener(); }
    protected function getExceptionListenerService() {
        return $this->services['exception_listener'] = new \Symfony\Component\HttpKernel\Debug\ExceptionListener('Symfony\\Bundle\\FrameworkBundle\\Controller\\ExceptionController::exceptionAction', $this->get('logger', ContainerInterface::NULL_ON_INVALID_REFERENCE)); }
    protected function getEventDispatcherService() {
        $this->services['event_dispatcher'] = $instance = new \Symfony\Bundle\FrameworkBundle\EventDispatcher();
        $instance->setContainer($this);
        return $instance; }
    protected function getErrorHandlerService() {
        $this->services['error_handler'] = $instance = new \Symfony\Component\HttpKernel\Debug\ErrorHandler(NULL);
        $instance->register();
        return $instance; }
    protected function getHttpKernelService() {
        return $this->services['http_kernel'] = new \Symfony\Component\HttpKernel\HttpKernel($this, $this->get('event_dispatcher'), $this->get('controller_resolver')); }
    protected function getRequestService() {
        return $this->services['request'] = new \WillNeverBeCalled(); }
    protected function getResponseService() {
        return new \Symfony\Component\HttpFoundation\Response(); }
    protected function getRouting_ResolverService() {
        return $this->services['routing.resolver'] = new \Symfony\Bundle\FrameworkBundle\Routing\LoaderResolver($this); }
    protected function getRouting_Loader_XmlService() {
        return $this->services['routing.loader.xml'] = new \Symfony\Component\Routing\Loader\XmlFileLoader(array('Application' => 'C:\\www\\test\\sandbox\\app/../src/Application', 'Bundle' => 'C:\\www\\test\\sandbox\\app/../src/Bundle', 'Symfony\\Bundle' => 'C:\\www\\test\\sandbox\\app/../src/vendor/symfony/src/Symfony/Bundle')); }
    protected function getRouting_Loader_YmlService() {
        return $this->services['routing.loader.yml'] = new \Symfony\Component\Routing\Loader\YamlFileLoader(array('Application' => 'C:\\www\\test\\sandbox\\app/../src/Application', 'Bundle' => 'C:\\www\\test\\sandbox\\app/../src/Bundle', 'Symfony\\Bundle' => 'C:\\www\\test\\sandbox\\app/../src/vendor/symfony/src/Symfony/Bundle')); }
    protected function getRouting_Loader_PhpService() {
        return $this->services['routing.loader.php'] = new \Symfony\Component\Routing\Loader\PhpFileLoader(array('Application' => 'C:\\www\\test\\sandbox\\app/../src/Application', 'Bundle' => 'C:\\www\\test\\sandbox\\app/../src/Bundle', 'Symfony\\Bundle' => 'C:\\www\\test\\sandbox\\app/../src/vendor/symfony/src/Symfony/Bundle')); }
    protected function getRouting_Loader_RealService() {
        return $this->services['routing.loader.real'] = new \Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader($this->get('controller_name_converter'), $this->get('logger', ContainerInterface::NULL_ON_INVALID_REFERENCE), $this->get('routing.resolver')); }
    protected function getRouting_LoaderService() {
        return $this->services['routing.loader'] = new \Symfony\Bundle\FrameworkBundle\Routing\LazyLoader($this, 'routing.loader.real'); }
    protected function getRouterService() {
        return $this->services['router'] = new \Symfony\Component\Routing\Router($this->get('routing.loader'), 'C:\\www\\test\\sandbox\\app/config/routing.yml', array('cache_dir' => 'C:\\www\\test\\sandbox\\app/cache/prod', 'debug' => false, 'generator_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator', 'generator_base_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator', 'generator_dumper_class' => 'Symfony\\Component\\Routing\\Generator\\Dumper\\PhpGeneratorDumper', 'generator_cache_class' => 'app'.'_'.'prod'.'UrlGenerator', 'matcher_class' => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher', 'matcher_base_class' => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher', 'matcher_dumper_class' => 'Symfony\\Component\\Routing\\Matcher\\Dumper\\PhpMatcherDumper', 'matcher_cache_class' => 'app'.'UrlMatcher')); }
    protected function getValidatorService() {
        return $this->services['validator'] = new \Symfony\Component\Validator\Validator($this->get('validator.mapping.class_metadata_factory'), $this->get('validator.validator_factory')); }
    protected function getValidator_Mapping_ClassMetadataFactoryService() {
        return $this->services['validator.mapping.class_metadata_factory'] = new \Symfony\Component\Validator\Mapping\ClassMetadataFactory($this->get('validator.mapping.loader.loader_chain')); }
    protected function getValidator_ValidatorFactoryService() {
        $this->services['validator.validator_factory'] = $instance = new \Symfony\Bundle\FrameworkBundle\Validator\ConstraintValidatorFactory($this);
        $instance->loadTaggedServiceIds($this);
        return $instance; }
    protected function getValidator_Mapping_Loader_LoaderChainService() {
        return $this->services['validator.mapping.loader.loader_chain'] = new \Symfony\Component\Validator\Mapping\Loader\LoaderChain(array(0 => $this->get('validator.mapping.loader.annotation_loader'), 1 => $this->get('validator.mapping.loader.static_method_loader'), 2 => $this->get('validator.mapping.loader.xml_files_loader'), 3 => $this->get('validator.mapping.loader.yaml_files_loader'))); }
    protected function getValidator_Mapping_Loader_StaticMethodLoaderService() {
        return $this->services['validator.mapping.loader.static_method_loader'] = new \Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader('loadValidatorMetadata'); }
    protected function getValidator_Mapping_Loader_XmlFilesLoaderService() {
        return $this->services['validator.mapping.loader.xml_files_loader'] = new \Symfony\Component\Validator\Mapping\Loader\XmlFilesLoader(array(0 => 'C:\\www\\test\\sandbox\\src\\vendor\\symfony\\src\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection/../../../Component/Form/Resources/config/validation.xml')); }
    protected function getValidator_Mapping_Loader_YamlFilesLoaderService() {
        return $this->services['validator.mapping.loader.yaml_files_loader'] = new \Symfony\Component\Validator\Mapping\Loader\YamlFilesLoader(array()); }
    protected function getValidator_Mapping_Loader_AnnotationLoaderService() {
        return $this->services['validator.mapping.loader.annotation_loader'] = new \Symfony\Component\Validator\Mapping\Loader\AnnotationLoader(array('validation' => 'Symfony\\Component\\Validator\\Constraints\\')); }
    protected function getTemplating_EngineService() {
        $this->services['templating.engine'] = $instance = new \Symfony\Bundle\FrameworkBundle\Templating\Engine($this, $this->get('templating.loader.filesystem'));
        $instance->setCharset('UTF-8');
        return $instance; }
    protected function getTemplating_Loader_FilesystemService() {
        $this->services['templating.loader.filesystem'] = $instance = new \Symfony\Component\Templating\Loader\FilesystemLoader(array(0 => 'C:\\www\\test\\sandbox\\app/views/%bundle%/%controller%/%name%%format%.%renderer%', 1 => 'C:\\www\\test\\sandbox\\app/../src/Application/%bundle%/Resources/views/%controller%/%name%%format%.%renderer%', 2 => 'C:\\www\\test\\sandbox\\app/../src/Bundle/%bundle%/Resources/views/%controller%/%name%%format%.%renderer%', 3 => 'C:\\www\\test\\sandbox\\app/../src/vendor/symfony/src/Symfony/Bundle/%bundle%/Resources/views/%controller%/%name%%format%.%renderer%'));
        if ($this->has('templating.debugger')) {
            $instance->setDebugger($this->get('templating.debugger', ContainerInterface::NULL_ON_INVALID_REFERENCE)); }
        return $instance; }
    protected function getTemplating_Loader_CacheService() {
        $this->services['templating.loader.cache'] = $instance = new \Symfony\Component\Templating\Loader\CacheLoader($this->get('templating.loader.wrapped'), NULL);
        if ($this->has('templating.debugger')) {
            $instance->setDebugger($this->get('templating.debugger', ContainerInterface::NULL_ON_INVALID_REFERENCE)); }
        return $instance; }
    protected function getTemplating_Loader_ChainService() {
        $this->services['templating.loader.chain'] = $instance = new \Symfony\Component\Templating\Loader\ChainLoader();
        if ($this->has('templating.debugger')) {
            $instance->setDebugger($this->get('templating.debugger', ContainerInterface::NULL_ON_INVALID_REFERENCE)); }
        return $instance; }
    protected function getTemplating_Helper_JavascriptsService() {
        return $this->services['templating.helper.javascripts'] = new \Symfony\Component\Templating\Helper\JavascriptsHelper($this->get('templating.helper.assets')); }
    protected function getTemplating_Helper_StylesheetsService() {
        return $this->services['templating.helper.stylesheets'] = new \Symfony\Component\Templating\Helper\StylesheetsHelper($this->get('templating.helper.assets')); }
    protected function getTemplating_Helper_SlotsService() {
        return $this->services['templating.helper.slots'] = new \Symfony\Component\Templating\Helper\SlotsHelper(); }
    protected function getTemplating_Helper_AssetsService() {
        return $this->services['templating.helper.assets'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\AssetsHelper($this->get('request'), array(), NULL); }
    protected function getTemplating_Helper_RequestService() {
        return $this->services['templating.helper.request'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\RequestHelper($this->get('request')); }
    protected function getTemplating_Helper_SessionService() {
        return $this->services['templating.helper.session'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\SessionHelper($this->get('request')); }
    protected function getTemplating_Helper_RouterService() {
        return $this->services['templating.helper.router'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\RouterHelper($this->get('router')); }
    protected function getTemplating_Helper_ActionsService() {
        return $this->services['templating.helper.actions'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\ActionsHelper($this->get('controller_resolver')); }
    protected function getTemplating_Helper_CodeService() {
        return $this->services['templating.helper.code'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\CodeHelper(NULL, 'C:\\www\\test\\sandbox\\app'); }
    protected function getTemplating_Helper_TranslatorService() {
        return $this->services['templating.helper.translator'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\TranslatorHelper($this->get('translator')); }
    protected function getTemplating_Helper_SecurityService() {
        return $this->services['templating.helper.security'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\SecurityHelper($this->get('security.context', ContainerInterface::NULL_ON_INVALID_REFERENCE)); }
    protected function getTemplating_Helper_FormService() {
        return $this->services['templating.helper.form'] = new \Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper($this->get('templating.engine')); }
    protected function getSessionService() {
        $this->services['session'] = $instance = new \Symfony\Component\HttpFoundation\Session($this->get('session.storage.native'), array('default_locale' => 'en'));
        $instance->start();
        return $instance; }
    protected function getSession_Storage_NativeService() {
        return $this->services['session.storage.native'] = new \Symfony\Component\HttpFoundation\SessionStorage\NativeSessionStorage(array('lifetime' => 3600)); }
    protected function getSession_Storage_PdoService() {
        return $this->services['session.storage.pdo'] = new \Symfony\Component\HttpFoundation\SessionStorage\PdoSessionStorage($this->get('pdo_connection'), array()); }
    protected function getTranslator_RealService() {
        $this->services['translator.real'] = $instance = new \Symfony\Bundle\FrameworkBundle\Translation\Translator($this, $this->get('translator.selector'), array('cache_dir' => 'C:\\www\\test\\sandbox\\app/cache/prod'.'/translations', 'debug' => false), $this->get('session', ContainerInterface::NULL_ON_INVALID_REFERENCE));
        $instance->setFallbackLocale('en');
        return $instance; }
    protected function getTranslatorService() {
        $this->services['translator'] = $instance = new \Symfony\Bundle\FrameworkBundle\Translation\Translator($this, $this->get('translator.selector'), array('cache_dir' => 'C:\\www\\test\\sandbox\\app/cache/prod'.'/translations', 'debug' => false), $this->get('session', ContainerInterface::NULL_ON_INVALID_REFERENCE));
        $instance->setFallbackLocale('en');
        return $instance; }
    protected function getTranslator_SelectorService() {
        return $this->services['translator.selector'] = new \Symfony\Component\Translation\MessageSelector(); }
    protected function getTranslation_Loader_PhpService() {
        return $this->services['translation.loader.php'] = new \Symfony\Component\Translation\Loader\PhpFileLoader(); }
    protected function getTranslation_Loader_YmlService() {
        return $this->services['translation.loader.yml'] = new \Symfony\Component\Translation\Loader\YamlFileLoader(); }
    protected function getTranslation_Loader_XliffService() {
        return $this->services['translation.loader.xliff'] = new \Symfony\Component\Translation\Loader\XliffFileLoader(); }
    protected function getTwigService() {
        return $this->services['twig'] = new \Symfony\Bundle\TwigBundle\Environment($this, $this->get('twig.loader'), array('charset' => 'UTF-8', 'debug' => false, 'cache' => 'C:\\www\\test\\sandbox\\app/cache/prod/twig', 'strict_variables' => false)); }
    protected function getTwig_LoaderService() {
        $this->services['twig.loader'] = $instance = new \Symfony\Bundle\TwigBundle\Loader\Loader();
        $instance->setEngine($this->get('templating.engine'));
        return $instance; }
    protected function getTwig_RendererService() {
        return $this->services['twig.renderer'] = new \Symfony\Bundle\TwigBundle\Renderer\Renderer($this->get('twig')); }
    protected function getTwig_Extension_EscaperService() {
        return $this->services['twig.extension.escaper'] = new \Twig_Extension_Escaper(); }
    protected function getTwig_Extension_OptimizerService() {
        return $this->services['twig.extension.optimizer'] = new \Twig_Extension_Optimizer(); }
    protected function getTwig_Extension_TransService() {
        return $this->services['twig.extension.trans'] = new \Symfony\Bundle\TwigBundle\Extension\TransExtension($this->get('translator')); }
    protected function getTwig_Extension_HelpersService() {
        return $this->services['twig.extension.helpers'] = new \Symfony\Bundle\TwigBundle\Extension\TemplatingExtension($this); }
    protected function getTwig_Extension_FormService() {
        return $this->services['twig.extension.form'] = new \Symfony\Bundle\TwigBundle\Extension\FormExtension(array()); }
    protected function getTwig_Security_FormService() {
        return $this->services['twig.security.form'] = new \Symfony\Bundle\TwigBundle\Extension\SecurityExtension($this->get('security.context', ContainerInterface::NULL_ON_INVALID_REFERENCE)); }
    protected function getTemplating_LoaderService() {
        return $this->get('templating.loader.filesystem'); }
    protected function getTemplatingService() {
        return $this->get('templating.engine'); }
    protected function getSession_StorageService() {
        return $this->get('session.storage.native'); }
    public function findTaggedServiceIds($name) {
        static $tags = array(
            'kernel.listener' => array(
                'request_listener' => array(
                    0 => array(
                    ),
                ),
                'esi_listener' => array(
                    0 => array(
                    ),
                ),
                'response_listener' => array(
                    0 => array(
                    ),
                ),
                'exception_listener' => array(
                    0 => array(
                        'priority' => 128,
                    ),
                ),
            ),
            'routing.loader' => array(
                'routing.loader.xml' => array(
                    0 => array(
                    ),
                ),
                'routing.loader.yml' => array(
                    0 => array(
                    ),
                ),
                'routing.loader.php' => array(
                    0 => array(
                    ),
                ),
            ),
            'templating.helper' => array(
                'templating.helper.javascripts' => array(
                    0 => array(
                        'alias' => 'javascripts',
                    ),
                ),
                'templating.helper.stylesheets' => array(
                    0 => array(
                        'alias' => 'stylesheets',
                    ),
                ),
                'templating.helper.slots' => array(
                    0 => array(
                        'alias' => 'slots',
                    ),
                ),
                'templating.helper.assets' => array(
                    0 => array(
                        'alias' => 'assets',
                    ),
                ),
                'templating.helper.request' => array(
                    0 => array(
                        'alias' => 'request',
                    ),
                ),
                'templating.helper.session' => array(
                    0 => array(
                        'alias' => 'session',
                    ),
                ),
                'templating.helper.router' => array(
                    0 => array(
                        'alias' => 'router',
                    ),
                ),
                'templating.helper.actions' => array(
                    0 => array(
                        'alias' => 'actions',
                    ),
                ),
                'templating.helper.code' => array(
                    0 => array(
                        'alias' => 'code',
                    ),
                ),
                'templating.helper.translator' => array(
                    0 => array(
                        'alias' => 'translator',
                    ),
                ),
                'templating.helper.security' => array(
                    0 => array(
                        'alias' => 'security',
                    ),
                ),
                'templating.helper.form' => array(
                    0 => array(
                        'alias' => 'form',
                    ),
                ),
            ),
            'translation.loader' => array(
                'translation.loader.php' => array(
                    0 => array(
                        'alias' => 'php',
                    ),
                ),
                'translation.loader.yml' => array(
                    0 => array(
                        'alias' => 'yml',
                    ),
                ),
                'translation.loader.xliff' => array(
                    0 => array(
                        'alias' => 'xliff',
                    ),
                ),
            ),
            'templating.renderer' => array(
                'twig.renderer' => array(
                    0 => array(
                        'alias' => 'twig',
                    ),
                ),
            ),
            'twig.extension' => array(
                'twig.extension.escaper' => array(
                    0 => array(
                    ),
                ),
                'twig.extension.optimizer' => array(
                    0 => array(
                    ),
                ),
                'twig.extension.trans' => array(
                    0 => array(
                    ),
                ),
                'twig.extension.helpers' => array(
                    0 => array(
                    ),
                ),
                'twig.extension.form' => array(
                    0 => array(
                    ),
                ),
                'twig.security.form' => array(
                    0 => array(
                    ),
                ),
            ),
        );
        return isset($tags[$name]) ? $tags[$name] : array(); }
    protected function getDefaultParameters() {
        return array(
            'kernel.root_dir' => 'C:\\www\\test\\sandbox\\app',
            'kernel.environment' => 'prod',
            'kernel.debug' => false,
            'kernel.name' => 'app',
            'kernel.cache_dir' => 'C:\\www\\test\\sandbox\\app/cache/prod',
            'kernel.logs_dir' => 'C:\\www\\test\\sandbox\\app/logs',
            'kernel.bundle_dirs' => array(
                'Application' => 'C:\\www\\test\\sandbox\\app/../src/Application',
                'Bundle' => 'C:\\www\\test\\sandbox\\app/../src/Bundle',
                'Symfony\\Bundle' => 'C:\\www\\test\\sandbox\\app/../src/vendor/symfony/src/Symfony/Bundle',
            ),
            'kernel.bundles' => array(
                0 => 'Symfony\\Bundle\\FrameworkBundle\\FrameworkBundle',
                1 => 'Symfony\\Bundle\\TwigBundle\\TwigBundle',
                2 => 'Symfony\\Bundle\\ZendBundle\\ZendBundle',
                3 => 'Symfony\\Bundle\\SwiftmailerBundle\\SwiftmailerBundle',
                4 => 'Symfony\\Bundle\\DoctrineBundle\\DoctrineBundle',
                5 => 'Application\\HelloBundle\\HelloBundle',
            ),
            'kernel.charset' => 'UTF-8',
            'request_listener.class' => 'Symfony\\Bundle\\FrameworkBundle\\RequestListener',
            'controller_resolver.class' => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\ControllerResolver',
            'controller_name_converter.class' => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\ControllerNameConverter',
            'response_listener.class' => 'Symfony\\Component\\HttpKernel\\ResponseListener',
            'exception_listener.class' => 'Symfony\\Component\\HttpKernel\\Debug\\ExceptionListener',
            'exception_listener.controller' => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\ExceptionController::exceptionAction',
            'esi.class' => 'Symfony\\Component\\HttpKernel\\Cache\\Esi',
            'esi_listener.class' => 'Symfony\\Component\\HttpKernel\\Cache\\EsiListener',
            'csrf_secret' => 'xxxxxxxxxx',
            'event_dispatcher.class' => 'Symfony\\Bundle\\FrameworkBundle\\EventDispatcher',
            'http_kernel.class' => 'Symfony\\Component\\HttpKernel\\HttpKernel',
            'response.class' => 'Symfony\\Component\\HttpFoundation\\Response',
            'error_handler.class' => 'Symfony\\Component\\HttpKernel\\Debug\\ErrorHandler',
            'error_handler.level' => NULL,
            'router.class' => 'Symfony\\Component\\Routing\\Router',
            'routing.loader.class' => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\DelegatingLoader',
            'routing.resolver.class' => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\LoaderResolver',
            'routing.loader.xml.class' => 'Symfony\\Component\\Routing\\Loader\\XmlFileLoader',
            'routing.loader.yml.class' => 'Symfony\\Component\\Routing\\Loader\\YamlFileLoader',
            'routing.loader.php.class' => 'Symfony\\Component\\Routing\\Loader\\PhpFileLoader',
            'router.options.generator_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator',
            'router.options.generator_base_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator',
            'router.options.generator_dumper_class' => 'Symfony\\Component\\Routing\\Generator\\Dumper\\PhpGeneratorDumper',
            'router.options.matcher_class' => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher',
            'router.options.matcher_base_class' => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher',
            'router.options.matcher_dumper_class' => 'Symfony\\Component\\Routing\\Matcher\\Dumper\\PhpMatcherDumper',
            'routing.resource' => 'C:\\www\\test\\sandbox\\app/config/routing.yml',
            'kernel.compiled_classes' => array(
                0 => 'Symfony\\Component\\Routing\\RouterInterface',
                1 => 'Symfony\\Component\\Routing\\Router',
                2 => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcherInterface',
                3 => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher',
                4 => 'Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface',
                5 => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator',
                6 => 'Symfony\\Component\\Routing\\Loader\\LoaderInterface',
                7 => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\LazyLoader',
                8 => 'Symfony\\Component\\Templating\\Loader\\LoaderInterface',
                9 => 'Symfony\\Component\\Templating\\Loader\\Loader',
                10 => 'Symfony\\Component\\Templating\\Loader\\FilesystemLoader',
                11 => 'Symfony\\Component\\Templating\\Engine',
                12 => 'Symfony\\Component\\Templating\\Renderer\\RendererInterface',
                13 => 'Symfony\\Component\\Templating\\Renderer\\Renderer',
                14 => 'Symfony\\Component\\Templating\\Renderer\\PhpRenderer',
                15 => 'Symfony\\Component\\Templating\\Storage\\Storage',
                16 => 'Symfony\\Component\\Templating\\Storage\\FileStorage',
                17 => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Engine',
                18 => 'Symfony\\Component\\Templating\\Helper\\Helper',
                19 => 'Symfony\\Component\\Templating\\Helper\\SlotsHelper',
                20 => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\ActionsHelper',
                21 => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\RouterHelper',
                22 => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\RouterHelper',
                23 => 'Symfony\\Component\\HttpFoundation\\Session',
                24 => 'Symfony\\Component\\HttpFoundation\\SessionStorage\\SessionStorageInterface',
                25 => 'Symfony\\Component\\HttpFoundation\\ParameterBag',
                26 => 'Symfony\\Component\\HttpFoundation\\HeaderBag',
                27 => 'Symfony\\Component\\HttpFoundation\\Request',
                28 => 'Symfony\\Component\\HttpFoundation\\Response',
                29 => 'Symfony\\Component\\HttpFoundation\\ResponseHeaderBag',
                30 => 'Symfony\\Component\\HttpKernel\\BaseHttpKernel',
                31 => 'Symfony\\Component\\HttpKernel\\HttpKernel',
                32 => 'Symfony\\Component\\HttpKernel\\ResponseListener',
                33 => 'Symfony\\Component\\HttpKernel\\Controller\\ControllerResolver',
                34 => 'Symfony\\Component\\HttpKernel\\Controller\\ControllerResolverInterface',
                35 => 'Symfony\\Bundle\\FrameworkBundle\\RequestListener',
                36 => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\ControllerNameConverter',
                37 => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\ControllerResolver',
                38 => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\Controller',
                39 => 'Symfony\\Component\\EventDispatcher\\Event',
                40 => 'Symfony\\Component\\EventDispatcher\\EventDispatcher',
                41 => 'Symfony\\Bundle\\FrameworkBundle\\EventDispatcher',
                42 => 'Symfony\\Component\\Form\\FormConfiguration',
            ),
            'validator.class' => 'Symfony\\Component\\Validator\\Validator',
            'validator.mapping.class_metadata_factory.class' => 'Symfony\\Component\\Validator\\Mapping\\ClassMetadataFactory',
            'validator.mapping.loader.loader_chain.class' => 'Symfony\\Component\\Validator\\Mapping\\Loader\\LoaderChain',
            'validator.mapping.loader.static_method_loader.class' => 'Symfony\\Component\\Validator\\Mapping\\Loader\\StaticMethodLoader',
            'validator.mapping.loader.annotation_loader.class' => 'Symfony\\Component\\Validator\\Mapping\\Loader\\AnnotationLoader',
            'validator.mapping.loader.xml_file_loader.class' => 'Symfony\\Component\\Validator\\Mapping\\Loader\\XmlFileLoader',
            'validator.mapping.loader.yaml_file_loader.class' => 'Symfony\\Component\\Validator\\Mapping\\Loader\\YamlFileLoader',
            'validator.mapping.loader.xml_files_loader.class' => 'Symfony\\Component\\Validator\\Mapping\\Loader\\XmlFilesLoader',
            'validator.mapping.loader.yaml_files_loader.class' => 'Symfony\\Component\\Validator\\Mapping\\Loader\\YamlFilesLoader',
            'validator.mapping.loader.static_method_loader.method_name' => 'loadValidatorMetadata',
            'validator.validator_factory.class' => 'Symfony\\Bundle\\FrameworkBundle\\Validator\\ConstraintValidatorFactory',
            'validator.annotations.namespaces' => array(
                'validation' => 'Symfony\\Component\\Validator\\Constraints\\',
            ),
            'templating.engine.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Engine',
            'templating.loader.filesystem.class' => 'Symfony\\Component\\Templating\\Loader\\FilesystemLoader',
            'templating.loader.cache.class' => 'Symfony\\Component\\Templating\\Loader\\CacheLoader',
            'templating.loader.chain.class' => 'Symfony\\Component\\Templating\\Loader\\ChainLoader',
            'templating.helper.javascripts.class' => 'Symfony\\Component\\Templating\\Helper\\JavascriptsHelper',
            'templating.helper.stylesheets.class' => 'Symfony\\Component\\Templating\\Helper\\StylesheetsHelper',
            'templating.helper.slots.class' => 'Symfony\\Component\\Templating\\Helper\\SlotsHelper',
            'templating.helper.assets.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\AssetsHelper',
            'templating.helper.actions.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\ActionsHelper',
            'templating.helper.router.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\RouterHelper',
            'templating.helper.request.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\RequestHelper',
            'templating.helper.session.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\SessionHelper',
            'templating.helper.code.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\CodeHelper',
            'templating.helper.translator.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\TranslatorHelper',
            'templating.helper.security.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\SecurityHelper',
            'templating.helper.form.class' => 'Symfony\\Bundle\\FrameworkBundle\\Templating\\Helper\\FormHelper',
            'templating.assets.version' => NULL,
            'templating.assets.base_urls' => array(
            ),
            'debug.file_link_format' => NULL,
            'templating.loader.filesystem.path' => array(
                0 => 'C:\\www\\test\\sandbox\\app/views/%bundle%/%controller%/%name%%format%.%renderer%',
                1 => 'C:\\www\\test\\sandbox\\app/../src/Application/%bundle%/Resources/views/%controller%/%name%%format%.%renderer%',
                2 => 'C:\\www\\test\\sandbox\\app/../src/Bundle/%bundle%/Resources/views/%controller%/%name%%format%.%renderer%',
                3 => 'C:\\www\\test\\sandbox\\app/../src/vendor/symfony/src/Symfony/Bundle/%bundle%/Resources/views/%controller%/%name%%format%.%renderer%',
            ),
            'templating.loader.cache.path' => NULL,
            'session.class' => 'Symfony\\Component\\HttpFoundation\\Session',
            'session.default_locale' => 'en',
            'session.storage.native.class' => 'Symfony\\Component\\HttpFoundation\\SessionStorage\\NativeSessionStorage',
            'session.storage.native.options' => array(
                'lifetime' => 3600,
            ),
            'session.storage.pdo.class' => 'Symfony\\Component\\HttpFoundation\\SessionStorage\\PdoSessionStorage',
            'session.storage.pdo.options' => array(
            ),
            'translator.class' => 'Symfony\\Bundle\\FrameworkBundle\\Translation\\Translator',
            'translator.identity.class' => 'Symfony\\Component\\Translation\\IdentityTranslator',
            'translator.selector.class' => 'Symfony\\Component\\Translation\\MessageSelector',
            'translation.loader.php.class' => 'Symfony\\Component\\Translation\\Loader\\PhpFileLoader',
            'translation.loader.yml.class' => 'Symfony\\Component\\Translation\\Loader\\YamlFileLoader',
            'translation.loader.xliff.class' => 'Symfony\\Component\\Translation\\Loader\\XliffFileLoader',
            'translator.fallback_locale' => 'en',
            'translation.resources' => array(
                0 => array(
                    0 => 'xliff',
                    1 => 'C:\\www\\test\\sandbox\\src\\vendor\\symfony\\src\\Symfony\\Bundle\\FrameworkBundle/Resources/translations\\validators.fr.xliff',
                    2 => 'fr',
                    3 => 'validators',
                ),
            ),
            'twig.class' => 'Symfony\\Bundle\\TwigBundle\\Environment',
            'twig.options' => array(
                'charset' => 'UTF-8',
                'debug' => false,
                'cache' => 'C:\\www\\test\\sandbox\\app/cache/prod/twig',
                'strict_variables' => false,
            ),
            'twig.loader.class' => 'Symfony\\Bundle\\TwigBundle\\Loader\\Loader',
            'twig.renderer.class' => 'Symfony\\Bundle\\TwigBundle\\Renderer\\Renderer',
            'twig.form.resources' => array(
            ),
        ); } }
