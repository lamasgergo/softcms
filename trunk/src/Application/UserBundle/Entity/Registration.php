<?php
namespace Application\UserBundle\Entity;
use Application\UserBundle\Entity\User;

/**
 * @orm:Entity
 * @orm:Table(name="user")
 */
class Registration extends User{

    /**
     * @validation:AssertTrue(message="The captcha is invalid")
     */
    private $captcha;

    private $captchaValue;

    /**
     * @validation:AssertTrue(message="The captcha is invalid")
     */
    public $termsAccepted = false;


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

    public function isCaptcha() {
        die('123');
        return $this->captcha == $this->getCaptchaValue();
    }
}
?>
 
