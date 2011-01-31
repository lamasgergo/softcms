<?php
// Application/UserBundle/Controller/UserController.php
namespace Application\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Application\UserBundle\Entity\User;

use Symfony\Component\Form\Form,
    Symfony\Component\Form\TextField,
    Symfony\Component\Form\IntegerField,
    Symfony\Component\Form\CheckboxField,
    Symfony\Component\Form\FieldGroup,
    Symfony\Component\Form\ChoiceField,
    Symfony\Component\Form\RepeatedField,
    Symfony\Component\Form\TextareaField,
    Symfony\Component\Form\PasswordField;

class UserController extends Controller {

    protected function registrationForm() {
        $user = new User();

        $form = new Form('userForm', $user, $this->get('validator'));

        $form->add(new TextField('email'));
        $form->add(new TextField('name'));
        $form->add(new TextField('surname'));
        $form->add(new RepeatedField(new PasswordField('password')));

        return $form;
    }

    protected function userForm($object = null) {
        $em = $this->get('doctrine.orm.entity_manager');
        $user = new User();

        $form = new Form('userForm', $user, $this->get('validator'));

        $form->add(new TextField('email'));
        $form->add(new RepeatedField(new PasswordField('password')));
        $form->add(new TextField('name'));
        $form->add(new TextField('surname'));
        if ($object != null) {
            $form->setData($object);
        }

        return $form;
    }

    public function sendRegistrationEmail(User $user) {
        $mailer = $this->get('mailer');
        $message = \Swift_Message::newInstance()
                ->setSubject('Activation')
                ->setFrom($this->container->getParameter('email.from'))
                ->setTo($user->getEmail())
                ->setBody($this->renderView('UserBundle:User:confirmationEmail.twig.html', array('user' => $user)));
        $mailer->send($message);
    }

    public function RegistrationAction() {
        $em = $this->get('doctrine.orm.entity_manager');
        $form = $this->registrationForm();
        $result = false;
        $submited = false;
        if ('POST' === $this->get('request')->getMethod()) {
            $submited = true;
            $form->bind($this->get('request')->request->get('userForm'));

            if ($form->isValid()) {
                $user = new User();
                $em->persist($form->getData());
                $em->flush();
                $result = true;
                //                $this->sendRegistrationEmail($form->getData());
            }
        }

        return $this->render('UserBundle:User:registration.twig.html', array(
            'form' => $form,
            'form_submited' => $submited,
            'form_result' => $result
        ));
    }

    public function getCurrentUser(){
        $user = $this->get('security.context')->getUser();
        if (method_exists($user, 'getId')){
            return $user;
        }
        return null;
    }

    public function editAction() {

        $em = $this->get('doctrine.orm.entity_manager');
        $user = $this->getCurrentUser();
        $form = $this->userForm($user);

        if ('POST' === $this->get('request')->getMethod()) {
            $form->bind($this->get('request')->request->get('userForm'));
//die(var_dump($form->getData()));
            if ($form->isValid()) {
                $em->persist($form->getData());
                $em->flush();
                $session = $this->get('request')->getSession();
                $translator = $this->get('translator');
                $session->setFlash('notice', $translator->trans('Information saved successfully!'));
            }
        }

        return $this->render('UserBundle:User:edit.twig.html', array(
            'form' => $form,
            'username' => $user->getName()
        ));
    }

    public function indexAction(){
        return $this->render('UserBundle:User:index.twig.html', array(
        ));
    }
}
