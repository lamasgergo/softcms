<?php
namespace Application\UserBundle\Entity;
use Application\UserBundle\Entity\User;

class Registration extends User{

    /**
     * @validation:AssertTrue(message = "The token is invalid")
     */
    private $captcha;

    private $captchaValue;

    /**
     * @validation:AssertTrue(message="Please accept the terms and conditions")
     */
    public $termsAccepted = false;


    public function isCaptchaValid() {
        return $this->captcha == $this->getCaptchaValue();
    }

    public function getCaptcha() {
        return $this->captcha;
    }

    public function setCaptcha($captcha) {
        $this->captcha = $captcha;
    }

    public function getCaptchaValue() {
        return $this->captchaValue;
    }

    public function setCaptchaValue($captchaValue) {
        $this->captchaValue = $captchaValue;
    }
}
?>
 
