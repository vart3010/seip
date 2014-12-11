<?php

namespace Pequiven\ObjetiveBundle\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Pequiven\MasterBundle\Entity\Rol;
use Pequiven\ObjetiveBundle\Entity\Objetive;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
use Tecnocreaciones\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Description of ObjetiveRepository
 *
 * @author matias
 */
class ObjetiveRepository extends EntityRepository {
    
    /**
     * Devuelve un grupo de resultados de acuerdo al campo pasado en $options y agrupado por la referencia
     * @param type $options
     * @return type
     */
    public function getByOptionGroupRef($options = array()){
        
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
                    ->select('o')
                    ->from('\Pequiven\ObjetiveBundle\Entity\Objetive', 'o')
                    ->andWhere('o.enabled = 1')
                    ->groupBy('o.ref');
        if(isset($options['type'])){//Para los select
            if($options['type'] === 'TACTIC_ZIV' || $options['type'] === 'OPERATIVE_ZIV'){
                $query->andWhere('o.lineStrategic = ' . $options['lineStrategicId'])
                      ->andWhere('o.objetiveLevel = ' . $options['objetiveLevelId']);
            } elseif($options['type'] === 'TACTIC' || $options['type'] === 'OPERATIVE'){
                $query->andWhere('o.lineStrategic = ' . $options['lineStrategicId'])
                      ->andWhere('o.objetiveLevel = ' . $options['objetiveLevelId'])
                      ->andWhere('o.complejo = ' . $options['complejoId']);
            }
        } else{//Para el campo referencia
            if(isset($options['lineStrategicId'])){
                $query->andWhere('o.lineStrategic = ' . $options['lineStrategicId']);
                $query->andWhere('o.objetiveLevel = ' . ObjetiveLevel::LEVEL_ESTRATEGICO);
            } elseif($options['type_ref'] === 'TACTIC_REF'){
                if(isset($options['type_directive'])){
                    $query->andWhere("o.parent IN (" . $options['array_parent'] . ")");
                } else{
                    $query->andWhere('o.parent = ' . $options['objetiveStrategicId']);
                }
            } elseif($options['type_ref'] === 'OPERATIVE_REF'){
                $query->andWhere('o.parent = ' . $options['objetiveTacticId']);
            }
        }
        
        $q = $query->getQuery();
//        var_dump($q->getSQL());
//        die();
        return $q->getResult();
    }
    
    /**
     * Función que devuelve los objetivos estratégicos de acuerdo a las líneas estratégicas
     * @param type $lineStrategicsArray
     * @return type
     */
    public function getByLineStrategic($lineStrategicsArray){
        //$em = $this->getEntityManager();
        $query = $this->createQueryBuilder('o');
        $query
            ->select('o')
            ->innerJoin('o.lineStrategics', 'ls')
            ->andWhere($query->expr()->in('ls.id', $lineStrategicsArray))
                ;
        return $query->getQuery()->getResult();
    }
    
