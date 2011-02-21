<?php
namespace Common\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller{

    public function indexAction(){
        return $this->render("HomeBundle:Home:index.html.twig");
    }
}
