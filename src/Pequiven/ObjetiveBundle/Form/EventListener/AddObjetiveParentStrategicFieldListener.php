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
use Pequiven\ObjetiveBundle\PequivenObjetiveBundle;
use Pequiven\MasterBundle\Entity\Complejo;
use Doctrine\ORM\EntityRepository;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;

/**
 * Description of AddObjetiveLevelFieldListener
 *
 * @author matias
 */
class AddObjetiveParentStrategicFieldListener implements EventSubscriberInterface{
    
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
    protected $complejo;
    
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
        $this->complejo = $this->gerencia->getComplejo();
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
            'empty_value' => 'Seleccione el objetivo estratégico',
            'label' => 'form.parent_strategic',
            'label_attr' => array('class' => 'label'),
            'translation_domain' => 'PequivenObjetiveBundle',
            'property' => 'description',
            'attr' => array('class' => 'populate select2-offscreen red-gradient','style' => 'width:50%')
        );
        
        $objetiveLevel = new ObjetiveLevel();
        $objetiveLevelName = $objetiveLevel->getLevelNameArray();
        
        $this->getTypePersonal(array('ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND_AUX'));
        if($this->complejo->getComplejoName() === $this->complejoNameArray[\Pequiven\MasterBundle\Entity\Complejo::COMPLEJO_ZIV]){
            $formOptions['query_builder'] = function (EntityRepository $er) use ($lineStrategicId){
            $qb = $er->createQueryBuilder('objetive')
                     ->where('objetive.lineStrategic = :lineStrategicId AND objetive.objetiveLevel = :objetiveLevelId')
                     ->groupBy('objetive.ref')
                     ->setParameter('lineStrategicId', $lineStrategicId)
                     ->setParameter('objetiveLevelId', ObjetiveLevel::LEVEL_ESTRATEGICO)
                    ;
//            var_dump($qb->getQuery()->getSQL());
//            die();
            return $qb;
            };
        } else{
            $complejoId = $this->complejo->getId();
            $formOptions['query_builder'] = function (EntityRepository $er) use ($lineStrategicId,$complejoId){
            $qb = $er->createQueryBuilder('objetive')
                     ->where('objetive.lineStrategic = :lineStrategicId AND objetive.objetiveLevel = :objetiveLevelId AND objetive.complejo = :complejoId')
                     ->groupBy('objetive.ref')
                     ->setParameter('lineStrategicId', $lineStrategicId)
                     ->setParameter('complejoId', $complejoId)
                     ->setParameter('objetiveLevelId', ObjetiveLevel::LEVEL_ESTRATEGICO)
                    ;
            return $qb;
            };
        }
        
        //$complejoId = $gerencia->getComplejo()->getId();
        //$objetiveLevelId = $em->getRepository('PequivenObjetiveBundle:ObjetiveLevel')->findOneBy(array('levelName' => $objetiveLevelName[ObjetiveLevel::LEVEL_ESTRATEGICO]))->getId();

        if ($objetiveParent) {
            $formOptions['data'] = $objetiveParent;
        }
        
        if($this->securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX'))){
            return $form->add('parent', 'entity', $formOptions);
        } elseif ($this->securityContext->isGranted(array('ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
            return $form->add('parent_strategic', 'entity', $formOptions);
        }
    }

}
