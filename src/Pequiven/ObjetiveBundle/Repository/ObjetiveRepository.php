<?php

namespace Pequiven\ObjetiveBundle\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Pequiven\MasterBundle\Entity\Rol;
use Pequiven\ObjetiveBundle\Entity\Objetive;
use Pequiven\ObjetiveBundle\Entity\ObjetiveLevel;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio del objetivo (pequiven.repository.objetive)
 * 
 * @author matias
 */
class ObjetiveRepository extends EntityRepository {

    /**
     * Devuelve un grupo de resultados de acuerdo al campo pasado en $options y agrupado por la referencia
     * @param type $options
     * @return type
     */
    public function getByOptionGroupRef($options = array()) {

        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
                ->select('o')
                ->from('\Pequiven\ObjetiveBundle\Entity\Objetive', 'o')
                ->andWhere('o.enabled = 1')
                ->groupBy('o.ref');
        if (isset($options['type'])) {//Para los select
            if ($options['type'] === 'TACTIC_ZIV' || $options['type'] === 'OPERATIVE_ZIV') {
                $query->andWhere('o.lineStrategic = ' . $options['lineStrategicId'])
                        ->andWhere('o.objetiveLevel = ' . $options['objetiveLevelId']);
            } elseif ($options['type'] === 'TACTIC' || $options['type'] === 'OPERATIVE') {
                $query->andWhere('o.lineStrategic = ' . $options['lineStrategicId'])
                        ->andWhere('o.objetiveLevel = ' . $options['objetiveLevelId'])
                        ->andWhere('o.complejo = ' . $options['complejoId']);
            }
        } else {//Para el campo referencia
            if (isset($options['lineStrategicId'])) {
                $query->andWhere('o.lineStrategic = ' . $options['lineStrategicId']);
                $query->andWhere('o.objetiveLevel = ' . ObjetiveLevel::LEVEL_ESTRATEGICO);
            } elseif ($options['type_ref'] === 'TACTIC_REF') {
                if (isset($options['type_directive'])) {
                    $query->andWhere("o.parent IN (" . $options['array_parent'] . ")");
                } else {
                    $query->andWhere('o.parent = ' . $options['objetiveStrategicId']);
                }
            } elseif ($options['type_ref'] === 'OPERATIVE_REF') {
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
    public function getByLineStrategic($lineStrategicsArray) {
        //$em = $this->getEntityManager();
        $query = $this->getQueryBuilder();
//        $query = $this->createQueryBuilder('o');
        $query
                ->innerJoin('o.lineStrategics', 'ls')
                ->andWhere($query->expr()->in('ls.id', $lineStrategicsArray))
        ;
        $this->applyPeriodCriteria($query);
        return $query->getQuery()->getResult();
    }

    /**
     * Función que devuelve los objetivos hijos de un objetivo
     * @param type $objetiveParentsArray
     * @return type
     */
    public function getByParent($objetiveParentsArray, $options = array()) {
        $securityContext = $this->getSecurityContext();
        $user = $this->getUser();

        $query = $this->getQueryBuilder();
//        $query = $this->createQueryBuilder('o');
        $query
                ->innerJoin('o.parents', 'p')
                ->andWhere($query->expr()->in('p.id', $objetiveParentsArray))
        ;
        if (isset($options['enabled'])) {
            $query->andWhere('o.enabled = 1');
        }
        if (isset($options['fromIndicator'])) {
            if (isset($options['gerenciaFirstId'])) {
                $query->andWhere("o.gerencia = " . $options['gerenciaFirstId']);
            } elseif (isset($options['gerenciaSecondId'])) {
                $query->andWhere("o.gerenciaSecond = " . $options['gerenciaSecondId']);
            }
        } else {
            if (!isset($options['searchByRef'])) {
                if ($securityContext->isGranted(array('ROLE_GENERAL_COMPLEJO', 'ROLE_GENERAL_COMPLEJO_AUX', 'ROLE_MANAGER_FIRST', 'ROLE_MANAGER_FIRST_AUX', 'ROLE_MANAGER_SECOND', 'ROLE_MANAGER_SECOND_AUX'))) {
                    if (!$securityContext->isGranted(array('ROLE_WORKER_PLANNING')) || $securityContext->isGranted(array('ROLE_SEIP_OBJECTIVE_VIEW_TACTIC','ROLE_SEIP_OBJECTIVE_VIEW_OPERATIVE'))){
                        $query->andWhere("o.gerencia = " . $user->getGerencia()->getId());
                    }
                }
            }
        }
        
        if(isset($options['viewAll'])){
            $query->andWhere('o.deletedAt IS NULL or o.deletedAt IS NOT NULL');
        }

//        $this->applyPeriodCriteria($query);
        
        return $query->getQuery()->getResult();
    }

    /**
     * Función que devuelve los objetivos padres de un objetivo
     * @param type $objetiveChildrensArray
     * @return type
     */
    public function getByChildren($objetiveChildrensArray) {
        $query = $this->createQueryBuilder('o');
        $query
                ->select('o')
                ->innerJoin('o.childrens', 'c')
                ->andWhere($query->expr()->in('c.id', $objetiveChildrensArray))
        ;

        return $query->getQuery()->getResult();
    }

    /**
     * Crea un paginador para los objetivos de acuerdo al sistema de la calidad
     * Filtrados por Programas de Gestión
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorByLevelSIG(array $criteria = null, array $orderBy = null) {
        
        $criteria['for_viewsig'] = true;
        $orderBy['o.ref'] = 'ASC';
        
        return $this->createPaginator($criteria, $orderBy);
    }

    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);

        //Visualización SIG
        if(($forviewSig = $criteria->remove('for_viewsig')) != null){
            //$queryBuilder->addSelect('ms');

            $queryBuilder
                ->andWhere('o.deletedAt IS NULL')
                ->innerJoin('o.managementSystems', 'ms');

            //Filtro de Sistemas de Gestión
            if(($managementSystems = $criteria->remove('managementSystems')) != null){
                $queryBuilder  
                    ->andWhere('ms.id = :managementSystems')
                    ->setParameter('managementSystems', $managementSystems)
                    ;
            }
        }  

        //Filtro Gerencia 1ra Línea
        if(($gerencia =  $criteria->remove('firstLineManagement')) !== null){
            $queryBuilder->andWhere('o.gerencia = ' . $gerencia);
        }
        //Filtro Gerencia 2da Línea
        if(($gerenciaSecond = $criteria->remove('secondLineManagement')) !== null){
            $queryBuilder->andWhere("o.gerenciaSecond = " . $gerenciaSecond);
        }      

        $applyPeriodCriteria = $criteria->remove('applyPeriodCriteria');
        parent::applyCriteria($queryBuilder, $criteria->toArray());
        
        if($applyPeriodCriteria){
           $this->applyPeriodCriteria($queryBuilder);
        }  
    }

    /**
     * Devuelve todos los objetivos tacticos filtrados por sistema de la calidad, periodo.
     * @author Maximo Sojo <maxsojo13@gmail.com>
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function getObjetivesManagementSystem($managementSystem) {
        
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder
                ->select('o')
                //->where('o.managementSystems = :managementSystemId')
                ->andWhere('ms.id = :managementSystemId')
                ->andWhere('o.period = :per')
                ->andWhere('o.objetiveLevel = :level')
                ->andWhere('o.deletedAt IS NULL')
                ->innerJoin('o.managementSystems', 'ms')
                //->innerJoin('o.managementSystems', 'ms')
                ->setParameter('managementSystemId', $managementSystem)
                ->setParameter('per',$this->getPeriodService()->getPeriodActive())
                ->setParameter('level',\Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO)
        ;
        
        return $queryBuilder->getQuery()->getResult();
    }
    
    /**
     * Crea un paginador para los objetivos de acuerdo al nivel del mismo
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorByLevel(array $criteria = null, array $orderBy = null) {
        $queryBuilder = $this->getQueryBuilder();

        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        
        if(($description = $criteria->remove('description')) != null){
            $queryBuilder
                    ->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('o.description', "'%" . $description . "%'"), $queryBuilder->expr()->like('o.ref', "'%" . $description . "%'")))
                ;
        }
        
        if (isset($criteria['description'])) {
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('o.description', "'%" . $description . "%'"), $queryBuilder->expr()->like('o.ref', "'%" . $description . "%'")));
        }
//        if (isset($criteria['objetiveLevel'])) {
//            $queryBuilder->andWhere("o.objetiveLevel = " . $criteria['objetiveLevel']);
//        }
        
        if(($objetiveLevel = $criteria->remove('objetiveLevel')) != null){
            $queryBuilder
                    ->andWhere('o.objetiveLevel = :objetiveLevel')
                    ->setParameter('objetiveLevel', $objetiveLevel)
                ;
        }
        
        if(($complejo = $criteria->remove('complejo')) != null){
            $queryBuilder
                    ->andWhere('o.complejo = :complejo')
                    ->setParameter('complejo', $complejo)
                ;
        }
        
        if(($gerenciaFirst = $criteria->remove('firstLineManagement')) != null){
            $queryBuilder
                    ->andWhere('o.gerencia = :gerenciaFirst')
                    ->setParameter('gerenciaFirst', $gerenciaFirst)
                ;
        }
        
        if(($gerenciaSecond = $criteria->remove('secondLineManagement')) != null){
            $queryBuilder
                    ->andWhere('o.gerenciaSecond = :gerenciaSecond')
                    ->setParameter('gerenciaSecond', $gerenciaSecond)
                ;
        }
        
//        if (isset($criteria['gerenciaFirst'])) {
//            if ((int) $criteria['gerenciaFirst'] == 0) {
//                
//            } else {
//                $queryBuilder->andWhere('o.gerencia = ' . (int) $criteria['gerenciaFirst']);
//            }
//        }

//        if (isset($criteria['gerenciaSecond'])) {
//            if ((int) $criteria['gerenciaSecond'] > 0) {
//                $queryBuilder->andWhere("o.gerenciaSecond = " . (int) $criteria['gerenciaSecond']);
//            } else {
//                unset($criteria['gerenciaSecond']);
//            }
//        }
        
        if (($status = $criteria->remove('status')) != null) {
            $queryBuilder->andWhere('o.status = ' . (int) $status);
        }

        $queryBuilder->groupBy('o.ref');
        $queryBuilder->orderBy('o.ref');
        $this->applyPeriodCriteria($queryBuilder);

        return $this->getPaginator($queryBuilder);
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
        //Filtro Objetivo Estratégico
        if (isset($criteria['description'])) {
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('o.description', "'%" . $description . "%'"), $queryBuilder->expr()->like('o.ref', "'%" . $description . "%'")));
        }
        //Filtro Línea Estratégica
        if (isset($criteria['lineStrategicDescription'])) {
            $lineStrategicDescription = $criteria['lineStrategicDescription'];
            unset($criteria['lineStrategicDescription']);
            $queryBuilder->leftJoin('o.lineStrategics', 'ls');
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('ls.description', "'%" . $lineStrategicDescription . "%'"), $queryBuilder->expr()->like('ls.ref', "'%" . $lineStrategicDescription . "%'")));
        }

        if (isset($criteria['objetiveLevel'])) {
            $queryBuilder->andWhere("o.objetiveLevel = " . $criteria['objetiveLevel']);
        }
        $queryBuilder->groupBy('o.ref');
        $queryBuilder->orderBy('o.ref');

        $this->applyCriteria($queryBuilder, $criteria);
        $this->applyPeriodCriteria($queryBuilder);
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
        if (isset($criteria['description'])) {
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('o.description', "'%" . $description . "%'"), $queryBuilder->expr()->like('o.ref', "'%" . $description . "%'")));
        }

        if ($securityContext->isGranted(array('ROLE_MANAGER_FIRST', 'ROLE_MANAGER_FIRST_AUX', 'ROLE_GENERAL_COMPLEJO', 'ROLE_GENERAL_COMPLEJO_AUX')) && !isset($criteria['gerencia'])) {
            $queryBuilder->andWhere('o.gerencia = ' . $user->getGerencia()->getId());
        } elseif($user->getGerencia()){
            $queryBuilder->andWhere('o.gerencia = ' . $user->getGerencia()->getId());
        }
        
        

        //Si esta seteado el parámetro de nivel del objetivo, lo anexamos al query
        if (isset($criteria['objetiveLevel'])) {
            $queryBuilder->andWhere("o.objetiveLevel = " . $criteria['objetiveLevel']);
        }

        //Si esta seteado el parámetro de gerencia de 1ra línea, lo anexamos al query
        if (isset($criteria['gerencia'])) {
            if ((int) $criteria['gerencia'] > 0) {
                $queryBuilder->andWhere("o.gerencia = " . (int) $criteria['gerencia']);
            } else {
                unset($criteria['gerencia']);
            }
        }

        $queryBuilder->orderBy('o.ref');
        $this->applyCriteria($queryBuilder, $criteria);
        $this->applyPeriodCriteria($queryBuilder);
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
        if (isset($criteria['description'])) {
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('o.description', "'%" . $description . "%'"), $queryBuilder->expr()->like('o.ref', "'%" . $description . "%'")));
        }

        if ($securityContext->isGranted(array('ROLE_MANAGER_FIRST', 'ROLE_MANAGER_FIRST_AUX'))) {
            if (isset($criteria['gerenciaSecond'])) {
                if ((int) $criteria['gerenciaSecond'] == 0) {//En el caso que seleccione todas las Gerencias de 2da Línea
                    $queryBuilder->andWhere('o.gerencia = ' . $user->getGerencia()->getId());
                    ;
                }
            } else {
                if ($user->getGerencia()) {
                    $queryBuilder->andWhere('o.gerencia = ' . $user->getGerencia()->getId());
                }
            }
        } elseif ($securityContext->isGranted(array('ROLE_MANAGER_SECOND', 'ROLE_MANAGER_SECOND_AUX'))) {
            $queryBuilder->andWhere('o.gerenciaSecond = ' . $user->getGerenciaSecond()->getId());
        } elseif ($securityContext->isGranted(array('ROLE_GENERAL_COMPLEJO', 'ROLE_GENERAL_COMPLEJO_AUX'))) {
//            $queryBuilder->innerJoin('o.gerenciaSecond', 'gs');
            $queryBuilder->andWhere('o.gerencia = ' . $user->getGerencia()->getId());
//            $queryBuilder->andWhere('gs.modular =:modular');
//            $queryBuilder->setParameter('modular', true);
        } elseif($user->getGerencia()){
            $queryBuilder->andWhere('o.gerencia = ' . $user->getGerencia()->getId());
        }

        if (isset($criteria['gerenciaFirst'])) {
            if ((int) $criteria['gerenciaFirst'] == 0) {
                
            } else {
                $queryBuilder->andWhere('o.gerencia = ' . (int) $criteria['gerenciaFirst']);
            }
        }

        if (isset($criteria['gerenciaSecond'])) {
            if ((int) $criteria['gerenciaSecond'] > 0) {
                $queryBuilder->andWhere("o.gerenciaSecond = " . (int) $criteria['gerenciaSecond']);
            } else {
                unset($criteria['gerenciaSecond']);
            }
        }

        if (isset($criteria['objetiveLevel'])) {
            $queryBuilder->andWhere("o.objetiveLevel = " . $criteria['objetiveLevel']);
        }
        $queryBuilder->groupBy('o.ref');
        $queryBuilder->orderBy('o.ref');

        $this->applyPeriodCriteria($queryBuilder);

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

        if (isset($criteria['complejo'])) {
            $queryBuilder->andWhere('gs.complejo = ' . $criteria['complejo']);
        }
        //Filtro Objetivo Operativo
        if (isset($criteria['description'])) {
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('o.description', "'%" . $description . "%'"), $queryBuilder->expr()->like('o.ref', "'%" . $description . "%'")));
        }

        if (isset($criteria['objetiveLevel'])) {
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
    function findQueryObjetivesTactic() {
        $user = $this->getUser();
        $qb = $this->getQueryAllEnabled();
        $qb
                ->innerJoin("o.objetiveLevel", "ol")
                ->innerJoin("o.gerencia", "g")
                ->andWhere("ol.level = :level")
                ->andWhere('o.enabled = :enabled')
                ->setParameter('enabled', true)
                ->setParameter("level", ObjetiveLevel::LEVEL_TACTICO)
        ;
        $level = $user->getLevelRealByGroup();

        if ($level != Rol::ROLE_DIRECTIVE && $level != Rol::ROLE_MANAGER_FIRST) {
            if ($this->getSecurityContext()->isGranted('ROLE_ARRANGEMENT_PROGRAM_EDIT') == false) {
                $qb
                        ->andWhere("g.id = :gerencia")
                        ->setParameter("gerencia", $user->getGerencia())
                ;
            }
        }
        $localidad = $user->getComplejo();
        $gerenciasTypeComplejo = $gerenciasTypeComplejoId = array();
        if ($localidad) {
            foreach ($localidad->getGerencias() as $gerencia) {
                $gerenciaGroup = $gerencia->getGerenciaGroup();

                if ($gerenciaGroup !== null && $gerenciaGroup->getGroupName() == \Pequiven\MasterBundle\Entity\GerenciaGroup::TYPE_COMPLEJOS) {
                    $gerenciasTypeComplejo [] = $gerencia;
                    $gerenciasTypeComplejoId[] = $gerencia->getId();
                }
            }
        }
        if (count($gerenciasTypeComplejo) > 0) {
            $qbMedular = $this->getQueryAllEnabled();
            $qbMedular
                    ->innerJoin("o.objetiveLevel", "ol")
                    ->innerJoin("o.gerencia", "g")
                    ->innerJoin("o.childrens", "o_c")
                    ->innerJoin("o_c.gerenciaSecond", "o_c_gs")
                    ->andWhere("ol.level = :level")
                    ->andWhere("o_c_gs.modular = 1")
                    ->andWhere('o.enabled = :enabled')
                    ->andWhere($qbMedular->expr()->in('g.id', $gerenciasTypeComplejoId))
                    ->setParameter('enabled', true)
                    ->setParameter("level", ObjetiveLevel::LEVEL_TACTICO)
            ;
            $objetivesMedular = array();
            foreach ($qbMedular->getQuery()->getResult() as $result) {
                $objetivesMedular[] = $result->getId();
            }
            $qb->orWhere($qb->expr()->in('o.id', $objetivesMedular));
        }
        
        $this->applyPeriodCriteria($qb);

        return $qb;
    }

    function findTacticalObjetives($user, array $criteria = array()) {
        
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        $qb = $this->getQueryAllEnabled();
        $qb
                ->innerJoin("o.objetiveLevel", "ol")
                ->innerJoin("o.gerencia", "g")
                ->andWhere("ol.level = :level")
                ->setParameter("level", ObjetiveLevel::LEVEL_TACTICO)
        ;
        $level = $user->getLevelRealByGroup();
        $managementSystem = $criteria->remove('idManagementSystem');
        if($managementSystem == null){
            if ($level != Rol::ROLE_DIRECTIVE && !$criteria['view_planning']) {
                $qb
                        ->andWhere("g.id = :gerencia")
                        ->setParameter("gerencia", $user->getGerencia())
                ;
            } elseif ($criteria['view_planning']) {
                if ($gerencia = $criteria->remove('gerencia') != null) {

                }
                $qb
                        ->andWhere("g.id = :gerencia")
                        ->setParameter("gerencia", $gerencia)
                ;
                $criteria->remove('view_planning');
            }
        }
        
        if($managementSystem != null){
            $qb
                    ->innerjoin('o.managementSystems','ms')
                    ->andWhere('ms.id = :managementSystemId')
                    ->setParameter('managementSystemId', $managementSystem)
                ;
        }
        return $qb->getQuery()->getResult();
    }

    /**
     * Busca los objetivos tácticos del usuario logueado
     * @return type
     */
    function findOperativeObjetives($user, array $criteria = array()) {
        $qb = $this->getQueryAllEnabled();
        $qb
                ->innerJoin("o.objetiveLevel", "ol")
                ->innerJoin("o.gerencia", "g")
                ->andWhere("ol.level = :level")
                ->setParameter("level", ObjetiveLevel::LEVEL_OPERATIVO)
        ;
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        if (($objetiveTactical = $criteria->remove('objetiveTactical')) != null) {
            $qb
                    ->innerJoin('o.parents', 'p')
                    ->andWhere('p.id = :objetiveTactical')
                    ->setParameter('objetiveTactical', $objetiveTactical)
            ;
        }
        $level = $user->getLevelRealByGroup();
        if ($level != Rol::ROLE_DIRECTIVE && !$criteria['view_planning']) {
            $qb
                    ->andWhere("g.id = :gerencia")
                    ->setParameter("gerencia", $user->getGerencia())
            ;
        } elseif ($criteria['view_planning']) {
            if ($gerencia = $criteria->remove('gerencia') != null) {
                
            }
            $qb
                    ->andWhere("g.id = :gerencia")
                    ->setParameter("gerencia", $gerencia)
            ;
            $criteria->remove('view_planning');
        }

        if (($objetiveTactical = $criteria->remove('objetiveTactical')) != null) {
            
        }
        
        return $qb->getQuery()->getResult();
    }

    /**
     * Busca los objetivos tácticos de un sistema de gestión
     * @return type
     */
    function findObjetivesTacticByManagementSystem(\Pequiven\SIGBundle\Entity\ManagementSystem $managementSystem) {
        return $this->findQueryObjetivesTacticByManagementSystem($managementSystem)->getQuery()->getResult();
    }
    
    function findQueryObjetivesTacticByManagementSystem($managementSystem) {
        $user = $this->getUser();
        $qb = $this->getQueryAllEnabled();
        $qb
                ->innerJoin("o.managementSystems", "ms")
                ->innerJoin("o.objetiveLevel", "ol")
                ->innerJoin("o.gerencia", "g")
                ->andWhere("ol.level = :level")
                ->andWhere("ms.id = :managementSystemId")
                ->setParameter("level", ObjetiveLevel::LEVEL_TACTICO)
                ->setParameter("managementSystemId", $managementSystem)
        ;
        $level = $user->getLevelRealByGroup();
        if ($level != Rol::ROLE_DIRECTIVE && $this->getSecurityContext()->isGranted('ROLE_ARRANGEMENT_PROGRAM_EDIT') == false) {
            $qb
                    ->andWhere("g.id = :gerencia")
                    ->setParameter("gerencia", $user->getGerencia())
            ;
        }
        return $qb;
    }
    
    /**
     * Busca los objetivos operativos de un objetivo tactico y del usuario logueado
     * @return type
     */
    function findObjetivesOperationalByObjetiveTactic(Objetive $objetiveTactic,$categoryArrangementProgramId = null) {
        return $this->findQueryObjetivesOperationalByObjetiveTactic($objetiveTactic)->getQuery()->getResult();
    }

    function findQueryObjetivesOperationalByObjetiveTactic($objetiveTactic,$categoryArrangementProgramId = null) {
        $user = $this->getUser();
        $qb = $this->getQueryAllEnabled();
        $qb
                ->innerJoin("o.parents", "p")
                ->innerJoin("o.objetiveLevel", "ol")
                ->innerJoin("o.gerenciaSecond", "gs")
                ->andWhere('p.id = :parent')
                ->andWhere("ol.level = :level")
                ->setParameter('parent', $objetiveTactic)
                ->setParameter("level", ObjetiveLevel::LEVEL_OPERATIVO)
        ;
        
        if($categoryArrangementProgramId != null && $categoryArrangementProgramId == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_PLA){
            $level = $user->getLevelRealByGroup();
            if ($level != Rol::ROLE_DIRECTIVE && $level != Rol::ROLE_MANAGER_FIRST && $this->getSecurityContext()->isGranted('ROLE_ARRANGEMENT_PROGRAM_EDIT') == false) {
                $qb
                        ->andWhere("gs.id = :gerenciaSecond")
                        ->setParameter("gerenciaSecond", $user->getGerenciaSecond())
                ;
            }
        }
        return $qb;
    }
    
    public function getQueryAllEnabled(){
        $qb = $this->getQueryBuilder();
        $qb
                ->andWhere('o.deletedAt IS NULL');
        return $qb;
    }

    /**
     * Función que devuelve el nivel operativo para la matriz de objetivos
     * @param \Pequiven\MasterBundle\Entity\Gerencia $gerencia
     * @return type
     */
    public function getSectionOperativeByGerencia(\Pequiven\MasterBundle\Entity\Gerencia $gerencia) {
        $qb = $this->getQueryBuilder();

        $qb->select('o.ref AS ObjOpeRef,o.description AS ObjOpe,o.goal AS ObjOpeGoal,o.weight AS ObjOpePeso');
        $qb->addSelect('i.ref AS IndOpeRef, i.description AS IndOpe, i.goal AS IndOpeGoal,i.weight AS IndOpePeso');
        $qb->addSelect('f.equation AS IndOpeFormula');
        $qb->addSelect('gs.description AS ObjOpeGerencia');
        $qb->addSelect('o1.ref AS ObjTacRef, o1.description AS ObjTac, o1.goal AS ObjTacGoal');

        $qb->leftJoin('o.indicators', 'i');
        $qb->leftJoin('i.formula', 'f');
        $qb->innerJoin('o.gerenciaSecond', 'gs');
        $qb->innerJoin('o.parents', 'o1');
//        $qb->leftJoin('o1.indicators', 'i1');
//        $qb->leftJoin('i1.formula', 'f1');

        $qb->andWhere('o.objetiveLevel = :objetiveLevel');
        $qb->andWhere('o.deletedAt IS NULL');
        $qb->andWhere('i.deletedAt IS NULL');
        $qb->andWhere('o.gerencia = :gerencia');
        $qb->andWhere('o1.deletedAt IS NULL');

        $qb->setParameter('objetiveLevel', ObjetiveLevel::LEVEL_OPERATIVO);
        $qb->setParameter('gerencia', $gerencia->getId());

        $this->applyPeriodCriteria($qb);

        $qb->orderBy('o.ref');
        $qb->groupBy('o1.ref,o.ref,i.ref');

        return $qb->getQuery()->getResult();
    }

    /**
     * Función que devuelve el nivel estratégico para la matriz de objetivos
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetive
     * @return type
     */
    public function getSectionStrategic(Objetive $objetive) {
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

    public function getObjetivesByGerenciaSecond(\Pequiven\MasterBundle\Entity\GerenciaSecond $gerenciaSecond) {
        $qb = $this->getQueryBuilder();

        $qb->andWhere('o.objetiveLevel = :objetiveLevel');
        $qb->andWhere('o.enabled = :enabled');
        $qb->andWhere('o.gerenciaSecond = :idGerenciaSecond');

        $qb->setParameter('objetiveLevel', ObjetiveLevel::LEVEL_OPERATIVO);
        $qb->setParameter('enabled', true);
        $qb->setParameter('idGerenciaSecond', $gerenciaSecond->getId());

        return $qb->getQuery()->getResult();
    }

    /**
     * Retorna los objetivos estrategicos del periodo.
     * 
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     * @return type
     */
    public function findAllStrategicByPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $qb = $this->getQueryBuilder();
        $qb
                ->andWhere('o.objetiveLevel = :objetiveLevel')
                ->andWhere('o.period = :period')
        ;
        $qb
                ->setParameter('objetiveLevel', ObjetiveLevel::LEVEL_ESTRATEGICO)
                ->setParameter('period', $period)
        ;
        return $qb->getQuery()->getResult();
    }
    
    protected function getAlias() {
        return 'o';
    }

}
