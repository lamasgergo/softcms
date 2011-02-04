<?php

namespace Application\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Application\UserBundle\Entity\Registration;

use Symfony\Component\Form\Form,
    Symfony\Component\Form\TextField,
    Symfony\Component\Form\RepeatedField,
    Symfony\Component\Form\PasswordField,
    Symfony\Component\Form\CheckboxField,
    Symfony\Component\Form\HiddenField;

use Bundle\CaptchaBundle\Captcha;

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

        $reg = new Registration();

        $form = new Form('userForm', $reg, $this->get('validator'));

        $form->add(new TextField('email'));
        $form->add(new TextField('name'));
        $form->add(new TextField('surname'));
        $form->add(new RepeatedField(new PasswordField('password')));
        $form->add(new TextField('captcha'));
        $form->add(new CheckboxField('termsAccepted'));

        if ('POST' === $this->get('request')->getMethod()) {
            $form->bind($this->get('request')->request->get('userForm'));

            $formData = $form->getData();

            if ($form->isValid()) {
                $em->persist($formData);
                $em->flush();
                //                $this->sendRegistrationEmail($form->getData());
                $this->forward($this->generateUrl('home'));
            } else {
                $captcha = new Captcha();
                $captcha->setKey('', true);
            }
        }

        return $this->render('UserBundle:Registration:registration.twig.html', array(
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