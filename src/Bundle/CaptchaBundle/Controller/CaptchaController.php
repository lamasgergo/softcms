<?php
namespace Bundle\CaptchaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Bundle\CaptchaBundle\Captcha;

class CaptchaController extends Controller{

    public function captchaAction(){
        $captcha = new Captcha();
        $image = $captcha->show();

        $response = $this->render('CaptchaBundle::captcha.twig.html', array(
            'image' => $image
        ));
        return $response;
    }
    
}