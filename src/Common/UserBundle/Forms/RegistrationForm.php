<?php
namespace Common\UserBundle\Forms;

use Symfony\Component\Form\Form,
    Symfony\Component\Form\TextField,
    Symfony\Component\Form\RepeatedField,
    Symfony\Component\Form\PasswordField,
    Symfony\Component\Form\CheckboxField,
    Symfony\Component\Form\HiddenField;


class RegistrationForm extends Form {
    protected function configure() {
        $this->add(new TextField('email'));
        $this->add(new TextField('name'));
        $this->add(new TextField('surname'));
        $this->add(new RepeatedField(new PasswordField('password')));
        $this->add(new TextField('captcha'), array(
            'required'  => true
        ));
        $this->add(new CheckboxField('termsAccepted'));
    }
}
