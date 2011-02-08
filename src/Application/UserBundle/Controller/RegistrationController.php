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
                ->setBody($this->renderView('UserBundle:Registration:confirmationEmail.twig.html', array('user' => $user)));
        $mailer->send($message);
    }

    public function RegistrationAction() {
        $em = $this->get('doctrine.orm.entity_manager');

        $registrationRequest = new Registration();
        $form = RegistrationForm::create($this->get('form.context'), 'tezt');

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

    public function captchaAction(){
        $session = $this->get('request')->getSession();
        $text = $session->get('captcha');

        $image = @imagecreate (50, 100);
        $background_color = imagecolorallocate ($image, 255, 255, 255);
        $text_color = imagecolorallocate ($image, 233, 14, 91);
        imagestring ($image, 1, 5, 5,  $text, $text_color);
        imagepng ($image);

        $response = $this->render('UserBundle:Registration:captcha.twig.html', array(
            'image' => $image
        ));
        $response->headers->set('Content-Type', 'image/png');
        return $response;
    }
}

?>