    /**
     * Función que devuelve los objetivos hijos de un objetivo
     * @param type $objetiveParentsArray
     * @return type
     */
    public function getByParent($objetiveParentsArray,$options = array()){
        $securityContext = $this->getSecurityContext();
        
        $query = $this->createQueryBuilder('o');
        $query
                ->select('o')
                ->innerJoin('o.parents', 'p')
                ->andWhere($query->expr()->in('p.id', $objetiveParentsArray))
                ;
        if(isset($options['enabled'])){
            $query->andWhere('o.enabled = 1');
        }
        if(isset($options['fromIndicator'])){
            if(isset($options['gerenciaFirstId'])){
                $query->andWhere("o.gerencia = " . $options['gerenciaFirstId']);
            } elseif(isset($options['gerenciaSecondId'])){
                $query->andWhere("o.gerenciaSecond = " . $options['gerenciaSecondId']);
            }
        } else{
            if(!isset($options['searchByRef'])){
                if($securityContext->isGranted(array('ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX','ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
                    $query->andWhere("o.gerencia = " . $securityContext->getToken()->getUser()->getGerencia()->getId());
                }
            }
        }
        
        return $query->getQuery()->getResult();
    }
    
    /**
     * Función que devuelve los objetivos padres de un objetivo
     * @param type $objetiveChildrensArray
     * @return type
     */
    public function getByChildren($objetiveChildrensArray){
        $query = $this->createQueryBuilder('o');
        $query
                ->select('o')
                ->innerJoin('o.childrens', 'c')
                ->andWhere($query->expr()->in('c.id', $objetiveChildrensArray))
                ;

        return $query->getQuery()->getResult();
    }
    
    /**
     * Crea un paginador para los objetivos estratégicos
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return QueryBuilder
     */
    function createPaginatorStrategic(array $criteria = null, array $orderBy = null) {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder->andWhere('o.enabled = 1');
        //Filtro Objetivo Estratégico
        if(isset($criteria['description'])){
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('o.description', "'%".$description."%'"),$queryBuilder->expr()->like('o.ref', "'%".$description."%'")));
        }
        //Filtro Línea Estratégica
        if(isset($criteria['lineStrategicDescription'])){
            $lineStrategicDescription = $criteria['lineStrategicDescription'];
            unset($criteria['lineStrategicDescription']);
            $queryBuilder->leftJoin('o.lineStrategics', 'ls');
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('ls.description', "'%".$lineStrategicDescription."%'"),$queryBuilder->expr()->like('ls.ref', "'%".$lineStrategicDescription."%'")));
        }

        if(isset($criteria['objetiveLevel'])){
            $queryBuilder->andWhere("o.objetiveLevel = " . $criteria['objetiveLevel']);
        }
        $queryBuilder->groupBy('o.ref');
        $queryBuilder->orderBy('o.ref');

        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);
        
        return $this->getPaginator($queryBuilder);
    }
    
    /**
     * Crea un paginador para los objetivos tácticos
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return QueryBuilder
     */
    function createPaginatorTactic(array $criteria = null, array $orderBy = null) {
        
        
        $values = $criteria;
        $securityContext = $this->getSecurityContext();
        $user = $this->getUser();
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder->andWhere('o.enabled = 1');
        $queryBuilder->innerJoin('o.parents', 'p');

        //Filtro Objetivo Táctico
        if(isset($criteria['description'])){
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('o.description', "'%".$description."%'"),$queryBuilder->expr()->like('o.ref', "'%".$description."%'")));
        }
        
        if($securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX','ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX')) && !isset($criteria['gerencia'])){
            $queryBuilder->andWhere('o.gerencia = '.$user->getGerencia()->getId());
        }
        
        //Si esta seteado el parámetro de nivel del objetivo, lo anexamos al query
        if(isset($criteria['objetiveLevel'])){
            $queryBuilder->andWhere("o.objetiveLevel = " . $criteria['objetiveLevel']);
        }
        
        //Si esta seteado el parámetro de gerencia de 1ra línea, lo anexamos al query
        if(isset($criteria['gerencia'])){
            if((int)$criteria['gerencia'] > 0){
                $queryBuilder->andWhere("o.gerencia = " . (int)$criteria['gerencia']);
            } else{
                unset($criteria['gerencia']);
            }
        }
        
        $queryBuilder->orderBy('o.ref');
        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);
        
        return $this->getPaginator($queryBuilder);
    }
    
    /**
     * Crea un paginador para los objetivos operativos
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return QueryBuilder
     */
    function createPaginatorOperative(array $criteria = null, array $orderBy = null) {
        
        $securityContext = $this->getSecurityContext();
        $user = $this->getUser();
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder->andWhere('o.enabled = 1');
        $queryBuilder->innerJoin('o.parents', 'p');
//        var_dump($criteria);
//        die();
        //Filtro Objetivo Operativo
        if(isset($criteria['description'])){
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('o.description', "'%".$description."%'"),$queryBuilder->expr()->like('o.ref', "'%".$description."%'")));
        }
        
        if($securityContext->isGranted(array('ROLE_MANAGER_FIRST','ROLE_MANAGER_FIRST_AUX'))){
            if(isset($criteria['gerenciaSecond'])){
                if((int)$criteria['gerenciaSecond'] == 0){//En el caso que seleccione todas las Gerencias de 2da Línea
                    $queryBuilder->andWhere('o.gerencia = '.$user->getGerencia()->getId());;
                }
            } else{
                if($user->getGerencia()){
                    $queryBuilder->andWhere('o.gerencia = '.$user->getGerencia()->getId());
                }
            }
        } elseif($securityContext->isGranted(array('ROLE_MANAGER_SECOND','ROLE_MANAGER_SECOND_AUX'))){
            $queryBuilder->andWhere('o.gerenciaSecond = '. $user->getGerenciaSecond()->getId());
        } elseif($securityContext->isGranted(array('ROLE_GENERAL_COMPLEJO','ROLE_GENERAL_COMPLEJO_AUX'))){
            if(isset($criteria['gerenciaSecond'])){
                if((int)$criteria['gerenciaSecond'] == 0){//En caso que seleccione todas las Gerencias de 2da Línea
                    $queryBuilder->leftJoin('o.gerenciaSecond', 'gs');
                    $queryBuilder->andWhere('gs.complejo = '.$user->getComplejo()->getId());
                    $queryBuilder->andWhere('gs.modular =:modular');
                    $queryBuilder->setParameter('modular', true);
                }
            } else{
                $queryBuilder->leftJoin('o.gerenciaSecond', 'gs');
                $queryBuilder->andWhere('gs.complejo = '.$user->getComplejo()->getId());
                $queryBuilder->andWhere('gs.modular =:modular');
                $queryBuilder->setParameter('modular', true);
            }
        }
        
        if(isset($criteria['gerenciaFirst'])){
            if((int)$criteria['gerenciaFirst'] == 0){

            } else{
                $queryBuilder->andWhere('o.gerencia = ' . (int)$criteria['gerenciaFirst']);
            }
        }
        
        if(isset($criteria['gerenciaSecond'])){
            if((int)$criteria['gerenciaSecond'] > 0){
                $queryBuilder->andWhere("o.gerenciaSecond = " . (int)$criteria['gerenciaSecond']);
            } else{
                unset($criteria['gerenciaSecond']);
            }
        }
        
        if(isset($criteria['objetiveLevel'])){
            $queryBuilder->andWhere("o.objetiveLevel = " . $criteria['objetiveLevel']);
        }
        $queryBuilder->groupBy('o.ref');
        $queryBuilder->orderBy('o.ref');
