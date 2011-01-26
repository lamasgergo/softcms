<?php

/* ::layout.twig */
class __TwigTemplate_0973625de5a4edccb08cfda83dc3d9c9 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'head' => array($this, 'block_head'),
            'content' => array($this, 'block_content'),
            'footer' => array($this, 'block_footer'),
        );
    }

    public function display(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
    <title>";
        // line 5
        $this->getBlock('title', $context, $blocks);
        echo "</title>

    <script src=\"";
        // line -1
        echo twig_raw_filter(        // line 7
$this->env->getExtension("templating")->getContainer()->get("templating.helper.assets")->getUrl("js/jquery/jquery.js"));
        echo "\"></script>
    <link href=\"";
        // line -1
        echo twig_raw_filter(        // line 8
$this->env->getExtension("templating")->getContainer()->get("templating.helper.assets")->getUrl("css/jquery/jquery-ui.css"));
        echo "\" rel=\"stylesheet\" type=\"text/css\"/>
    ";
        // line 9
        $this->getBlock('head', $context, $blocks);
        echo "</head>
<body>
<div class=\"menu\">
    <ul>
        <li><a href=\"";
        // line 14
        echo $this->env->getExtension('templating')->getContainer()->get('router')->generate("register", array(), false);        echo "\">";
        echo $this->env->getExtension('translator')->getTranslator()->trans("Register", array_merge(array(), array()), "messages");
        echo "</a></li>
    </ul>
</div>
<div class=\"content\">";
        // line 17
        $this->getBlock('content', $context, $blocks);
        echo "</div>
<div class=\"footer\">
    ";
        // line 19
        $this->getBlock('footer', $context, $blocks);
        // line 21
        echo "</div>
</body>
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "Hello Application";
    }

    // line 9
    public function block_head($context, array $blocks = array())
    {
    }

    // line 17
    public function block_content($context, array $blocks = array())
    {
    }

    // line 19
    public function block_footer($context, array $blocks = array())
    {
        echo "    &copy; Copyright 2011 by <a href=\"/\">you</a>.
    ";
    }

    public function getTemplateName()
    {
        return "::layout.twig";
    }
}
