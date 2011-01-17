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
        $registration = new Registration();
        $registration->user = new User();
        $registration->userdata = new UserData();

        $form = new Form('registration', $registration, $this->get('validator'));

        $commonGroup = new FieldGroup('user');
        $commonGroup->add(new TextField('email'));
        $commonGroup->add(new RepeatedField( new TextField('password') ));
        $commonGroup->add(new TextField('name'));
        $commonGroup->add(new TextField('surname'));
        $commonGroup->add(new TextField('pantronymic'));

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
        $commonGroup->add($types);

        $form->add(new CheckboxField('termsAccepted'));
        $form->add($commonGroup);

        $addressGroup = new FieldGroup('userdata');
        $addressGroup->add(new TextField('country'));
        $addressGroup->add(new TextField('city'));
        $addressGroup->add(new TextareaField('address'));
        $form->add($addressGroup);

        if ('POST' === $this->get('request')->getMethod()) {
            $form->bind($this->get('request')->request->get('registration'));

            if ($form->isValid()) {
                $registration->process();
            }
        }

        return $this->render('UserBundle:User:register.twig', array(
            'form' => $form
        ));
    }
}
