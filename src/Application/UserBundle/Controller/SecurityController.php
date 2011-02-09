<?php
namespace Application\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller {
    public function loginAction() {

        $securityContext = $this->container->get('security.context');

        // get the error if any (works with forward and redirect -- see below)
        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        $user = $securityContext->getUser();
        if ($user instanceof \Application\UserBundle\Entity\User){
            $user->setLastLogin(new \DateTime());
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();
        }


        return $this->render('UserBundle:Security:login.html.twig', array(
            // last username entered by the user
            'last_username' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        ));
    }

    public function loginWidgetAction() {

        $user_id = 0;
        $securityContext = $this->container->get('security.context');

        $user = $securityContext->getUser();
        if ($user instanceof \Application\UserBundle\Entity\User){
//            $user = ;
            $user_id = $user->getId();
        }

        if ($user_id > 0){
            return $this->render('UserBundle:User:menu.html.twig', array(
                    'user' => $user
                ));
        } else {
            return $this->render('UserBundle:Security:login_widget.html.twig');
        }
    }
}


