<?php
namespace Application\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\Security\Acl\Domain\ObjectIdentity,
    Symfony\Component\Security\Acl\Domain\UserSecurityIdentity,
    Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Application\ContentBundle\Entity\Content;
use Application\ContentBundle\Forms\ContentForm;

class ContentController extends Controller{

    protected $user;
    protected $type;


    public function createAction(){
        $em = $this->get('doctrine.orm.entity_manager');
        $this->type = 'article';
        $this->user = $this->get('security.context')->getUser();

        $content = new Content();
        $content->setUser($this->user);
        $content->setType($this->type);

        $form = ContentForm::create($this->get('form.context'), 'content_form');
        $form->bind($this->get('request'), $content);

        if ($form->isValid()){
            $em->persist($form->getData());
            $em->flush();

            // creating the ACL
            $aclProvider = $this->container->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($content);
            $acl = $aclProvider->createAcl($objectIdentity);

            // retrieving the security identity of the currently logged-in user
            $securityContext = $this->container->get('security.context');
            $user = $securityContext->getToken()->getUser();
            $securityIdentity = UserSecurityIdentity::fromAccount($user);

            // grant owner access
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);

            return $this->redirect($this->generateUrl('content_index'));
        }

        return $this->render("ContentBundle::content_form.html.twig", array(
            'form' => $form
        ));
    }

    public function modifyAction($id){
        $em = $this->get('doctrine.orm.entity_manager');
        $content = $em->find('ContentBundle:Content', $id);

        $securityContext = $this->container->get('security.context');
        // check for edit access
        if (false === $securityContext->vote('EDIT', $content) && !$securityContext->getUser()->isAdmin())
        {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedExceptionAccessDeniedException();
        }

        $form = ContentForm::create($this->get('form.context'), 'content_form');
        $form->bind($this->get('request'), $content);

        if ($form->isValid()){
            $em->persist($form->getData());
            $em->flush();

            return $this->redirect($this->generateUrl('content_index'));
        }

        return $this->render("ContentBundle::content_form.html.twig", array(
            'form' => $form
        ));
    }

    public function indexAction(){
        $securityContext = $this->get("security.context");
        $user = $securityContext->getUser();
        $content = $user->getContent();
        return $this->render("ContentBundle::index.html.twig", array(
            'data' => $content
        ));
    }

    public function deleteAction($id){
        $em = $this->get("doctrine.orm.entity_manager");
        $content = $em->find("ContentBundle:Content", $id);

        $securityContext = $this->container->get('security.context');
        // check for edit access
        if (false === $securityContext->vote('DELETE', $content) && !$securityContext->getUser()->isAdmin())
        {
            throw new AccessDeniedException();
        }

        $em->remove($content);
        $em->flush();

        return $this->redirect($this->generateUrl('content_index'));
    }

    public function ViewAction($id){
        $em = $this->get("doctrine.orm.entity_manager");
        $content = $em->getRepository("ContentBundle:Content");
        $data = $content->findOneBy(array("url" => $id));
        if (!$data){
            $data = $content->findOneBy(array("Id" => $id));
        }
        if (!$data){
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }
        return $this->render("ContentBundle::view.html.twig", array(
            'data' => $data
        ));
    }

}