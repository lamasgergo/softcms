<?php

namespace Application\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Application\TestBundle\Entity\Test;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;

class TestController extends Controller
{
    public function registerAction()
    {
        $test = new Test();
        $form = new Form('test', $test, $this->get('validator'));
        $form->add(new TextField('name'));


        if ('POST' === $this->get('request')->getMethod()) {
            $form->bind($this->get('request')->request->get('test'));

            if ($form->isValid()) {
                $em = $this->get('doctrine.orm.entity_manager');
                $em->persist($form->getData());
                $em->flush();
            }
        }

        return $this->render('TestBundle:Test:register.twig', array(
            'form'  => $form
        ));
    }
}
