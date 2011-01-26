<?php

/* DoctrineBundle:Collector:db.twig */
class __TwigTemplate_3d4a50438b21f292e62b62d6acee3cdf extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'toolbar' => array($this, 'block_toolbar'),
            'menu' => array($this, 'block_menu'),
            'panel' => array($this, 'block_panel'),
        );
    }

    public function getParent(array $context)
    {
        if (null === $this->parent) {
            $this->parent = $this->env->loadTemplate("WebProfilerBundle:Profiler:layout.twig");
        }

        return $this->parent;
    }

    public function display(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        echo "<img style=\"margin: 0 5px 0 10px; vertical-align: middle; height: 24px\" width=\"24\" height=\"24\" alt=\"Database\" src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAASxJREFUeNrsV00KhCAYzaGDzLZbONcIghadoDZtiqJNbVq0Ctq06xjNCTrDnKMfGoVpsFBRqNz4QD7NR77vmZ8E1nU1VOJhKIYWoAUoF2CSAwBAf9E6L3JAHn1ADrquu6Qo2LYNWAJ2DizLYjiOg8lnO9HTnKAKwGjbFl7hhOu6/G9gnud/9DzvFieYAjDquoa3noJpmqhRuQDf99+8l5RlCWV40gKKouBuhSyPKWAcR2qMooibWZZlUIYn7UAcx0KZifKkHcjznJpZGIa7BVk8Fl/YgSAIoEhGLJ6wA4iQ3H0Md9dxVVXpUcCxDcPwQRHg9utLzR+TMmmqUCVMyIpIwrKs5/ac7IvOc7dgQ9M0KUvApZXwCHQ7YieSk9fcvQ/oHxMtQAtQLeArwABN1BHcHlpLnQAAAABJRU5ErkJggg==\" />
<span style=\"color: ";
        // line 5
        echo twig_escape_filter($this->env, ($this->getAttribute($this->getContext($context, 'collector', '5'), "querycount", array(), "any") < (10) ? ("#000") : ("#d22")), "html");
        echo "\" title=\"";
        echo twig_escape_filter($this->env, sprintf("%0.2f", ($this->getAttribute($this->getContext($context, 'collector', '5'), "time", array(), "any") * 1000)), "html");
        echo " ms\">";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'collector', '5'), "querycount", array(), "any"), "html");
        echo "</span>
";
    }

    // line 8
    public function block_menu($context, array $blocks = array())
    {
        echo "<div class=\"count\">";
        // line 9
        echo twig_escape_filter($this->env, sprintf("%0.0f", ($this->getAttribute($this->getContext($context, 'collector', '9'), "time", array(), "any") * 1000)), "html");
        echo " ms</div>
<div class=\"count\">";
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'collector', '10'), "querycount", array(), "any"), "html");
        echo "</div>
<img style=\"margin: 0 5px 0 0; vertical-align: middle; width: 32px\" width=\"32\" height=\"32\" alt=\"Database\" src=\"";
        // line -1
        echo twig_raw_filter(        // line 11
$this->env->getExtension("templating")->getContainer()->get("templating.helper.assets")->getUrl("bundles/webprofiler/images/db.png"));
        echo "\" />
Doctrine
";
    }

    // line 15
    public function block_panel($context, array $blocks = array())
    {
        echo "    <h2>Queries</h2>

    ";
        // line 18
        if ((!$this->getAttribute($this->getContext($context, 'collector', '18'), "querycount", array(), "any"))) {
            echo "        <em>No queries.</em>
    ";
        } else {
            // line 20
            echo "        <ul class=\"alt\">
            ";
            // line 22
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_iterator_to_array($this->getAttribute($this->getContext($context, 'collector', '22'), "queries", array(), "any"));
            foreach ($context['_seq'] as $context['i'] => $context['query']) {
                echo "                <li class=\"";
                // line 23
                echo (twig_test_odd($this->getContext($context, 'i', '23'))) ? ("odd") : ("even");
                echo "\">
                    <div>
                        <code>";
                // line 25
                echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'query', '25'), "sql", array(), "any"), "html");
                echo "</code>
                    </div>
                    <small>
                        <strong>Parameters</strong>: ";
                // line 28
                echo twig_escape_filter($this->env, $this->getEnvironment()->getExtension('templating')->yamlEncode($this->getAttribute($this->getContext($context, 'query', '28'), "params", array(), "any")), "html");
                echo "<br />
                        <strong>Time</strong>: ";
                // line 29
                echo twig_escape_filter($this->env, sprintf("%0.2f", ($this->getAttribute($this->getContext($context, 'query', '29'), "executionMS", array(), "any") * 1000)), "html");
                echo " ms
                    </small>
                </li>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['i'], $context['query'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 32
            echo "        </ul>
    ";
        }
    }

    public function getTemplateName()
    {
        return "DoctrineBundle:Collector:db.twig";
    }
}
