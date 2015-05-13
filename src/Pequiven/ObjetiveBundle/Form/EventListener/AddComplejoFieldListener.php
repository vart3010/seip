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
use Symfony\Component\DependencyInjection\ContainerInterface;
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
    
    protected $complejoObject;
    protected $complejoNameArray = array();
    protected $typeOperative = false;
    protected $registerIndicator = false;
    
    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
                );
    }
    
    /**
     * 
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param type $options
     */
    public function __construct(ContainerInterface $container,$options = array()) {
        $this->container = $container;
        $this->securityContext = $this->container->get('security.context');
        $this->user = $this->securityContext->getToken()->getUser();
        $this->em = $this->container->get('doctrine')->getManager();
        
        $this->complejoObject = new Complejo();
        $this->complejoNameArray = $this->complejoObject->getRefNameArray();
        
        if(isset($options['typeOperative'])){
            $this->typeOperative = true;
        }
        if(isset($options['registerIndicator'])){
            $this->registerIndicator = true;
        }
    }
    
    public function preSetData(FormEvent $event){
        $object = $event->getData();
        $form = $event->getForm();
        $objetiveStrategicId = null;
        
        if(null === $object){
            return $this->addComplejoForm($form,$objetiveStrategicId, $object);
        }
        
//        $this->getTypePersonal(array('ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND_AUX'));
        if($this->user->getComplejo()->getRef() === $this->complejoNameArray[Complejo::COMPLEJO_ZIV]){
            $objetiveStrategicId = array_key_exists('parent', $object) ? $object['parent'] : null;
        }
        
        $this->addComplejoForm($form,$objetiveStrategicId, $object);
    }
    
    public function preSubmit(FormEvent $event){
        $form = $event->getForm();
        $object = $event->getData();
        
        $objetiveStrategicId = null;
        
        if($this->user->getComplejo()->getRef() === $this->complejoNameArray[Complejo::COMPLEJO_ZIV]){
            $objetiveStrategicId = array_key_exists('parent', $object) ? $object['parent'] : null;
        }
  
        $this->addComplejoForm($form,$objetiveStrategicId);
    }
    
    public function addComplejoForm($form,$objetiveStrategicId = null, $complejo = null){

        $type = 'entity';
        $formOptions = array(
            'class' => 'PequivenMasterBundle:Complejo',
            'label' => 'form.location',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'description'
        );

        if($this->securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX','ROLE_WORKER_PLANNING'))){
//            $formOptions['empty_value'] =  'Todo';
            $formOptions['multiple'] = true;
            $formOptions['mapped'] = false;
            //$formOptions['attr'] = array('class' => 'selectMultiple multiple white-gradient easy-multiple-selection check-list replacement');
            if($this->typeOperative){
              //$results = $this->em->getRepository('PequivenMasterBundle:Complejo')->findBy(array("id" => array(1,2,3,4,5,6)));  
                $results = array();
                $formOptions['attr'] = array('class' => 'populate placeholder select2-offscreen','multiple' => 'multiple','style' => 'width:300px');
                if($this->registerIndicator){
                    $formOptions['multiple'] = false;
                    $formOptions['attr'] = array('class' => 'populate select2-offscreen','style' => 'width:300px');
                    $formOptions['mapped'] =false;
                    $formOptions['required'] = false;
                }
                //$formOptions['attr'] = array('style' => 'width:400px', 'size' => 6);
            } else{
                //$formOptions['attr'] = array('class' => 'select multiple-as-single red-gradient easy-multiple-selection check-list replacement','multiple' => 'multiple', 'style' => 'width:300px');
                $formOptions['attr'] = array('class' => 'select2-container select2-container-multi','multiple' => 'multiple', 'style' => 'width:300px');
                $results = $this->em->getRepository('PequivenMasterBundle:Complejo')->findBy(array("enabled" => true));
                $results = array();
                if($this->registerIndicator){
                    $formOptions['multiple'] = false;
                    $formOptions['attr'] = array('class' => 'populate select2-offscreen','style' => 'width:300px');
                    $formOptions['mapped'] =false;
                    $formOptions['required'] = false;
                }
            }
            $complejo = $results;
        } else{
//            $formOptions['empty_value'] = 'Seleccione su Complejo';
//            $this->getTypePersonal(array('ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND_AUX'));

            $complejo = $complejo == null ? $this->user->getComplejo() : $complejo;
            $complejoId = $this->user->getComplejo()->getId();
            
            if($this->user->getComplejo()->getRef() === $this->complejoNameArray[Complejo::COMPLEJO_ZIV]){
//                $formOptions['empty_value'] = 'Todo';
                //$formOptions['multiple'] = true;
                //$formOptions['expanded'] = true;
                $formOptions['mapped'] = false;
                //$formOptions['attr'] = array('class' => 'select multiple-as-single red-gradient easy-multiple-selection check-list replacement','multiple' => 'multiple', 'style' => 'width:300px');
                //$formOptions['attr'] = array('class' => 'checkbox mid-margin-left replacement','style' => 'width:800px');
                //$formOptions['attr'] = array('class' => 'populate placeholder select2-offscreen','multiple' => 'multiple','style' => 'width:300px');
                
                
                if($this->typeOperative){
                    $results = array();
                    //$formOptions['attr'] = array('style' => 'width:400px', 'size' => 6);
                    if($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX'))){
                        $formOptions['multiple'] = true;
                        $formOptions['attr'] = array('class' => 'populate placeholder select2-offscreen','multiple' => 'multiple', 'style' => 'width:300px');
                    } elseif($this->securityContext->isGranted(array('ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
                        $formOptions['attr'] = array('class' => 'populate placeholder select2-offscreen','multiple' => 'multiple', 'style' => 'width:300px');
                    }
                } else{
                  $formOptions['attr'] = array('class' => 'select multiple-as-single red-gradient check-list replacement','multiple' => 'multiple', 'style' => 'width:300px');
                  //$results = $this->em->getRepository('PequivenMasterBundle:Complejo')->findBy(array("enabled" => true));
                  $results = array();
                  $formOptions['choices'] = $this->em->getRepository('PequivenMasterBundle:Complejo')->getByGerencia();
                }
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
