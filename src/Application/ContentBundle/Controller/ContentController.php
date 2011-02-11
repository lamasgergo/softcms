<?php
namespace Application\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\Security\Acl\Domain\ObjectIdentity,
    Symfony\Component\Security\Acl\Domain\UserSecurityIdentity,
    Symfony\Component\Security\Acl\Permission\MaskBuilder,
    Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

        $form = ContentForm::create($this->get('form.context'), 'content_create');
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
            $builder = new MaskBuilder();
            $builder->add('view')->add('edit')->add('delete');
            $mask = $builder->get();
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $acl->insertObjectAce($securityIdentity, $mask);
            $aclProvider->updateAcl($acl);
        }

        return $this->render("ContentBundle::create.html.twig", array(
            'form' => $form
        ));
    }

    public function modifyAction($id){
        $em = $this->get('doctrine.orm.entity_manager');
        $content = $em->find('ContentBundle:Content', $id);

        $securityContext = $this->container->get('security.context');
        // check for edit access
        if (false === $securityContext->vote('EDIT', $content))
        {
            throw new AccessDeniedException();
        }

        $form = ContentForm::create($this->get('form.context'), 'content_create');
        $form->bind($this->get('request'), $content);

        if ($form->isValid()){
            $em->persist($form->getData());
            $em->flush();
        }

        return $this->render("ContentBundle::modify.html.twig", array(
            'form' => $form
        ));
    }
}