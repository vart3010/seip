<?php
namespace Pequiven\SEIPBundle\EventListener;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Tecnocreaciones\Bundle\AjaxFOSUserBundle\Event\FormEvent;
use Tecnocreaciones\Bundle\AjaxFOSUserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Doctrine\ORM\EntityManager;
use Pequiven\MasterBundle\Entity\Rol;
/**
 * Description of RegistrationListener
 *
 * @author matias
 */
class RegistrationListener implements EventSubscriberInterface {
    protected $container;
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
    
     static public function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
        );
    }
    
    function onRegistrationSuccess(FormEvent $event) {
        /** @var $user \FOS\UserBundle\Model\UserInterface */
        $user = $event->getForm()->getData();
        $role = $event->getRequest()->get('role');
        //$rol = $this->container->get('pequiven_core.entity.c_rol');
        $rol = new Rol();
        //var_dump($role.'<br>');
        //var_dump(__DIR__);
        
        $em = $this->container->get('doctrine')->getManager();
        $personal = $em->getRepository('PequivenMasterBundle:Personal');
        $rolRepository = $em->getRepository('Pequiven\MasterBundle\Entity\Rol');
        $num_personal = $user->getNumPersonal();
        
        //Consultamos si el usuario registrado se encuentra en la tabla maestra "personal"
        if(is_array($results = $personal->getByNumPersonal($num_personal)) && count($results) > 0){
            foreach($results as $result){
                
//                $user->addGroup(Rol::getRoleName(Rol::ROLE_WORKER_PQV));
                //TODO: Hacer llamado a función (por crear) para determinar el rol del usuario registrado automáticamente
                //var_dump($result->getNomPersonal());
            }
        } else{
            $group = $rolRepository->findOneByName(Rol::getRoleName(Rol::ROLE_WORKER_PQV));
            $user->addGroup($group);//Asignamos el Rol por defecto
            
        }
        
        //var_dump($user.'<br>adios');
        
//        $user->addRole('ROLE_SUPER_ADMIN');
//        if($event->getRequest()->get('role') == 'client'){
//            $user->addRole('ROLE_SUPERVISER');
//        }

        //die();
    }
    
    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    private function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }
}
