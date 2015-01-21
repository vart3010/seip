<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use LogicException;
use Pequiven\ObjetiveBundle\Entity\Objetive;
use Pequiven\SEIPBundle\Model\PrePlanning\PrePlanning;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Servicio de pre planificacion (seip.service.preplanning)
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class PrePlanningService extends ContainerAware 
{
    /**
     * Busca el arbol creado para la exportacion de items al siguiente periodo
     * 
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @param \Pequiven\SEIPBundle\Entity\User $user
     * @return type
     */
    public function findRootTreePrePlannig(\Pequiven\SEIPBundle\Entity\Period $period,  \Pequiven\SEIPBundle\Entity\User $user) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning');
        $rootPrePlanning = $repository->findTreePrePlanning($period,$user);
        return $rootPrePlanning;
    }
    
    /**
     * Construye un arbol con los elementos en el periodo anterior
     * @param type $objetivesArray
     * @return type
     */
    public function buildTreePrePlannig($objetivesArray){
        $linkGeneratorService = $this->getLinkGeneratorService();
        $root = $this->createNew();
        foreach ($objetivesArray as $objetiveArray) {
            $objetive = $objetiveArray['parent'];
            $prePlannig = $this->createNew();
            $prePlannig->setOriginObject($objetive);
            $configEntity = $linkGeneratorService->getConfigFromEntity($prePlannig->getOriginObject());
            $prePlannig->setParameters($configEntity);
            
            $childrens = $objetiveArray['childrens'];
//            var_dump($objetive->getRef());
//            var_dump(count($childrens));
            $this->extractDataFromObjective($prePlannig, $objetive);
            
            foreach ($childrens as $children) {
                $prePlannigChild = $this->createNew();
                $prePlannigChild->setOriginObject($children);
                $configEntity = $linkGeneratorService->getConfigFromEntity($prePlannigChild->getOriginObject());
                $prePlannigChild->setParameters($configEntity);
                
                $this->extractDataFromObjective($prePlannigChild, $children);
                $prePlannig->addChildren($prePlannigChild);
            }
            $root->addChildren($prePlannig);
        }
        $user = $this->getUser();
        $period = $this->getPeriodService()->getPeriodActive();
                
        $root->setName(PrePlanning::DEFAULT_NAME);
        $root->setUser($user);
        $root->setPeriod($period);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($root);
        $em->flush();
        
        return $root;
    }
    
    public function buildStructureTree(\Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning $root)
    {
        $tree = $this->getStructureTree($root->getChildrens());
        return $tree;
    }
    
    private function getStructureTree($objects) 
    {
        $tree = array();
        foreach ($objects as $child) {
           $tree[] = $this->getLeaf($child);
        }
        return $tree;
    }
    
    private function getLeaf(\Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning $root) {
        $icon = $root->getParameter('icon');
        $url = $root->getParameter('url');
        $name = $root->getName();
        if($url != ''){
            $name = sprintf('<a href="%s" target="_blank">%s</a>',$url,$name);
        }
        $child = array(
            'id' => $root->getId(),'name' => $name,'leaf' => true, 'iconCls' => $icon
        );
        if(count($root->getChildrens()) > 0){
            $child['expanded'] = true;
            $child['children'] = $this->getStructureTree($root->getChildrens());
            unset($child['leaf']);
        }
        return $child;
    }


    /**
     * Extrae elementos del objetivo
     * @param PrePlanning $prePlannig
     * @param Objetive $objetive
     */
    private function extractDataFromObjective(PrePlanning &$prePlannig,Objetive &$objetive) {
        $arrangementPrograms = $objetive->getArrangementPrograms();
        $indicators = $objetive->getIndicators();
        
        $this->addDataFromObjetive($prePlannig, $arrangementPrograms);
        $this->addDataFromObjetive($prePlannig, $indicators);
    }

    /**
     * Añade elementos a la pre planificacion a partir de los objetivos
     * @param PrePlanning $prePlannig
     * @param type $objects
     */
    private function addDataFromObjetive(PrePlanning &$prePlannig,&$objects) {
        $linkGeneratorService = $this->getLinkGeneratorService();
        foreach ($objects as $object) {
            $prePlannigChild = $this->createNew();
            $prePlannigChild->setOriginObject($object);
            $configEntity = $linkGeneratorService->getConfigFromEntity($prePlannigChild->getOriginObject());
            $prePlannigChild->setParameters($configEntity);
            $prePlannig->addChildren($prePlannigChild);
        }
    }
    
    /**
     * Crea una nueva entidad de pre planificacion.
     * @return \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning
     */
    private function createNew(){
        return new \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning();
    }


    /**
     * @return PeriodService
     */
    private function getPeriodService()
    {
        return $this->container->get('pequiven_arrangement_program.service.period');
    }
    
    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws LogicException If DoctrineBundle is not available
     */
    public function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }
    
    /**
     * Get a user from the Security Context
     *
     * @return mixed
     *
     * @throws LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     */
    public function getUser()
    {
        if (!$this->container->has('security.context')) {
            throw new LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.context')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }
    
    /**
     * 
     * @return LinkGeneratorService
     */
    private function getLinkGeneratorService()
    {
        return $this->container->get('seip.service.link_generator');
    }
}
