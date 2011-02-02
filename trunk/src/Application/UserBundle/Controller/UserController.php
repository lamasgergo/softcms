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
