<?php

namespace Application\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Application\UserBundle\Entity\Registration;

use Application\UserBundle\Forms\RegistrationForm;
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

        $registrationRequest = new Registration();
        $form = RegistrationForm::create($this->get('form.context'), 'registration');

        $form->bind($this->get('request'), $registrationRequest);

        if ($form->isValid()) {
            $em->persist($form->getData());
            $em->flush();
            //                $this->sendRegistrationEmail($form->getData());
            $this->forward($this->generateUrl('homepage'));
        } else {
            $captcha = new Captcha();
            $captcha->setKey('', true);
        }

        return $this->render('UserBundle:Registration:registration.html.twig', array(
            'form' => $form
        ));
    }

}

?>