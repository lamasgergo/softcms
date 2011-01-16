<?php

namespace Application\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Application\UserBundle\Entity\User;
use Application\UserBundle\Entity\UserType;
use Application\UserBundle\Entity\Registration;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;
use Symfony\Component\Form\IntegerField;
use Symfony\Component\Form\CheckboxField;
use Symfony\Component\Form\FieldGroup;
use Symfony\Component\Form\ChoiceField;

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

    public function signupAction() {
        $conn = $this->get('database_connection');
        $registration = new Registration();
        $registration->user = new User();

        $form = new Form('registration', $registration, $this->get('validator'));
        $form->add(new CheckboxField('termsAccepted'));

        $group = new FieldGroup('user');
        $group->add(new TextField('email'));
        $group->add(new TextField('name'));
        $group->add(new TextField('surname'));
        $group->add(new TextField('pantronymic'));

        $em = $this->get('doctrine.orm.entity_manager');
        $translator = $this->get('translator');
        $typeChoices = array();
        $types = $em->getRepository('UserBundle:UserType')->findAll();
//        die(var_dump($types));
        foreach ($types AS $type) {
            $typeChoices[$type->id] = $translator->trans($type->name);
        }
        $types = new ChoiceField('type', array(
            'choices' => $typeChoices
        ));
        $group->add($types);

        $form->add($group);

        if ('POST' === $this->get('request')->getMethod()) {
            $form->bind($this->get('request')->request->get('registration'));

            if ($form->isValid()) {
                $registration->process();
            }
        }

        return $this->render('UserBundle:User:signup.twig', array(
            'form' => $form
        ));
    }
}
