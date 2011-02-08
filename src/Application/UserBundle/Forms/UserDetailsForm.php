<?php

namespace Application\UserBundle\Forms;

use Symfony\Component\Form\Form,
    Symfony\Component\Form\TextField,
    Symfony\Component\Form\CheckboxField,
    Symfony\Component\Form\RepeatedField,
    Symfony\Component\Form\PasswordField;

class UserDetailsForm extends Form{

    protected function configure(){
        $this->add(new TextField('email'));
        $this->add(new RepeatedField(new PasswordField('password')));
        $this->add(new TextField('name'));
        $this->add(new TextField('surname'));
    }
}
?>