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
use Doctrine\Common\Util\ClassUtils;
use InvalidArgumentException;
use LogicException;
use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\IndicatorBundle\Model\IndicatorLevel;
use Pequiven\ObjetiveBundle\Entity\Objetive;
use Pequiven\SEIPBundle\Entity\Period;
use Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning;
use Pequiven\SEIPBundle\Entity\User;
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
     *
     * @var \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningUser
     */
    private $currentBuildPrePlanning;
    
    /**
     * Busca el arbol creado para la exportacion de items al siguiente periodo
     * 
     * @param Period $period
     * @param User $user
     * @return \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningUser
     */
    public function findRootTreePrePlannig(Period $period,  User $user,$level) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningUser');
        $rootPrePlanning = $repository->findTreePrePlanning($period,$user,$level);
        return $rootPrePlanning;
    }
    
    /**
     * Busca el arbol creado para la exportacion de items al siguiente periodo
     * 
     * @param Period $period
     * @param User $user
     * @return \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningUser
     */
    public function findRootTreePrePlannigById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningUser');
        $rootPrePlanning = $repository->find($id);
        return $rootPrePlanning;
    }
    
    /**
     * Construye un arbol con los elementos en el periodo anterior
     * @param type $objetivesArray
     * @return type
     */
    public function buildTreePrePlannig($objetivesArray,$levelPlanning){
        
        if($levelPlanning == PrePlanning::LEVEL_TACTICO && !$this->isGranted('ROLE_SEIP_PRE_PLANNING_CREATE_TACTIC')){
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Usted no tiene permiso para pre planificar el nivel tactico.');
        }elseif ($levelPlanning == PrePlanning::LEVEL_OPERATIVO && !$this->isGranted('ROLE_SEIP_PRE_PLANNING_CREATE_OPERATIVE')) {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Usted no tiene permiso para pre planificar el nivel operativo.');
        }
            
        $em = $this->getDoctrine()->getManager();
        
        $linkGeneratorService = $this->getLinkGeneratorService();
        $user = $this->getUser();
        $period = $this->getPeriodService()->getEntityPeriodActive();
        $prePlanningUser = new \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningUser();
        $this->setCurrentBuildPrePlanning($prePlanningUser);
        
        $root = $this->createNew();
        $root->setName(PrePlanning::DEFAULT_NAME);
        $root->setLevelPlanning($levelPlanning);
        
        foreach ($objetivesArray as $objetiveArray) {
            $objetive = $objetiveArray['parent'];
            $prePlannig = $this->createNew();
            $this->setOriginObject($prePlannig,$objetive,$levelPlanning);
            $configEntity = $linkGeneratorService->getConfigFromEntity($objetive);
            $prePlannig->setParameters($configEntity);
            
            $childrens = $objetiveArray['childrens'];
            $this->extractDataFromObjective($prePlannig, $objetive,$levelPlanning);
            
            $this->buildChildren($childrens, $prePlannig,$levelPlanning);
            
            $root->addChildren($prePlannig);
        }
        
        $configuration = $user->getConfiguration();
        $prePlanningConfiguration = $configuration->getPrePlanningConfiguration();
        
        $prePlanningUser
                ->setUser($user)
                ->setPeriod($period)
                ;
        if($levelPlanning == PrePlanning::LEVEL_TACTICO && $this->isGranted('ROLE_SEIP_PRE_PLANNING_CREATE_TACTIC')){
            $prePlanningUser->setGerenciaFirst($prePlanningConfiguration->getGerencia());
        }elseif ($levelPlanning == PrePlanning::LEVEL_OPERATIVO && $this->isGranted('ROLE_SEIP_PRE_PLANNING_CREATE_OPERATIVE')) {
            $prePlanningUser->setGerenciaSecond($prePlanningConfiguration->getGerenciaSecond());
        }
        $prePlanningUser
            ->setPrePlanningRoot($root)
            ->setLevelPlanning($levelPlanning)
            ;
        $prePlanningUser->setRef($this->getSequenceGenerator()->getNextRefPrePlanningUser($prePlanningUser));
        
        $em->persist($prePlanningUser);
        $em->flush();
        
        return $root;
    }
    
    private function setOriginObject(PrePlanning &$prePlanning,$object,$levelPlanning)
    {
        $user = $this->getUser();
        $configuration = $user->getConfiguration();
        $prePlanningConfiguration = $configuration->getPrePlanningConfiguration();
        
        $isEditable = false;
        $requiresApproval = false;
        if($this->isGranted('ROLE_SEIP_PRE_PLANNING_CREATE_TACTIC') && $prePlanningConfiguration->getGerencia() !== null){
            
        }elseif($this->isGranted('ROLE_SEIP_PRE_PLANNING_CREATE_OPERATIVE') && $prePlanningConfiguration->getGerenciaSecond() !== null){
            $requiresApproval = true;
        }
        
        $idSourceObject = $object->getId();
        $class = ClassUtils::getRealClass(get_class($object));
        $levelObject = null;
        if($class == 'Pequiven\ObjetiveBundle\Entity\Objetive'){
            $typeObject = PrePlanning::TYPE_OBJECT_OBJETIVE;
            $levelObject = $object->getObjetiveLevel()->getLevel();
            $prePlanning->setRequiredToImport($object->getRequiredToImport());
            $prePlanning->setRequiresApproval($requiresApproval);
            $this->getCurrentBuildPrePlanning()->setContentObjetive(true);
            
        }else if($class == 'Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram'){
            $typeObject = PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM;
            $type = $object->getType();
            if($type == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC){
                $levelObject = PrePlanning::LEVEL_TACTICO;
            }else if($type == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
                $levelObject = PrePlanning::LEVEL_OPERATIVO;
            }
            $this->getCurrentBuildPrePlanning()->setContentArrangementProgram(true);
            
        }else if($class == 'Pequiven\IndicatorBundle\Entity\Indicator'){
            $typeObject = PrePlanning::TYPE_OBJECT_INDICATOR;
            if($object->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_ESTRATEGICO){
                $levelObject = PrePlanning::LEVEL_ESTRATEGICO;
            }else if($object->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_TACTICO){
                $levelObject = PrePlanning::LEVEL_TACTICO;
            }else if($object->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_OPERATIVO){
                $levelObject = PrePlanning::LEVEL_OPERATIVO;
            }
            $prePlanning->setRequiredToImport($object->getRequiredToImport());
            $this->getCurrentBuildPrePlanning()->setContentIndicator(true);
            
        }else if($class == 'Pequiven\ArrangementProgramBundle\Entity\Goal'){
            $typeObject = PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM_GOAL;
            $type = $object->getTimeline()->getArrangementProgram()->getType();
            
            if($type == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC){
                $levelObject = PrePlanning::LEVEL_TACTICO;
            }else if($type == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
                $levelObject = PrePlanning::LEVEL_OPERATIVO;
            }
            $this->getCurrentBuildPrePlanning()->setContentArrangementProgramGoal(true);
        }else {
            throw new InvalidArgumentException(sprintf('The object class "%s" is not admited',$class));
        }
        if($this->isGranted('ROLE_SEIP_PRE_PLANNING_CREATE_OPERATIVE') && $prePlanningConfiguration->getGerenciaSecond() !== null && $levelObject == PrePlanning::LEVEL_OPERATIVO && $levelPlanning == PrePlanning::LEVEL_OPERATIVO){
            $isEditable = true;
        }else if($this->isGranted('ROLE_SEIP_PRE_PLANNING_CREATE_TACTIC') && $prePlanningConfiguration->getGerencia() !== null && $levelObject == PrePlanning::LEVEL_TACTICO && $levelPlanning == PrePlanning::LEVEL_TACTICO){
            $isEditable = true;
        }
        
        $prePlanning->setName(((string)$object));
        $prePlanning->setTypeObject($typeObject);
        $prePlanning->setIdSourceObject($idSourceObject);
        $prePlanning->setLevelObject($levelObject);
        $prePlanning->setEditable($isEditable);
    }
    
    private function buildChildren($childrens,&$prePlannig,$levelPlanning) {
        $linkGeneratorService = $this->getLinkGeneratorService();
        foreach ($childrens as $children) {
                $prePlannigChild = $this->createNew();
                $this->setOriginObject($prePlannigChild,$children,$levelPlanning);
                $configEntity = $linkGeneratorService->getConfigFromEntity($children);
                $prePlannigChild->setParameters($configEntity);

                $this->extractDataFromObjective($prePlannigChild, $children,$levelPlanning);
                if(count($children->getChildrens()) > 0){
                    $subChildren = $children->getChildrens();
                    $this->buildChildren($subChildren, $prePlannigChild,$levelPlanning);
                }
                $prePlannig->addChildren($prePlannigChild);
            }
    }


    public function buildStructureTree(PrePlanning $root)
    {
        $tree = $this->getStructureTree($root->getChildrens(),0);
        return $tree;
    }
    
    private function getStructureTree($objects,$limitCurrentLevel) 
    {
        $tree = array();
        foreach ($objects as $child) {
           $tree[] = $this->getLeaf($child,$limitCurrentLevel);
        }
        return $tree;
    }
    
    private function getLeaf(PrePlanning $item,$limitCurrentLevel)
    {
        $icon = $item->getParameter('icon');
        $url = $item->getParameter('url');
        $expanded = $item->getParameter('expanded',true);
        $name = ToolService::normalizeStr($item->getName());
        $nameSumary = ToolService::truncate($name, array(
            'limit' => 130
        ));
        
        if($url != ''){
            $name = sprintf('<a href="%s" target="_blank" title="%s">%s</a>',$url,$name,$nameSumary);
        }
        $cloneService = $this->getCloneService();
        $itemInstance = $cloneService->findInstancePrePlanning($item);
        $itemInstanceCloned = $cloneService->findCloneInstance($itemInstance);
        if($item->isRequiresApproval()){
            if($itemInstanceCloned){
//                $name .= ' <span class="green">(Aprobado)</span>';
            }else{
//                $name .= ' <span class="red">(Requiere Aprobación)</span>';
            }
        }
        $parentId = $parent = null;
        $parent = $item->getParent();
        if($parent)
        {
            $parentId = $parent->getId();
        }
        $child = array(
            'id' => $item->getId(),
            'name' => $name,
            'leaf' => true,
            'iconCls' => $icon,
            'editable' => $item->isEditable(),
            'parentId' => $parentId,
            'toImport' => $item->getToImport(),
            'status' => $item->getStatus(),
            '_statusLabel' => '',
            '_hasPermissionRevision' => false,
            '_isImportable' => false,
        );
        
        if($item->getLevelObject() == PrePlanning::LEVEL_OPERATIVO 
            &&  $item->getParent() 
//            && $item->getTypeObject() != PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM
            && $item->getTypeObject() != PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM_GOAL
        )
        {
            $parentItemInstance = $this->getCloneService()->findInstancePrePlanning($item->getParent());
            $parentItemInstanceCloned = $this->getCloneService()->findCloneInstance($parentItemInstance);
            if(!$parentItemInstanceCloned){
//                $child['editable'] = false;
            }
        }
        
        if(($item->getStatus() == PrePlanning::STATUS_IMPORTED && !$itemInstanceCloned)){
            $item->setStatus(PrePlanning::STATUS_IMPORTED_AND_DELETED);
            $this->persist($item,true);
        }
        if($itemInstanceCloned && $item->getStatus() != PrePlanning::STATUS_IMPORTED){
            $item->setStatus(PrePlanning::STATUS_IMPORTED);
            $this->persist($item,true);
        }
        
        $classStatus = 'red';
        if($item->getStatus() == PrePlanning::STATUS_APPROVED){
            $classStatus = 'green';
        }elseif($item->getStatus() == PrePlanning::STATUS_IN_REVIEW){
            $classStatus = 'blue';
        }
        $child['_statusLabel'] = sprintf('<span class="%s">%s</span>',$classStatus,$this->trans($item->getLabelStatus()));
        $_hasPermissionRevision = false;
        if($itemInstanceCloned){
            $child['status'] = PrePlanning::STATUS_IMPORTED;
            //Las metas no tienen link por lo tanto genero el link del programa
            if($item->getTypeObject() == PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM_GOAL){
                $configEntity = $this->getLinkGeneratorService()->getConfigFromEntity($itemInstanceCloned->getTimeline()->getArrangementProgram());
            }else{
                $configEntity = $this->getLinkGeneratorService()->getConfigFromEntity($itemInstanceCloned);
            }
            $child['_statusLabel'] = sprintf('<a href="%s" target="_blank"><span class="green">Importado</span></a>',$configEntity['url']);
        }else{
            if($item->getTypeObject() == PrePlanning::TYPE_OBJECT_INDICATOR && $this->isGranted('ROLE_SEIP_PRE_PLANNING_OPERATION_IMPORT_STATISTICS_INDICATOR')){
                $_hasPermissionRevision = true;
            }else if($item->getTypeObject() == PrePlanning::TYPE_OBJECT_OBJETIVE && $this->isGranted('ROLE_SEIP_PRE_PLANNING_OPERATION_IMPORT_PLANNING_OBJETIVE')){
                $_hasPermissionRevision = true;
            }else if($item->getTypeObject() == PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM && $this->isGranted('ROLE_SEIP_PRE_PLANNING_OPERATION_IMPORT_PLANNING_ARRANGEMENT_PROGRAM')){
                $_hasPermissionRevision = true;
            }else if($item->getTypeObject() == PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM_GOAL && $this->isGranted('ROLE_SEIP_PRE_PLANNING_OPERATION_IMPORT_PLANNING_ARRANGEMENT_PROGRAM_GOAL')){
                $_hasPermissionRevision = true;
            }
            //No verificar dependencia para importar todo
            /**
            if($_hasPermissionRevision && $parent && PrePlanning::isValidTypeObject($parent->getTypeObject())){
                if($item->getTypeObject() != PrePlanning::TYPE_OBJECT_OBJETIVE){
                    $itemParentInstance = $cloneService->findInstancePrePlanning($parent);
                    $itemParentInstanceCloned = $cloneService->findCloneInstance($itemParentInstance);
                    if(!$itemParentInstanceCloned){
                        $_hasPermissionRevision = false;
                    }
                }
            }
             */
            $child['_hasPermissionRevision'] = $_hasPermissionRevision;
        }
        if($_hasPermissionRevision && ($item->getStatus() == PrePlanning::STATUS_IN_REVIEW || $item->getStatus() == PrePlanning::STATUS_REQUIRED || $item->getStatus() == PrePlanning::STATUS_IMPORTED_AND_DELETED)){
            $child['_isImportable'] = true;
        }
        if(count($item->getChildrens()) > 0){
            $limitLevel = 3;
            if($limitCurrentLevel < $limitLevel){
//                $child['expanded'] = $expanded;
                $child['expanded'] = true;
                $child['children'] = $this->getStructureTree($item->getChildrens(), ($limitCurrentLevel+1));
            }else{
                $child['expanded'] = false;
            }
            $child['leaf'] = false;
        }
        $child['status'] = $item->getStatus();
        return $child;
    }
    
    /**
     * Importa una pre planificacion
     * @param PrePlanning $prePlanning
     * @param User $user
     * @return boolean
     * @throws \Pequiven\SEIPBundle\Service\Exception
     */
    public function importItem(PrePlanning $prePlanning,User $user) 
    {
        $success = false;
        $permission = array(
            PrePlanning::TYPE_OBJECT_INDICATOR => 'ROLE_SEIP_PRE_PLANNING_OPERATION_IMPORT_STATISTICS_INDICATOR',
            PrePlanning::TYPE_OBJECT_OBJETIVE => 'ROLE_SEIP_PRE_PLANNING_OPERATION_IMPORT_PLANNING_OBJETIVE',
            PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM => 'ROLE_SEIP_PRE_PLANNING_OPERATION_IMPORT_PLANNING_ARRANGEMENT_PROGRAM',
            PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM_GOAL => 'ROLE_SEIP_PRE_PLANNING_OPERATION_IMPORT_PLANNING_ARRANGEMENT_PROGRAM_GOAL',
        );
        $perm = null;
        if(isset($permission[$prePlanning->getTypeObject()])){
            $perm = $permission[$prePlanning->getTypeObject()];
        }
        $this->getSecurityService()->checkSecurity($perm);
        
        $parent = $prePlanning->getParent();
        $validToImport = true;
        if($parent && $parent->getTypeObject() != PrePlanning::TYPE_OBJECT_ROOT_NODE){
            if($parent->getStatus() !== PrePlanning::STATUS_IMPORTED){
                $validToImport = false;
                $success = 'Es obligatorio importar el item padre.';
            }
        }
        if($validToImport && ($prePlanning->getStatus() == PrePlanning::STATUS_IN_REVIEW || $prePlanning->getStatus() == PrePlanning::STATUS_REQUIRED || $prePlanning->getStatus() == PrePlanning::STATUS_IMPORTED_AND_DELETED))
        {
            $em = $this->getDoctrine()->getManager();
            $cloneService = $this->getCloneService();
            $sequenceGenerator = $this->getSequenceGenerator();
            
            $typeObject = $prePlanning->getTypeObject();
            $itemInstance = $this->getCloneService()->findInstancePrePlanning($prePlanning);
            if($itemInstance){
                $em->getConnection()->beginTransaction(); // suspend auto-commit

                try {
                    $itemInstanceCloned = null;
                    if($typeObject == PrePlanning::TYPE_OBJECT_OBJETIVE)
                    {
                        $level = $itemInstance->getObjetiveLevel()->getLevel();
                        $parents = $itemInstance->getParents();

                            $parentsCloned = array();
                            foreach ($parents as $parent) {//Cloar los objetivos estrategicos aqui se mantiene la referencia
                                $cloneObjetive = $cloneService->cloneObject($parent);
                                $parentsCloned[] = $cloneObjetive;
                            }
                            $itemInstanceCloned = $cloneService->findCloneInstance($itemInstance);
                            if(!$itemInstanceCloned){
                                $itemInstanceCloned = $cloneService->cloneObject($itemInstance);
                                foreach ($parentsCloned as $parentCloned) {
                                    $parentCloned->addChildren($itemInstanceCloned);
                                    $this->persist($parentCloned);
                                }
                                if($level == \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_ESTRATEGICO){
                                    $ref = $itemInstance->getRef();
                                }else{
                                    $ref = $sequenceGenerator->getNextRefChildObjetive($itemInstanceCloned);
                                }
                                
                                //Adición de los Sistemas de Calidad
                                if(count($itemInstance->getManagementSystems()) > 0){
                                    foreach($itemInstance->getManagementSystems() as $managementSystem){
                                        $itemInstanceCloned->addManagementSystem($managementSystem);
                                    }
                                }
                                
                                $itemInstanceCloned->setRef($ref);
                                $this->persist($itemInstanceCloned);
                            }
                    }elseif($typeObject == PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM){
                        $itemInstanceCloned = $cloneService->findCloneInstance($itemInstance);
                        if(!$itemInstanceCloned){
                            $itemInstanceCloned = $cloneService->cloneObject($itemInstance);
                        }
                    }elseif($typeObject == PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM_GOAL){
                        $itemInstanceCloned = $cloneService->findCloneInstance($itemInstance);
                        if(!$itemInstanceCloned){
                            $itemInstanceCloned = $cloneService->cloneObject($itemInstance);
                        }
                    }elseif($typeObject == PrePlanning::TYPE_OBJECT_INDICATOR){
                        $itemInstanceCloned = $cloneService->findCloneInstance($itemInstance);
                        if(!$itemInstanceCloned){
                            $itemInstanceCloned = $cloneService->cloneObject($itemInstance);
                            $ref = $sequenceGenerator->getNextRefChildIndicator($itemInstanceCloned);
                            $itemInstanceCloned->setRef($ref);
                            $itemInstanceCloned->setIndicatorLastPeriod($itemInstance);
                            
                            //Adición de los Sistemas de Calidad
                            if(count($itemInstance->getManagementSystems()) > 0){
                                foreach($itemInstance->getManagementSystems() as $managementSystem){
                                    $itemInstanceCloned->addManagementSystem($managementSystem);
                                }
                            }
                            
                            $this->persist($itemInstanceCloned);
                        }
                    }
                    if($itemInstanceCloned){
                        $success = true;
                        $prePlanning->setStatus(PrePlanning::STATUS_IMPORTED);
                        $this->persist($prePlanning,true);
                    }

                    $em->getConnection()->commit();
                } catch (Exception $e) {
                    $em->getConnection()->rollback();
                    throw $e;
                }
            }//FIN item instance
        }
        return $success;
    }  

    /**
     * Extrae elementos del objetivo
     * @param PrePlanning $prePlannig
     * @param Objetive $objetive
     */
    private function extractDataFromObjective(PrePlanning &$prePlannig,Objetive &$objetive,$levelPlanning) {
        $arrangementPrograms = $objetive->getArrangementPrograms();
        $indicators = $objetive->getIndicators();
        
        $this->addDataFromArrangementPrograms($prePlannig, $arrangementPrograms,$levelPlanning);
        $this->addDataFromObjetive($prePlannig, $indicators,$levelPlanning);
    }

    /**
     * Añade elementos a la pre planificacion a partir de los objetivos
     * @param PrePlanning $prePlannig
     * @param type $objects
     */
    private function addDataFromObjetive(PrePlanning &$prePlannig,&$objects,$levelPlanning) {
        $linkGeneratorService = $this->getLinkGeneratorService();
        foreach ($objects as $object) {
            $prePlannigChild = $this->createNew();
            $this->setOriginObject($prePlannigChild,$object,$levelPlanning);
            if($levelPlanning == PrePlanning::LEVEL_TACTICO && $prePlannigChild->getLevelObject() == PrePlanning::LEVEL_OPERATIVO){
                return;
            }
            $configEntity = $linkGeneratorService->getConfigFromEntity($object);
            $prePlannigChild->setParameters($configEntity);
            $prePlannig->addChildren($prePlannigChild);
        }
    }
    /**
     * Añade elementos del programa de gestion
     * @param PrePlanning $prePlannig
     * @param type $objects
     */
    private function addDataFromArrangementPrograms(PrePlanning &$prePlannig,&$objects,$levelPlanning) {
        $linkGeneratorService = $this->getLinkGeneratorService();
        foreach ($objects as $object) {
            $prePlannigChild = $this->createNew();
            $this->setOriginObject($prePlannigChild,$object,$levelPlanning);
            if($levelPlanning == PrePlanning::LEVEL_TACTICO && $prePlannigChild->getLevelObject() == PrePlanning::LEVEL_OPERATIVO){
                return;
            }
            $configEntity = $linkGeneratorService->getConfigFromEntity($object);
            $configEntity['expanded'] = false;
            $prePlannigChild->setParameters($configEntity);
            $prePlannig->addChildren($prePlannigChild);
            
            foreach ($object->getTimeline()->getGoals() as $goal) {
                $prePlannigSubChild = $this->createNew();
                $this->setOriginObject($prePlannigSubChild,$goal,$levelPlanning);
                $prePlannigChild->addChildren($prePlannigSubChild);
            }
        }
    }
    
    /**
     * Crea una nueva entidad de pre planificacion.
     * @return PrePlanning
     */
    private function createNew(){
        $prePlanning = new PrePlanning();
        return $prePlanning;
    }


    /**
     * @return PeriodService
     */
    protected function getPeriodService()
    {
        return $this->container->get('pequiven_seip.service.period');
    }
    
    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws LogicException If DoctrineBundle is not available
     */
    protected function getDoctrine()
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
    
    private function isGranted($roles) {
        return $this->container->get('security.context')->isGranted($roles);
    }
    
    /**
     * 
     * @return CloneService
     */
    private function getCloneService() {
        return $this->container->get('seip.service.clone');
    }
    
    private function persist(&$object,$andFlush = false) {
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($object);
        if($andFlush === true){
            $em->flush();
        }
    }
    
    /**
     * Generador de secuencia
     * @return SequenceGenerator
     */
    private function getSequenceGenerator()
    {
        return $this->container->get('seip.sequence_generator');
    }
    
    protected function trans($id,array $parameters = array(), $domain = 'PequivenSEIPBundle')
    {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningUser
     */
    function getCurrentBuildPrePlanning() 
    {
        return $this->currentBuildPrePlanning;
    }

     function setCurrentBuildPrePlanning(\Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningUser &$currentBuildPrePlanning) {
        $this->currentBuildPrePlanning = $currentBuildPrePlanning;
    }
    
    /**
     * 
     * @return \Pequiven\SEIPBundle\Service\SecurityService
     */
    protected function getSecurityService()
    {
        return $this->container->get('seip.service.security');
    }
}


