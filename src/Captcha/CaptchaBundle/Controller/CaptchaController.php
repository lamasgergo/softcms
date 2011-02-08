<?php
namespace Captcha\CaptchaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Captcha\CaptchaBundle\Captcha;

class CaptchaController extends Controller{

    public function captchaAction(){
        $captcha = new Captcha();
        $image = $captcha->show();

        $response = $this->render('CaptchaBundle::captcha.html.twig', array(
            'image' => $image
        ));
        return $response;
    }
    
}