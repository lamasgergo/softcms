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

class UserController extends Controller {
    public function indexAction() {

        $conn = $this->get('database_connection');

        $users = $conn->fetchAll('SELECT * FROM user');
        return $this->render('UserBundle:User:index.twig', array('list' => $users));

        // render a PHP template instead
        // return $this->render('UserBundle:User:index.php', array('name' => $name));
    }

    public function detailAction($name) {
        return $this->render('UserBundle:User:detail.twig', array('name' => $name));

        // render a PHP template instead
        // return $this->render('UserBundle:User:index.php', array('name' => $name));
    }

    public function registerAction() {
        $registration = new User();
        $registration->userdata = new UserData();

        $form = new Form('registration', $registration, $this->get('validator'));


        $form->add(new TextField('email'));
        $form->add(new RepeatedField( new TextField('password') ));
        $form->add(new TextField('name'));
        $form->add(new TextField('surname'));
        $form->add(new TextField('pantronymic'));

        $em = $this->get('doctrine.orm.entity_manager');
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

        $addressGroup = new FieldGroup('userdata');
        $addressGroup->add(new TextField('country'));
        $addressGroup->add(new TextField('city'));
        $addressGroup->add(new TextareaField('address'));
        $addressGroup->add(new TextareaField('address2'));
        $form->add($addressGroup);

        if ('POST' === $this->get('request')->getMethod()) {
            $form->bind($this->get('request')->request->get('registration'));
ECHO '<PRE>';
            die(var_dump($form->getData()));
            if ($form->isValid()) {
                $em->persist($form->getData());
                $em->flush();
            }
        }

        return $this->render('UserBundle:User:register2.twig', array(
            'form' => $form
        ));
    }
}
