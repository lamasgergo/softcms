<?php
namespace Application\UserBundle\Entity;
use Application\UserBundle\Entity\User;

/**
 * @orm:Entity
 * @orm:Table(name="user")
 */
class Registration extends User {

    /**
     * @validation:NotNull
     */
    private $captcha;

    private $captchaValue;

    /**
     * @validation:AssertTrue(message="Please accept the terms and conditions")
     */
    public $termsAccepted = false;

    /**
     * @validation:AssertTrue(message="The captcha is invalid")
     */
    public function isCaptcha() {
        return $this->captcha == $this->getCaptchaValue();
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
 
