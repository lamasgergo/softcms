<?php

/* C:\www\test\sandbox\app/../src/vendor/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Exception/error.twig */
class __TwigTemplate_696607e81da30adf5bb269d524fde246 extends Twig_Template
{
    public function display(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
    </head>
    <body>
        <h1>Oops! An Error Occurred</h1>
        <h2>The server returned a \"";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['exception']) ? $context['exception'] : null), "statuscode", array(), "any"), "html");
        echo " ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context['exception']) ? $context['exception'] : null), "statustext", array(), "any"), "html");
        echo "\".</h2>

        <div>
            Something is broken. Please e-mail us at [email] and let us know
            what you were doing when this error occurred. We will fix it as soon
            as possible. Sorry for any inconvenience caused.
        </div>
    </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "C:\\www\\test\\sandbox\\app/../src/vendor/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Exception/error.twig";
    }
}
