<?php
namespace Application\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\Security\Acl\Domain\ObjectIdentity,
    Symfony\Component\Security\Acl\Domain\UserSecurityIdentity,
    Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Application\ContentBundle\Entity\News;
use Application\ContentBundle\Forms\NewsForm;

class NewsController extends Controller{

    protected $user;
    protected $type = 'news';


    public function createAction(){
        $em = $this->get('doctrine.orm.entity_manager');
        $this->user = $this->get('security.context')->getUser();

        $news = new News();
        $news->setUser($this->user);
        $news->setType($this->type);

        $form = NewsForm::create($this->get('form.context'), 'news_form');
        $form->bind($this->get('request'), $news);

        if ($form->isValid()){
            $em->persist($form->getData());
            $em->flush();

            // creating the ACL
            $aclProvider = $this->container->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($news);
            $acl = $aclProvider->createAcl($objectIdentity);

            // retrieving the security identity of the currently logged-in user
            $securityContext = $this->container->get('security.context');
            $user = $securityContext->getToken()->getUser();
            $securityIdentity = UserSecurityIdentity::fromAccount($user);

            // grant owner access
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);

            return $this->redirect($this->generateUrl('news_index'));
        }

        return $this->render("ContentBundle:News:form.html.twig", array(
            'form' => $form,
            'action' => 'Create'
        ));
    }

    public function modifyAction($id){
        $em = $this->get('doctrine.orm.entity_manager');
        $news = $em->find('ContentBundle:News', $id);

        $securityContext = $this->container->get('security.context');
        // check for edit access
        if (false === $securityContext->vote('EDIT', $news) && !$securityContext->getUser()->isAdmin())
        {
            throw new \Symfony\Component\Security\Core\Exception\AccessDeniedExceptionAccessDeniedException();
        }

        $form = NewsForm::create($this->get('form.context'), 'news_form');
        $form->bind($this->get('request'), $news);

        if ($form->isValid()){
            $em->persist($form->getData());
            $em->flush();

            return $this->redirect($this->generateUrl('news_index'));
        }

        return $this->render("ContentBundle:News:form.html.twig", array(
            'form' => $form,
            'action' => 'Modify'
        ));
    }

    public function indexAction(){
        $securityContext = $this->get("security.context");
        $user = $securityContext->getUser();
        $news = $user->getContent();
        return $this->render("ContentBundle:News:index.html.twig", array(
            'data' => $news
        ));
    }

    public function deleteAction($id){
        $em = $this->get("doctrine.orm.entity_manager");
        $news = $em->find("ContentBundle:News", $id);

        $securityContext = $this->container->get('security.context');
        // check for edit access
        if (false === $securityContext->vote('DELETE', $news) && !$securityContext->getUser()->isAdmin())
        {
            throw new AccessDeniedException();
        }

        $em->remove($news);
        $em->flush();

        return $this->redirect($this->generateUrl('news_index'));
    }

    public function ViewAction($id){
        $em = $this->get("doctrine.orm.entity_manager");
        $news = $em->getRepository("ContentBundle:News");
        $data = $news->findOneBy(array("url" => $id));
        if (!$data){
            $data = $news->findOneBy(array("Id" => $id));
        }
        if (!$data){
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }
        return $this->render("ContentBundle:News:view.html.twig", array(
            'data' => $data
        ));
    }
}