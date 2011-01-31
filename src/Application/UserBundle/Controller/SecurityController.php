<?php
namespace Application\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
Symfony\Component\Security\SecurityContext;

class SecurityController extends Controller {
    public function loginAction() {

        $securityContext = $this->container->get('security.context');

        // get the error if any (works with forward and redirect -- see below)
        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        $user_id = 0;
        $user = $securityContext->getUser();
        if (method_exists($user, 'getId')){
            $user_id = $user->getId();
        }
        
        if ($user_id > 0){
            return $this->render('UserBundle:User:menu.twig.html', array(
                    'user' => $user
                ));
        } else {
            return $this->render('UserBundle:User:login.twig.html', array(
                // last username entered by the user
                'last_username' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
                'error' => $error
            ));
        }
    }
}


