<?php
// Application/UserBundle/Controller/UserController.php
namespace Application\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Application\UserBundle\Entity\User;


class UserController extends Controller {

    public function detailAction($id) {
        $em = $this->get("doctrine.orm.entity_manager");
        $user = new User();
        $user = $em->find("UserBundle:User", $id);
        return $this->render('UserBundle:User:detail.twig.html', array('user' => $user));
    }

    protected function registerForm(){
        $user = new User();

        $form = new Form('userForm', $user, $this->get('validator'));

        $form->add(new TextField('email'));
        $form->add(new RepeatedField( new PasswordField('password') ));
        $form->add(new TextField('name'));
        $form->add(new TextField('surname'));
        $form->add(new TextField('pantronymic'));

        $form->add(new CheckboxField('termsAccepted'));

        return $form;
    }

    protected function userForm($object=null){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = new User();
        $user->data = new UserData();

        $form = new Form('userForm', $user, $this->get('validator'));

        $form->add(new TextField('email'));
        $form->add(new RepeatedField( new PasswordField('password') ));
        $form->add(new TextField('name'));
        $form->add(new TextField('surname'));
        $form->add(new TextField('pantronymic'));
        $form->add(new CheckboxField('termsAccepted'));

        $translator = $this->get('translator');
        $typeChoices = array();
        $types = $em->getRepository('UserBundle:UserType')->findAll();
        foreach ($types AS $type) {
            $typeChoices[$type->id] = $translator->trans($type->name);
        }
        $types = new ChoiceField('type', array(
            'choices' => $typeChoices
        ));
        $form->add($types);

        $addressGroup = new FieldGroup('data');
        $addressGroup->add(new TextField('country'));
        $addressGroup->add(new TextField('city'));
        $addressGroup->add(new TextareaField('address'));
        $addressGroup->add(new TextareaField('address2'));
        $form->add($addressGroup);

        if ($object!=null){
            $form->setData($object);
        }

        return $form;
    }

    public function sendRegistrationEmail(User $user){
        $mailer = $this->get('mailer');
        $message = \Swift_Message::newInstance()
                ->setSubject('Activation')
                ->setFrom($this->container->getParameter('email.from'))
                ->setTo($user->getEmail())
                ->setBody($this->renderView('UserBundle:User:confirmationEmail.twig.html', array('user'=>$user)))
        ;
        $mailer->send($message);
    }

    public function registerAction() {
        $em = $this->get('doctrine.orm.entity_manager');
        $form = $this->registerForm();
        $result = false;
        $submited = false;
        if ('POST' === $this->get('request')->getMethod()) {
            $submited = true;
            $form->bind($this->get('request')->request->get('userForm'));

            if($form->isValid()){
                $em->persist($form->getData());
                $em->flush();
                $result = true;
                $this->sendRegistrationEmail($form->getData());
            }
        }

        return $this->render('UserBundle:User:register.twig.html', array(
            'form' => $form,
            'form_submited' => $submited,
            'form_result' => $result
        ));
    }

    public function editAction($id){
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->find('UserBundle:User', (int)$id);
        $form = $this->userForm($user);

        if ('POST' === $this->get('request')->getMethod()) {
//            $form->setValidationGroups('User');
//            $form->setValidationGroups('UserData');
            $form->bind($this->get('request')->request->get('userForm'));
            if ($form->isValid()) {
                $em->persist($form->getData());
                $em->flush();
            }
        }

        return $this->render('UserBundle:User:edit.twig.html', array(
            'form' => $form,
            'username' => $user->name
        ));
    }
}
