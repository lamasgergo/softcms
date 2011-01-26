<?php
namespace Application\HomepageBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller{

    public function indexAction(){
        return $this->render('HomepageBundle:Home:index.twig');
    }

}
?>