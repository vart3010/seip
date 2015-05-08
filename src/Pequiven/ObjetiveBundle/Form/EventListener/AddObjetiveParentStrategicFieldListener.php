<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\ObjetiveBundle\Form\EventListener;

/**
 * Description of AddObjetiveParentStrategicFieldListener
 *
 * @author matias
 */
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Pequiven\ObjetiveBundle\PequivenObjetiveBundle;
use Pequiven\MasterBundle\Entity\Complejo;
use Doctrine\ORM\EntityRepository;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;

/**
 * Descripción del Listener del Description of AddObjetiveLevelFieldListener
 *
 * @author matias
 */
class AddObjetiveParentStrategicFieldListener implements EventSubscriberInterface{
    
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
    
    public function preSetData(FormEvent $event) {
        $object = $event->getData();
        $form = $event->getForm();

        if (null === $object) {
            return $this->addObjetiveParentStrategicForm($form,$object['lineStrategic']);
        }

        $this->addObjetiveParentStrategicForm($form,$object['lineStrategic'],$object);
    }

    public function preSubmit(FormEvent $event) {
        $form = $event->getForm();
        $object = $event->getData();
        
        $lineStrategicId = array_key_exists('lineStrategic', $object) ? $object['lineStrategic'] : null;

        $this->addObjetiveParentStrategicForm($form,$lineStrategicId);
    }

    private function addObjetiveParentStrategicForm($form,$lineStrategicId,$objetiveParent = null) {
        
        $formOptions = array(
            'class' => 'PequivenObjetiveBundle:Objetive',
            'empty_value' => '',
            'label' => 'form.parent_strategic',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'description',
            'attr' => array('class' => 'populate placeholder select2-offscreen','style' => 'width:400px')
        );

        if ($objetiveParent) {
            $formOptions['data'] = $objetiveParent;
        }

        //En caso de que el usuario tenga un rol superior a Gerente de 2da línea
        if($this->securityContext->isGranted(array('ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX','ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX','ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_WORKER_PLANNING'))){
            //En caso de que el formulario sea el de objetivo operativo
            if($this->typeOperative){
                $formOptions['mapped'] = false;
                //En caso de que el formulario sea el de indicador operativo
                if($this->registerIndicator){
                    $formOptions['required'] = false;
                }
                return $form->add('parent_strategic', 'entity', $formOptions);
            } else{
                $formOptions['attr'] = array('class' => 'populate placeholder select2-offscreen','multiple' => 'multiple','style' => 'width:400px');
                $formOptions['multiple'] = true;
                if($this->registerIndicator){
                    $formOptions['mapped'] =false;
                    $formOptions['required'] = false;
                }
                return $form->add('parents', 'entity', $formOptions);
            }
        } elseif ($this->securityContext->isGranted(array('ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
            $formOptions['mapped'] = false;
            if($this->registerIndicator){
                $formOptions['required'] = false;
                return $form->add('parents', 'entity', $formOptions);
            } else{
                return $form->add('parent_strategic', 'entity', $formOptions);
            }
        }
    }
}
