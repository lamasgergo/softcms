<?php

namespace Application\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Application\UserBundle\Entity\User,
    Application\UserBundle\Entity\UserData,
    Application\UserBundle\Entity\UserType;

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
    public function indexAction() {

        $em = $this->get('doctrine.orm.entity_manager');
        $query = $em->createQuery("SELECT u FROM UserBundle:User u");
        $query->setMaxResults(10);
        $users = $query->getResult();
        return $this->render('UserBundle:User:index.twig', array('list' => $users));

        // render a PHP template instead
        // return $this->render('UserBundle:User:index.php', array('name' => $name));
    }

    public function detailAction($id) {
        $em = $this->get("doctrine.orm.entity_manager");
        $user = new User();
        $user = $em->find("UserBundle:User", $id);
        return $this->render('UserBundle:User:detail.twig', array('user' => $user));
    }

    protected function registerForm(){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = new User();

        $form = new Form('userForm', $user, $this->get('validator'));

        $form->add(new TextField('email'));
        $form->add(new RepeatedField( new PasswordField('password') ));
        $form->add(new TextField('name'));
        $form->add(new TextField('surname'));
        $form->add(new TextField('pantronymic'));

        $types = $user->getTypes();
echo '<pre>';
        die(var_dump($user));
        $form->add(new ChoiceField('type'), array(
            'choices' => $types
        ));

        $form->add(new CheckboxField('termsAccepted'));

        return $form;
    }

    protected function userForm($object=null){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = new User();
        $user->data = new UserData();

        $form = new Form('userForm', $user, $this->get('validator'));

        $form->add(new TextField('email'));
        $form->add(new RepeatedField( new PasswordField('password') ));
        $form->add(new TextField('name'));
        $form->add(new TextField('surname'));
        $form->add(new TextField('pantronymic'));
        $form->add(new CheckboxField('termsAccepted'));

        $translator = $this->get('translator');
        $typeChoices = array();
        $types = $em->getRepository('UserBundle:UserType')->findAll();
        foreach ($types AS $type) {
            $typeChoices[$type->id] = $translator->trans($type->name);
        }
        $types = new ChoiceField('type', array(
            'choices' => $typeChoices
        ));
        $form->add($types);

        $addressGroup = new FieldGroup('data');
        $addressGroup->add(new TextField('country'));
        $addressGroup->add(new TextField('city'));
        $addressGroup->add(new TextareaField('address'));
        $addressGroup->add(new TextareaField('address2'));
        $form->add($addressGroup);

        if ($object!=null){
            $form->setData($object);
        }

        return $form;
    }

    public function registerAction() {
        $em = $this->get('doctrine.orm.entity_manager');
        $form = $this->registerForm();

        if ('POST' === $this->get('request')->getMethod()) {
            $form->bind($this->get('request')->request->get('userForm'));
            if ($form->isValid()) {
                $em->persist($form->getData());
                $em->flush();
//                $this->sendRegistrationEmail();
            }
        }

        return $this->render('UserBundle:User:register.twig', array(
            'form' => $form
        ));
    }

    public function editAction($id){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->find('UserBundle:User', (int)$id);
        $form = $this->userForm($user);

        if ('POST' === $this->get('request')->getMethod()) {
//            $form->setValidationGroups('User');
//            $form->setValidationGroups('UserData');
            $form->bind($this->get('request')->request->get('userForm'));
            if ($form->isValid()) {
                $em->persist($form->getData());
                $em->flush();
            }
        }

        return $this->render('UserBundle:User:edit.twig', array(
            'form' => $form,
            'username' => $user->name
        ));
    }
}
