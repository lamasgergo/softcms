<?php
namespace Application\UserBundle\Entity;
use Application\UserBundle\Entity\User;


/**
 * @orm:Entity
 * @orm:Table(name="user")
 */
class Registration extends User {

    private $captcha;

    /**
     * @validation:AssertTrue(message="Please accept the terms and conditions")
     */
    public $termsAccepted = false;

    /**
     * @validation:AssertTrue(message="The captcha is invalid")
     */
    public function isCaptchaValid() {
        return ($this->captcha == $_SESSION[\Captcha\CaptchaBundle\Captcha::keySessionName]);
    }

    public function getCaptcha(){
        return $this->captcha;
    }

    public function setCaptcha($captcha) {
        $this->captcha = $captcha;
    }

}

?>
 
