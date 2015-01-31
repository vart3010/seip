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
use Pequiven\MasterBundle\Model\Rol;
use Pequiven\ObjetiveBundle\Entity\Objetive;
use Pequiven\SEIPBundle\Entity\Period;
use Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning;
use Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanningItem;
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
     * Busca el arbol creado para la exportacion de items al siguiente periodo
     * 
     * @param Period $period
     * @param User $user
     * @return type
     */
    public function findRootTreePrePlannig(Period $period,  User $user,$level) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('Pequiven\SEIPBundle\Entity\PrePlanning\PrePlanning');
        $rootPrePlanning = $repository->findTreePrePlanning($period,$user,$level);
        return $rootPrePlanning;
    }
    
    /**
     * Construye un arbol con los elementos en el periodo anterior
     * @param type $objetivesArray
     * @return type
     */
    public function buildTreePrePlannig($objetivesArray,$levelPlanning){
        $linkGeneratorService = $this->getLinkGeneratorService();
        $user = $this->getUser();
        $period = $this->getPeriodService()->getPeriodActive();
        
        $root = $this->createNew();
        $root->setName(PrePlanning::DEFAULT_NAME);
        $root->setUser($user);
        $root->setPeriod($period);
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
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($root);
        $em->flush();
        
        return $root;
    }
    
    private function setOriginObject(PrePlanning $prePlanning,$object,$levelPlanning)
    {
        $user = $this->getUser();
        $configuration = $user->getConfiguration();
        $prePlanningConfiguration = $configuration->getPrePlanningConfiguration();
        
        $isEditable = false;
        $requiresApproval = false;
        if($this->isGranted('ROLE_MENU_PRE_PLANNING_TACTIC') && $prePlanningConfiguration->getGerencia() !== null){
            
        }elseif($this->isGranted('ROLE_MENU_PRE_PLANNING_OPERATIVE') && $prePlanningConfiguration->getGerenciaSecond() !== null){
            $requiresApproval = true;
        }
        
        $idSourceObject = $object->getId();
        $class = ClassUtils::getRealClass(get_class($object));
        $levelObject = PrePlanning::LEVEL_DEFAULT;
        if($class == 'Pequiven\ObjetiveBundle\Entity\Objetive'){
            $typeObject = PrePlanning::TYPE_OBJECT_OBJETIVE;
            $levelObject = $object->getObjetiveLevel()->getLevel();
            $prePlanning->setRequiresApproval($requiresApproval);
        }else if($class == 'Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram'){
            $typeObject = PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM;
            $type = $object->getType();
            if($type == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC){
                $levelObject = PrePlanning::LEVEL_TACTICO;
            }else if($type == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
                $levelObject = PrePlanning::LEVEL_OPERATIVO;
            }
        }else if($class == 'Pequiven\IndicatorBundle\Entity\Indicator'){
            $typeObject = PrePlanning::TYPE_OBJECT_INDICATOR;
            if($object->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_ESTRATEGICO){
                $levelObject = PrePlanning::LEVEL_ESTRATEGICO;
            }else if($object->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_TACTICO){
                $levelObject = PrePlanning::LEVEL_TACTICO;
            }else if($object->getIndicatorLevel()->getLevel() == IndicatorLevel::LEVEL_OPERATIVO){
                $levelObject = PrePlanning::LEVEL_OPERATIVO;
            }
        }else if($class == 'Pequiven\ArrangementProgramBundle\Entity\Goal'){
            $typeObject = PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM_GOAL;
            $type = $object->getTimeline()->getArrangementProgram()->getType();
            
            if($type == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC){
                $levelObject = PrePlanning::LEVEL_TACTICO;
            }else if($type == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
                $levelObject = PrePlanning::LEVEL_OPERATIVO;
            }
        }else {
            throw new InvalidArgumentException(sprintf('The object class "%s" is not admited',$class));
        }
        if($this->isGranted('ROLE_MENU_PRE_PLANNING_OPERATIVE') && $prePlanningConfiguration->getGerenciaSecond() !== null && $levelObject == PrePlanning::LEVEL_OPERATIVO && $levelPlanning == PrePlanning::LEVEL_OPERATIVO){
            $isEditable = true;
        }else if($this->isGranted('ROLE_MENU_PRE_PLANNING_TACTIC') && $prePlanningConfiguration->getGerencia() !== null && $levelObject == PrePlanning::LEVEL_TACTICO && $levelPlanning == PrePlanning::LEVEL_TACTICO){
            $isEditable = true;
        }
        
        $prePlanning->setName(((string)$object));
        $prePlanning->setTypeObject($typeObject);
        $prePlanning->setIdSourceObject($idSourceObject);
        $prePlanning->setLevelObject($levelObject);
        $prePlanning->setEditable($isEditable);
        $prePlanning->setUser($user);
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
//                    var_dump(count($subChildren));
                    $this->buildChildren($subChildren, $prePlannigChild,$levelPlanning);
//                    $prePlannigChild->addChildren($prePlannigSubChild);
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
    
    private function getLeaf(PrePlanning $root,$limitCurrentLevel) {
        $icon = $root->getParameter('icon');
        $url = $root->getParameter('url');
        $expanded = $root->getParameter('expanded',true);
        $name = $this->normalize_str($root->getName());
        $limitName = 130;
        $nameSumary = $name;
        if(strlen($nameSumary) > $limitName){
            $nameSumary = substr($nameSumary, 0, $limitName).'...';
        }
        
        if($url != ''){
            $name = sprintf('<a href="%s" target="_blank" title="%s">%s</a>',$url,$name,$nameSumary);
        }
        $itemInstance = $this->getCloneService()->findInstancePrePlanning($root);
        $itemInstanceCloned = $this->getCloneService()->findCloneInstance($itemInstance);
        if($root->isRequiresApproval()){
            if($itemInstanceCloned){
//                $name .= ' <span class="green">(Aprobado)</span>';
            }else{
//                $name .= ' <span class="red">(Requiere Aprobación)</span>';
            }
        }
        $parentId = null;
        if($root->getParent())
        {
            $parentId = $root->getParent()->getId();
        }
        $child = array(
            'id' => $root->getId(),
            'name' => $name,
            'leaf' => true,
            'iconCls' => $icon,
            'editable' => $root->isEditable(),
            'parentId' => $parentId,
            'toImport' => $root->getToImport(),
            'status' => $root->getStatus(),
            '_statusLabel' => '<span class="red">No importado</span>',
        );
        
        if($itemInstanceCloned){
            $child['status'] = PrePlanning::STATUS_IMPORTED;
            //Las metas no tienen link por lo tanto genero el link del programa
            if($root->getTypeObject() == PrePlanning::TYPE_OBJECT_ARRANGEMENT_PROGRAM_GOAL){
                $configEntity = $this->getLinkGeneratorService()->getConfigFromEntity($itemInstanceCloned->getTimeline()->getArrangementProgram());
            }else{
                $configEntity = $this->getLinkGeneratorService()->getConfigFromEntity($itemInstanceCloned);
            }
            $child['_statusLabel'] = sprintf('<a href="%s" target="_blank"><span class="green">Importado</span></a>',$configEntity['url']);
        }
        if(count($root->getChildrens()) > 0){
            $limitLevel = 2;
            if($limitCurrentLevel < $limitLevel){
                $child['expanded'] = $expanded;
                $child['children'] = $this->getStructureTree($root->getChildrens(), ($limitCurrentLevel+1));
            }else{
                $child['expanded'] = false;
            }
            $child['leaf'] = false;
        }
        return $child;
    }
    
    public function importItem(PrePlanning $prePlanning,User $user) 
    {
        $success = false;
        $configuration = $user->getConfiguration();
        $prePlanningConfiguration = $configuration->getPrePlanningConfiguration();
        $gerencia = $prePlanningConfiguration->getGerencia();
        $gerenciaSecond = $prePlanningConfiguration->getGerenciaSecond();
        if($prePlanning->getToImport() == PrePlanning::TO_IMPORT_YES && $prePlanning->getStatus() == PrePlanning::STATUS_DRAFT)
        {
            $cloneService = $this->getCloneService();
            $sequenceGenerator = $this->getSequenceGenerator();
            $levelObject = $prePlanning->getLevelObject();
            if($levelObject == PrePlanning::LEVEL_TACTICO && !$this->isGranted('ROLE_MENU_PRE_PLANNING_TACTIC')){
                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Usted no tiene permiso para pre planificar el nivel tactico.');
            }elseif ($levelObject == PrePlanning::LEVEL_OPERATIVO && !$this->isGranted('ROLE_MENU_PRE_PLANNING_OPERATIVE')) {
                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException('Usted no tiene permiso para pre planificar el nivel operativo.');
            }
            $typeObject = $prePlanning->getTypeObject();
            $itemInstance = $this->getCloneService()->findInstancePrePlanning($prePlanning);
            if($itemInstance){
                    $itemInstanceCloned = null;
                    if($typeObject == PrePlanning::TYPE_OBJECT_OBJETIVE){
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
                                $ref = $sequenceGenerator->getNextRefChildObjetive($itemInstanceCloned);
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
                        }
                    }
                    if($itemInstanceCloned){
                        $success = true;
                        $prePlanning->setStatus(PrePlanning::STATUS_IMPORTED);
                        $this->persist($prePlanning,true);
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
        $prePlanning->setPeriod($this->getPeriodService()->getPeriodActive());
        return $prePlanning;
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
    
    /**
     * Elimina los acentos de una cadena
     * @param type $str
     * @return type
     */
    private function normalize_str($str) {
        $invalid = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y');
        $str = str_replace(array_keys($invalid), array_values($invalid), $str);

        return $str;
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
}