//        print_r($queryBuilder->getQuery()->getSQL());
//        die();
//        $this->applyCriteria($queryBuilder, $criteria);
//        $this->applySorting($queryBuilder, $orderBy);
        
        return $this->getPaginator($queryBuilder);
    }
    
    /**
     * Crea un paginador para los objetivos operativos vinculantes a un complejo
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return QueryBuilder
     */
    function createPaginatorOperativeVinculant(array $criteria = null, array $orderBy = null) {
        $securityContext = $this->getSecurityContext();
        $user = $this->getUser();
        
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder->andWhere('o.enabled = 1');
        $queryBuilder->innerJoin('o.parents', 'p');
        $queryBuilder->innerJoin('o.gerenciaSecond', 'gs');
        $queryBuilder->andWhere('gs.vinculante = 1 ');
        $queryBuilder->andWhere('gs.modular = 0');
        
        if(isset($criteria['complejo'])){
            $queryBuilder->andWhere('gs.complejo = ' . $criteria['complejo']);
        }
        //Filtro Objetivo Operativo
        if(isset($criteria['description'])){
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('o.description', "'%".$description."%'"),$queryBuilder->expr()->like('o.ref', "'%".$description."%'")));
        }
        
        if(isset($criteria['objetiveLevel'])){
            $queryBuilder->andWhere("o.objetiveLevel = " . $criteria['objetiveLevel']);
        }
        
