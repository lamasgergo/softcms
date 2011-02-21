<?php

namespace Common\ContentBundle\Forms;

use Symfony\Component\Form\Form,
    Symfony\Component\Form\TextField,
    Symfony\Component\Form\TextareaField;

class ContentForm extends Form{

    protected function configure(){
        $this->add(new TextField('title'));
        $this->add(new TextareaField('content'));
    }
}