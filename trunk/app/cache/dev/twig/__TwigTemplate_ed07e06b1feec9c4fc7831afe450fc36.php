<?php

/* C:\htdocs\test\app/../src/Application/UserBundle/Resources/views/User/login.twig */
class __TwigTemplate_ed07e06b1feec9c4fc7831afe450fc36 extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    public function getParent(array $context)
    {
        if (null === $this->parent) {
            $this->parent = $this->env->loadTemplate("::layout.twig");
        }

        return $this->parent;
    }

    public function display(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_content($context, array $blocks = array())
    {
        // line 3
        if ($this->getContext($context, 'error', '3')) {
            echo "<div>";
            // line 4
            echo twig_escape_filter($this->env, $this->getContext($context, 'error', '4'), "html");
            echo "</div>
";
        }
        // line 5
        echo "
<form action=\"";
        // line 7
        echo $this->env->getExtension('templating')->getContainer()->get('router')->generate("_security_check", array(), false);        echo "\" method=\"post\">
    <label for=\"username\">Username:</label>
    <input type=\"text\" id=\"username\" name=\"_username\" value=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->getContext($context, 'last_username', '9'), "html");
        echo "\"/>

    <label for=\"password\">Password:</label>
    <input type=\"password\" id=\"password\" name=\"_password\"/>

    <input type=\"submit\" name=\"login\"/>
</form>
";
    }

    public function getTemplateName()
    {
        return "C:\\htdocs\\test\\app/../src/Application/UserBundle/Resources/views/User/login.twig";
    }
}
