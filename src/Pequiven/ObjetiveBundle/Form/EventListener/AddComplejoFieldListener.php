<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ObjetiveBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
use Pequiven\ObjetiveBundle\PequivenObjetiveBundle;
use Pequiven\MasterBundle\Entity\Complejo;
use Doctrine\ORM\EntityRepository;

/**
 * Description of AddComplejoFieldListener
 *
 * @author matias
 */
class AddComplejoFieldListener implements EventSubscriberInterface {
    //put your code here
    protected $container;
    protected $securityContext;
    protected $user;
    protected $em;
    
    protected $realUser;
    protected $personal;
    
    protected $complejoObject;
    protected $complejoNameArray = array();
    protected $cargo;
    protected $gerencia;
    
    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
                );
    }
    
    public function __construct() {
        $this->container = PequivenObjetiveBundle::getContainer();
        $this->securityContext = $this->container->get('security.context');
        $this->user = $this->securityContext->getToken()->getUser();
        $this->em = $this->container->get('doctrine')->getManager();
        
        $this->complejoObject = new Complejo();
        $this->complejoNameArray = $this->complejoObject->getComplejoNameArray();
    }
    
    /**
     * Función que define el cargo y gerencia dea cuerdo al tipo de persona que este logueada
     * @param type $roles
     */
    public function getTypePersonal($roles = array()){
        if($this->securityContext->isGranted($roles)){
            $this->realUser = $this->em->getRepository('PequivenSEIPBundle:User')->findOneBy(array('id' => $this->user->getParent()->getId()));
            $this->personal = $this->em->getRepository('PequivenMasterBundle:Personal')->findOneBy(array('numPersonal' => $this->realUser->getNumPersonal()));
        } else{
            $this->personal = $this->em->getRepository('PequivenMasterBundle:Personal')->findOneBy(array('numPersonal' => $this->user->getNumPersonal()));
        }
        $this->cargo = $this->em->getRepository('PequivenMasterBundle:Cargo')->findOneBy(array('id' => $this->personal->getCargo()->getId()));
        $this->gerencia = $this->em->getRepository('PequivenMasterBundle:Gerencia')->findOneBy(array('id' => $this->cargo->getGerencia()->getId()));
    }
    
    public function preSetData(FormEvent $event){
        $object = $event->getData();
        $form = $event->getForm();
        $objetiveStrategicId = null;
        
        if(null === $object){
            return $this->addComplejoForm($form,$objetiveStrategicId, $object);
        }
        
        $this->getTypePersonal(array('ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND_AUX'));
        if($this->gerencia->getComplejo()->getComplejoName() === $this->complejoNameArray[Complejo::COMPLEJO_ZIV]){
            $objetiveStrategicId = array_key_exists('parent', $object) ? $object['parent'] : null;
        }
        $this->addComplejoForm($form,$objetiveStrategicId, $object);
    }
    
    public function preSubmit(FormEvent $event){
        $form = $event->getForm();
        $object = $event->getData();
        
        $objetiveStrategicId = null;
        if($this->gerencia->getComplejo()->getComplejoName() === $this->complejoNameArray[Complejo::COMPLEJO_ZIV]){
            $objetiveStrategicId = array_key_exists('parent', $object) ? $object['parent'] : null;
        }
        $this->addComplejoForm($form,$objetiveStrategicId);
    }
    
    public function addComplejoForm($form,$objetiveStrategicId = null, $complejo = null){
        
        $type = 'entity';
        $formOptions = array(
            'class' => 'PequivenMasterBundle:Complejo',
            'label' => 'form.complejo',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'description'
        );
        
        if($this->securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
            $formOptions['empty_value'] =  'Todo';
            $formOptions['multiple'] = true;
            $formOptions['mapped'] = false;
            $formOptions['attr'] = array('class' => 'populate placeholder select2-offscreen','multiple' => 'multiple','style' => 'width:300px');
            //$formOptions['attr'] = array('class' => 'selectMultiple multiple white-gradient easy-multiple-selection check-list replacement');
        } else{
            $formOptions['empty_value'] = 'Seleccione su Complejo';
            $this->getTypePersonal(array('ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND_AUX'));

            $complejo = $complejo == null ? $this->gerencia->getComplejo() : $complejo;
            $complejoId = $this->gerencia->getComplejo()->getId();
            
            if($this->gerencia->getComplejo()->getComplejoName() === $this->complejoNameArray[Complejo::COMPLEJO_ZIV]){
                $formOptions['empty_value'] = 'Todo';
                $formOptions['multiple'] = true;
                //$formOptions['expanded'] = true;
                $formOptions['mapped'] = false;
                $formOptions['attr'] = array('class' => 'select multiple-as-single red-gradient easy-multiple-selection check-list replacement','multiple' => 'multiple', 'style' => 'width:300px');
                //$formOptions['attr'] = array('class' => 'checkbox mid-margin-left replacement','style' => 'width:800px');
                //$formOptions['attr'] = array('class' => 'populate placeholder select2-offscreen','multiple' => 'multiple','style' => 'width:300px');
                
                //TODO: Optimizar este proceso de carga de los complejos en caso de que el usuario pertenezca a la Sede Corporativa
                $results = $this->em->getRepository('PequivenMasterBundle:Complejo')->findBy(array("id" => array(1,2,3,4,5,6)));
                
                $complejo = $results;
            } else{
                $formOptions['query_builder'] = function(EntityRepository $er) use ($complejoId){
                    $qb = $er->createQueryBuilder('complejo')
                             ->where('complejo.id = :complejoId')
                             ->setParameter('complejoId', $complejoId)
                            ;
                    return $qb;
                };
                $formOptions['attr'] = array('class' => 'select red-gradient check-list replacement', 'style' => 'width:300px');
            }
        }
        
        if($complejo){
            $formOptions['data'] = $complejo;
        }

        $form->add('complejo','entity',$formOptions);
    }
}
