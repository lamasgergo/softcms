<?php

namespace Application\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Application\UserBundle\Entity\User;
use Application\UserBundle\Entity\UserData;
use Application\UserBundle\Entity\UserType;
use Application\UserBundle\Entity\Registration;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\IntegerField;
use Symfony\Component\Form\CheckboxField;
use Symfony\Component\Form\FieldGroup;
use Symfony\Component\Form\ChoiceField;
use Symfony\Component\Form\RepeatedField;
use Symfony\Component\Form\TextareaField;
use Symfony\Component\Form\PasswordField;

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

    public function detailAction($name) {
        return $this->render('UserBundle:User:detail.twig', array('name' => $name));

        // render a PHP template instead
        // return $this->render('UserBundle:User:index.php', array('name' => $name));
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
        $form = $this->userForm();

        if ('POST' === $this->get('request')->getMethod()) {
//            $form->setValidationGroups('User');
//            $form->setValidationGroups('UserData');
            $form->bind($this->get('request')->request->get('userForm'));
            if ($form->isValid()) {
                $em->persist($form->getData());
                $em->flush();
                $this->sendRegistrationEmail();
            }
        }

        return $this->render('UserBundle:User:register2.twig', array(
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
