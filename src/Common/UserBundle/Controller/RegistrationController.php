<?php

namespace Common\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Common\UserBundle\Entity\User;

use Common\UserBundle\Forms\RegistrationForm;
use Captcha\CaptchaBundle\Captcha;

class RegistrationController extends Controller {

    public function sendRegistrationEmail(User $user) {
        $mailer = $this->get('mailer');
        $message = \Swift_Message::newInstance()
                ->setSubject('Activation')
                ->setFrom($this->container->getParameter('email.from'))
                ->setTo($user->getEmail())
                ->setBody($this->renderView('UserBundle:Registration:confirmationEmail.html.twig', array('user' => $user)));
        $mailer->send($message);
    }

    public function RegistrationAction() {
        $em = $this->get('doctrine.orm.entity_manager');

        $registrationRequest = new User();
        $registrationRequest->setTermsAccepted(false);
        $form = RegistrationForm::create($this->get('form.context'), 'registration');

        $form->bind($this->get('request'), $registrationRequest);

        $captcha = new Captcha();
        if ($form->isValid()) {
            $em->persist($form->getData());
            $em->flush();
            //                $this->sendRegistrationEmail($form->getData());
            $captcha->setKey('', true);
            return $this->redirect($this->generateUrl('homepage'));
        } else {
            $captcha->setKey('', true);
        }

        return $this->render('UserBundle:Registration:registration.html.twig', array(
            'form' => $form
        ));
    }

}

?>