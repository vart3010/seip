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
    //put your code here
    protected $container;
    
//    public function __construct(ContainerInterface $container) {
//        $this->container = $container;
//    }
    
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
        $num_personal = $user->getNumPersonal();
        
        //Consultamos si el usuario registrado se encuentra en la tabla maestra "personal"
        if(is_array($results = $personal->getByNumPersonal($num_personal)) && count($results) > 0){
            foreach($results as $result){
                $user->addRole($rol->rol_name[Rol::ROLE_MANAGER_SECOND]);
                //TODO: Hacer llamado a función (por crear) para determinar el rol del usuario registrado automáticamente
                //var_dump($result->getNomPersonal());
            }
        } else{
            $user->addRole($rol->rol_name[Rol::ROLE_DEFAULT]);//Asignamos el Rol por defecto
            var_dump($user);
            die();
        }
        
        //var_dump($user.'<br>adios');
        
//        $user->addRole('ROLE_SUPER_ADMIN');
//        if($event->getRequest()->get('role') == 'client'){
//            $user->addRole('ROLE_SUPERVISER');
//        }

        //die();
    }
}
