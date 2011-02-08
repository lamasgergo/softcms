<?php
// Application/UserBundle/Controller/UserController.php
namespace Application\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Application\UserBundle\Entity\User;

use Application\UserBundle\Forms\UserDetailsForm;

class UserController extends Controller {



    public function getCurrentUser(){
        $user = $this->get('security.context')->getUser();
        if (method_exists($user, 'getId')){
            return $user;
        }
        return null;
    }

    public function editAction() {

        $em = $this->get('doctrine.orm.entity_manager');

        $userRequest = new User();
        $userRequest = $em->getRepository('UserBundle:User')->findBy(array('email'=>'test1@test.com'));

        $form = UserDetailsForm::create($this->get('form.context'), 'editUserDetail');

        $form->bind($this->get('request'), $userRequest);
        if ($form->isValid()) {
            $em->persist($form->getData());
            $em->flush();
            $session = $this->get('request')->getSession();
            $translator = $this->get('translator');
            $session->setFlash('notice', $translator->trans('Information saved successfully!'));
        }

        return $this->render('UserBundle:User:edit.html.twig', array(
            'form' => $form
        ));
    }

    public function indexAction(){
        return $this->render('UserBundle:User:index.html.twig', array(
        ));
    }
}
