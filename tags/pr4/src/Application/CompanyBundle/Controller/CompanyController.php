<?php

namespace Application\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CompanyController extends Controller {


    public function indexAction() {
        return $this->render('CompanyBundle:Company:index.twig');
    }

}
