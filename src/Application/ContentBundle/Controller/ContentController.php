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

        $contentRequest = new Content();
        $contentRequest->setUser($this->user);
        $contentRequest->setType($this->type);

        $form = ContentForm::create($this->get('form.context'), 'content_create');
        $form->bind($this->get('request'), $contentRequest);

        if ($form->isValid()){
            $em->persist($form->getData());
            $em->flush();

            // creating the ACL
            $aclProvider = $this->container->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($contentRequest);
            $acl = $aclProvider->createAcl($objectIdentity);

            // retrieving the security identity of the currently logged-in user
            $securityContext = $this->container->get('security.context');
            $user = $securityContext->getToken()->getUser();
            $securityIdentity = UserSecurityIdentity::fromAccount($user);

            // grant owner access
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);
        }

        return $this->render("ContentBundle::create.html.twig", array(
            'form' => $form
        ));
    }
}