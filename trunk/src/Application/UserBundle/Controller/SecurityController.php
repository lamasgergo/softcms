<?php
namespace Application\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
Symfony\Component\Security\SecurityContext;

class SecurityController extends Controller {
    public function loginAction() {
        // get the error if any (works with forward and redirect -- see below)
        if ($this['request']->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this['request']->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this['request']->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('UserBundle:Security:login.twig.html', array(
            // last username entered by the user
            'last_username' => $this['request']->getSession()->get(SecurityContext::LAST_USERNAME),
            'error' => $error,
        ));
    }
}