//        $this->applyCriteria($queryBuilder, $criteria);
//        $this->applySorting($queryBuilder, $orderBy);
//        
        $queryBuilder->groupBy('o.ref');
        $queryBuilder->orderBy('o.ref');
        
        return $this->getPaginator($queryBuilder);
    }
    
    /**
     * Retorna un query builder de los objetivos tacticos asociados a la gerencia
     * @return type
     */
    function findQueryObjetivesTactic()
    {
        $user = $this->getUser();
        $qb = $this->getQueryAllEnabled();
        $qb
                ->innerJoin("o.objetiveLevel","ol")
                ->innerJoin("o.gerencia","g")
                ->andWhere("ol.level = :level")
                ->andWhere('ol.enabled = :enabled')
                ->setParameter('enabled', true)
                ->setParameter("level", ObjetiveLevel::LEVEL_TACTICO)
            ;
        $level = $user->getLevelRealByGroup();
        
        if($level != Rol::ROLE_DIRECTIVE && $level != Rol::ROLE_MANAGER_FIRST && $this->getSecurityContext()->isGranted('ROLE_ARRANGEMENT_PROGRAM_EDIT') == false){
            $qb
                ->andWhere("g.id = :gerencia")
                ->setParameter("gerencia", $user->getGerencia())
                ;
        }
        return $qb;
    }
    
    function findTacticalObjetives($user)
    {
        $qb = $this->getQueryAllEnabled();
        $qb
                ->innerJoin("o.objetiveLevel","ol")
                ->innerJoin("o.gerencia","g")
                ->andWhere("ol.level = :level")
                ->setParameter("level", ObjetiveLevel::LEVEL_TACTICO)
            ;
        $level = $user->getLevelRealByGroup();
        if($level != Rol::ROLE_DIRECTIVE){
            $qb
                ->andWhere("g.id = :gerencia")
                ->setParameter("gerencia", $user->getGerencia())
                ;
        }
        return $qb->getQuery()->getResult();
    }
    
    function findOperativeObjetives($user,array $criteria = array())
    {
        $qb = $this->getQueryAllEnabled();
        $qb
            ->innerJoin("o.objetiveLevel","ol")
            ->innerJoin("o.gerencia","g")
            ->andWhere("ol.level = :level")
            ->setParameter("level", ObjetiveLevel::LEVEL_OPERATIVO)
            ;
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        if(($objetiveTactical = $criteria->remove('objetiveTactical')) != null){
            $qb
                ->innerJoin('o.parents', 'p')
                ->andWhere('p.id = :objetiveTactical')
                ->setParameter('objetiveTactical', $objetiveTactical)
                ;
        }
        $level = $user->getLevelRealByGroup();
        if($level != Rol::ROLE_DIRECTIVE){
            $qb
                ->andWhere("g.id = :gerencia")
                ->setParameter("gerencia", $user->getGerencia())
                ;
        }
        return $qb->getQuery()->getResult();
    }
    
    /**
     * Busca los objetivos operativos de un objetivo tactico y del usuario logueado
     * @return type
     */
    function findObjetivesOperationalByObjetiveTactic(Objetive $objetiveTactic)
    {
        return $this->findQueryObjetivesOperationalByObjetiveTactic($objetiveTactic)->getQuery()->getResult();
    }
    
    function findQueryObjetivesOperationalByObjetiveTactic($objetiveTactic) {
        $user = $this->getUser();
        $qb = $this->getQueryAllEnabled();
        $qb
                ->innerJoin("o.parents","p")
                ->innerJoin("o.objetiveLevel","ol")
                ->innerJoin("o.gerenciaSecond","gs")
                ->andWhere('p.id = :parent')
                ->andWhere("ol.level = :level")
                ->setParameter('parent', $objetiveTactic)
                ->setParameter("level", ObjetiveLevel::LEVEL_OPERATIVO)
            ;
        $level = $user->getLevelRealByGroup();
        if($level != Rol::ROLE_DIRECTIVE && $level != Rol::ROLE_MANAGER_FIRST && $this->getSecurityContext()->isGranted('ROLE_ARRANGEMENT_PROGRAM_EDIT') == false){
            $qb
                ->andWhere("gs.id = :gerenciaSecond")
                ->setParameter("gerenciaSecond", $user->getGerenciaSecond())
                ;
        }
        return $qb;
    }
    
    protected function getQueryAllEnabled(){
        $qb = $this->getQueryBuilder();
        $qb
            ->andWhere('o.enabled = :enabled')
            ->setParameter('enabled', true);
        return $qb;
    }
    
    
    /**
     * 
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerencia
     * @return type
     */
    public function getSectionOperativeByGerencia(\Pequiven\MasterBundle\Entity\Gerencia $gerencia){
        $qb = $this->getQueryBuilder();
        
        $qb->select('o.ref AS ObjOpeRef,o.description AS ObjOpe,o.goal AS ObjOpeGoal,o.weight AS ObjOpePeso');
        $qb->addSelect('i.ref AS IndOpeRef, i.description AS IndOpe, i.goal AS IndOpeGoal,i.weight AS IndOpePeso');
        $qb->addSelect('f.equation AS IndOpeFormula');
        $qb->addSelect('gs.description AS ObjOpeGerencia');
        $qb->addSelect('o1.ref AS ObjTacRef, o1.description AS ObjTac, o1.goal AS ObjTacGoal');
        
        $qb->leftJoin('o.indicators', 'i');
        $qb->leftJoin('i.formula', 'f');
        $qb->innerJoin('o.gerenciaSecond', 'gs');
        $qb->leftJoin('o.parents', 'o1');
        $qb->leftJoin('o1.indicators', 'i1');
        $qb->leftJoin('i1.formula', 'f1');
        
        $qb->andWhere('o.objetiveLevel = :objetiveLevel');
        $qb->andWhere('o.enabled = :enabled');
        $qb->andWhere('o.gerencia = :gerencia');
        $qb->andWhere('o1.enabled = :enabled');
        
        $qb->setParameter('objetiveLevel', ObjetiveLevel::LEVEL_OPERATIVO);
        $qb->setParameter('enabled', true);
        $qb->setParameter('gerencia', $gerencia->getId());
        
        $qb->orderBy('o.ref');
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     * 
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetive
     * @return type
     */
    public function getSectionStrategic(Objetive $objetive){
        $qb = $this->getQueryBuilder();
        
        $qb->select('o.ref AS ObjStraRef, o.description AS ObjStra');
        $qb->addSelect('l.ref AS LineStraRef, l.description AS LineStra');
        
        $qb->innerJoin('o.childrens', 'o1');
        $qb->innerjoin('o.lineStrategics', 'l');
        
        $qb->andWhere('o.objetiveLevel = :objetiveLevel');
        $qb->andWhere('o.enabled = :enabled');
        $qb->andWhere('o1.enabled = :enabled');
        $qb->andWhere('o1.id = :idChildren');
        
        $qb->setParameter('objetiveLevel', ObjetiveLevel::LEVEL_ESTRATEGICO);
        $qb->setParameter('enabled', true);
        $qb->setParameter('idChildren', $objetive->getId());
        
        return $qb->getQuery()->getResult();
    }
    
    
    public function getMatrizObjetives(\Pequiven\MasterBundle\Entity\Gerencia $gerencia){
        
        return $gerencia->getDescription();
    }
    
    public function getObjetivesByGerenciaSecond(\Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecond){
        $qb = $this->getQueryBuilder();
        
        $qb->andWhere('o.objetiveLevel = :objetiveLevel');
        $qb->andWhere('o.enabled = :enabled');
        $qb->andWhere('o.gerenciaSecond = :idGerenciaSecond');
        
        $qb->setParameter('objetiveLevel', ObjetiveLevel::LEVEL_OPERATIVO);
        $qb->setParameter('enabled', true);
        $qb->setParameter('idGerenciaSecond', $gerenciaSecond->getId());
        
        return $qb->getQuery()->getResult();
    }
}
