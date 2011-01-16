<?php
namespace Application\UserBundle\Entity;

class Registration{

    /** @validation:Valid */
    public $user;

    /** @validation:AssertTrue(message="Please accept the terms and conditions") */
    public $termsAccepted = false;

    public function process(){
        
    }
}
