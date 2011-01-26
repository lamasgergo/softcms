<?php

/* C:\htdocs\test\app/../src/vendor/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Exception/exception_full.twig */
class __TwigTemplate_9b17afbb4d20d37da5e18653981eefe1 extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    public function getParent(array $context)
    {
        if (null === $this->parent) {
            $this->parent = $this->env->loadTemplate("FrameworkBundle:Exception:layout.twig");
        }

        return $this->parent;
    }

    public function display(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        echo "    ";
        // line 4
        $template = "FrameworkBundle:Exception:exception.twig";
        if ($template instanceof Twig_Template) {
            $template->display($context);
        } else {
            echo $this->env->getExtension('templating')->getTemplating()->render($template, $context);
        }
    }

    public function getTemplateName()
    {
        return "C:\\htdocs\\test\\app/../src/vendor/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Exception/exception_full.twig";
    }
}
