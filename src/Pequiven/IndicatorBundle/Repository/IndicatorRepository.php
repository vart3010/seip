<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\IndicatorBundle\Repository;

use Pequiven\SIGBundle\Entity\ManagementSystem;
use Pequiven\IndicatorBundle\Entity\Indicator;
use Pequiven\IndicatorBundle\Entity\IndicatorLevel;
use Pequiven\MasterBundle\Entity\Gerencia;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Description of IndicatorRepository (pequiven.repository.indicator)
 *
 * @author matias
 */
class IndicatorRepository extends EntityRepository {

    public function getByOptionRef($options = array()) {

        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
                ->select('i')
                ->from('\Pequiven\IndicatorBundle\Entity\Indicator', 'i')
        ;

        if (isset($options['lineStrategicId'])) {
            $query->andWhere('i.lineStrategic = ' . $options['lineStrategicId']);
        }

        if ($options['type'] === 'STRATEGIC') {
            $query->andWhere('i.indicatorLevel = ' . IndicatorLevel::LEVEL_ESTRATEGICO);
        } elseif ($options['type'] === 'TACTIC') {
            $query->andWhere('i.indicatorLevel = ' . IndicatorLevel::LEVEL_TACTICO);
        } elseif ($options['type'] === 'OPERATIVE') {
            $query->andWhere('i.indicatorLevel = ' . IndicatorLevel::LEVEL_OPERATIVO);
        }

        $q = $query->getQuery();
        //var_dump($q->getSQL());
        //die();
        return $q->getResult();
    }

    /**
     * Función que devuelve la cantidad de indicadores que tiene un objetivo
     * @param type $options
     * @return type
     */
    public function getByOptionRefParent($options = array()) {
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
                ->select('i')
                ->from('\Pequiven\IndicatorBundle\Entity\Indicator', 'i')
                ->andWhere('i.refParent = :refParentId')
                ->setParameter('refParentId', $options['refParent'])
        ;

        if ($options['type'] === 'STRATEGIC') {
            $query->andWhere('i.indicatorLevel = ' . IndicatorLevel::LEVEL_ESTRATEGICO);
        } elseif ($options['type'] === 'TACTIC') {
            $query->andWhere('i.indicatorLevel = ' . IndicatorLevel::LEVEL_TACTICO);
        } elseif ($options['type'] === 'OPERATIVE') {
            $query->andWhere('i.indicatorLevel = ' . IndicatorLevel::LEVEL_OPERATIVO);
        }

        $q = $query->getQuery();

        return $q->getResult();
    }

    public function getByParent($options = array()) {
        $securityContext = $this->getSecurityContext();
        $em = $this->getEntityManager();

        $query = $this->getQueryBuilder();

        $query->innerJoin('i.objetives', 'o');
        $query->andWhere('o.id = ' . $options['idObjetive']);

//        if($options['type'] === 'STRATEGIC'){
//            $query->andWhere('i.indicatorLevel = ' . IndicatorLevel::LEVEL_ESTRATEGICO);
//        } elseif($options['type'] === 'TACTIC'){
//            $query->andWhere('i.indicatorLevel = ' . IndicatorLevel::LEVEL_TACTICO);
//        } elseif($options['type'] === 'OPERATIVE'){
//            $query->andWhere('i.indicatorLevel = ' . IndicatorLevel::LEVEL_OPERATIVO);
//        }

        $q = $query->getQuery();

        return $q->getResult();
    }

    function getQueryChildrenLevel($level) {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder
                ->innerJoin('i.objetives', 'o_o')
                ->innerJoin('i.indicatorLevel', 'o_il')
                ->andWhere('i.enabled = 1')
                ->andWhere('o_o.enabled = 1')
                ->andWhere('i.tmp = 0')
                ->andWhere("o_il.level > :level")
                ->setParameter('level', $level)
        ;
        $queryBuilder->groupBy('i.ref');
        $queryBuilder->orderBy('i.ref');

        return $queryBuilder;
    }

    function getLastPeriod($period) {
        //Chuleta: se necesita el id del period, no la descripcion.
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder
                ->addSelect('i')
                ->andWhere('i.enabled = 1')
                ->andWhere('i.period = :periodo')
                ->andWhere('i.tmp = 0')
                ->orderBy('i.ref')
                ->setParameter('periodo', $period)
        ;
        //$queryBuilder->orderBy('i.ref');

        return $queryBuilder;
    }

    /**
     * Crea un paginador para los indicadores de acuerdo al nivel del mismo
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorByLevel(array $criteria = null, array $orderBy = null) {
        $criteria['for_view'] = true;
        $orderBy['i.ref'] = 'ASC';
        return $this->createPaginator($criteria, $orderBy);
    }

    /**
     * Crea un paginador para los indicadores de acuerdo al nivel del mismo
     * Filtrados por Programas de Gestión
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorByLevelSIG(array $criteria = null, array $orderBy = null) {

        $criteria['for_viewsig'] = true;
        $orderBy['i.ref'] = 'ASC';

        return $this->createPaginator($criteria, $orderBy);
    }

    /**
     * Crea un paginador para la vista de todos los indicadores, sin importar su nivel
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorForAll(array $criteria = null, array $orderBy = null) {
        $criteria['for_view'] = true;
        return $this->createPaginator($criteria, $orderBy);
    }

    /**
     * Crea un paginador para los indicadores estratégicos
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorStrategic(array $criteria = null, array $orderBy = null) {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder->andWhere('i.enabled =:enabled');
        $queryBuilder->innerJoin('i.objetives', 'ob');
        $queryBuilder->andWhere('i.tmp =:false');
        $queryBuilder->andWhere('ob.enabled =:enabled');
        $queryBuilder->setParameter('enabled', true);
        $queryBuilder->setParameter('false', false);
        //Filtro Objetivo Estratégico
        if (isset($criteria['description'])) {
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('i.description', "'%" . $description . "%'"), $queryBuilder->expr()->like('i.ref', "'%" . $description . "%'")));
        }

        if (isset($criteria['indicatorLevel'])) {
            $queryBuilder->andWhere("i.indicatorLevel = " . $criteria['indicatorLevel']);
        }
        $queryBuilder->groupBy('i.ref');
        $queryBuilder->orderBy('i.ref');

        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);

        return $this->getPaginator($queryBuilder);
    }

    /**
     * Crea un paginador para los indicadores tácticos
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorTactic(array $criteria = null, array $orderBy = null) {
        $user = $this->getUser();
        $securityContext = $this->getSecurityContext();
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder->andWhere('i.enabled =:enabled');
        $queryBuilder->innerJoin('i.objetives', 'ob');
        $queryBuilder->andWhere('i.tmp =:false');
        $queryBuilder->andWhere('ob.enabled =:enabled');
        $queryBuilder->setParameter('enabled', true);
        $queryBuilder->setParameter('false', false);
        //Filtro Objetivo Estratégico
        if (isset($criteria['description'])) {
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('i.description', "'%" . $description . "%'"), $queryBuilder->expr()->like('i.ref', "'%" . $description . "%'")));
        }

        if (isset($criteria['indicatorLevel'])) {
            $queryBuilder->andWhere("i.indicatorLevel = " . $criteria['indicatorLevel']);
        }

        if ($securityContext->isGranted(array('ROLE_MANAGER_FIRST', 'ROLE_MANAGER_FIRST_AUX', 'ROLE_GENERAL_COMPLEJO', 'ROLE_GENERAL_COMPLEJO_AUX', 'ROLE_INDICATOR_ADD_RESULT')) && !isset($criteria['gerencia'])) {
            $queryBuilder->andWhere('ob.gerencia = ' . $user->getGerencia()->getId());
        } elseif ($user->getGerencia()) {
            $queryBuilder->andWhere('ob.gerencia = ' . $user->getGerencia()->getId());
        }

        //Si esta seteado el parámetro de gerencia de 1ra línea, lo anexamos al query
        if (isset($criteria['gerencia'])) {
            if ((int) $criteria['gerencia'] > 0) {
                $queryBuilder->andWhere("ob.gerencia = " . (int) $criteria['gerencia']);
            } else {
                unset($criteria['gerencia']);
            }
        }

        $queryBuilder->groupBy('i.ref');
        $queryBuilder->orderBy('i.ref');

        $this->applyPeriodCriteria($queryBuilder);
//        $this->applySorting($queryBuilder, $orderBy);

        return $this->getPaginator($queryBuilder);
    }

    /**
     * Crea un paginador para los indicadores operativos
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorOperative(array $criteria = null, array $orderBy = null) {
        $securityContext = $this->getSecurityContext();
        $user = $this->getUser();
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder->andWhere('i.enabled =:enabled');
        $queryBuilder->innerJoin('i.objetives', 'ob');
        $queryBuilder->andWhere('i.tmp =:false');
        $queryBuilder->andWhere('ob.enabled =:enabled ');
        $queryBuilder->setParameter('enabled', true);
        $queryBuilder->setParameter('false', false);
        //Filtro Objetivo Estratégico
        if (isset($criteria['description'])) {
            $description = $criteria['description'];
            unset($criteria['description']);
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('i.description', "'%" . $description . "%'"), $queryBuilder->expr()->like('i.ref', "'%" . $description . "%'")));
        }

        if (isset($criteria['indicatorLevel'])) {
            $queryBuilder->andWhere("i.indicatorLevel = " . $criteria['indicatorLevel']);
        }

        if ($securityContext->isGranted(array('ROLE_MANAGER_FIRST', 'ROLE_MANAGER_FIRST_AUX'))) {
            if (isset($criteria['gerenciaSecond'])) {
                if ((int) $criteria['gerenciaSecond'] == 0) {//En el caso que seleccione todas las Gerencias de 2da Línea
                    $queryBuilder->andWhere('ob.gerencia = ' . $user->getGerencia()->getId());
                    ;
                }
            } else {
                if ($user->getGerencia()) {
                    $queryBuilder->andWhere('ob.gerencia = ' . $user->getGerencia()->getId());
                }
            }
        } elseif ($securityContext->isGranted(array('ROLE_MANAGER_SECOND', 'ROLE_MANAGER_SECOND_AUX'))) {
            $queryBuilder->andWhere('ob.gerenciaSecond = ' . $user->getGerenciaSecond()->getId());
        } elseif ($securityContext->isGranted(array('ROLE_GENERAL_COMPLEJO', 'ROLE_GENERAL_COMPLEJO_AUX'))) {
            if (isset($criteria['gerenciaSecond'])) {
                if ((int) $criteria['gerenciaSecond'] == 0) {//En caso que seleccione todas las Gerencias de 2da Línea
                    $queryBuilder->leftJoin('ob.gerenciaSecond', 'gs');
                    $queryBuilder->andWhere('gs.complejo = ' . $user->getComplejo()->getId());
                    $queryBuilder->andWhere('gs.modular =:modular');
                    $queryBuilder->setParameter('modular', true);
                }
            } else {
                $queryBuilder->leftJoin('ob.gerenciaSecond', 'gs');
                $queryBuilder->andWhere('gs.complejo = ' . $user->getComplejo()->getId());
                $queryBuilder->andWhere('gs.modular =:modular');
                $queryBuilder->setParameter('modular', true);
            }
        } elseif ($securityContext->isGranted(array('ROLE_INDICATOR_ADD_RESULT')) || $user->getGerencia()) {
            $queryBuilder->andWhere('ob.gerencia = ' . $user->getGerencia()->getId());
        }

        if (isset($criteria['gerenciaFirst'])) {
            if ((int) $criteria['gerenciaFirst'] == 0) {
                
            } else {
                $queryBuilder->andWhere('ob.gerencia = ' . (int) $criteria['gerenciaFirst']);
            }
        }

        if (isset($criteria['gerenciaSecond'])) {
            if ((int) $criteria['gerenciaSecond'] > 0) {
                $queryBuilder->andWhere("ob.gerenciaSecond = " . (int) $criteria['gerenciaSecond']);
            } else {
                unset($criteria['gerenciaSecond']);
            }
        }
        $queryBuilder->groupBy('i.ref');
        $queryBuilder->orderBy('i.ref');

        $this->applyPeriodCriteria($queryBuilder);

        return $this->getPaginator($queryBuilder);
    }

    /**
     * Indicadores de acuerdo a un objetivo
     * @param \Pequiven\ObjetiveBundle\Entity\Objetive $objetive
     * @return type
     */
    public function getByObjetiveTactic(\Pequiven\ObjetiveBundle\Entity\Objetive $objetive) {
        $qb = $this->getQueryBuilder();

        $qb->select('i.ref AS IndTacRef,i.description AS IndTac,i.goal AS IndTacGoal,i.weight AS IndTacPeso');
        $qb->addSelect('f.equation AS IndTacFormula');
        $qb->leftJoin('i.objetives', 'obj');
        $qb->leftJoin('i.formula', 'f');

        $qb->andWhere('i.deletedAt IS NULL');
        $qb->andWhere('obj.id = :idObjetive');

        $qb->setParameter('idObjetive', $objetive->getId());

        $qb->orderBy('i.ref');

        return $qb->getQuery()->getResult();
    }

    /**
     * Retorna los Indicadores de acuerdo a una Línea Estratégica seleccionada
     * @return type
     */
    public function findByLineStrategic($idLineStrategic) {
        $qb = $this->getQueryBuilder();
        $qb
                ->innerJoin('i.lineStrategics', 'ls')
                ->andWhere("ls.id = :idLineStrategic")
                ->andWhere("i.deletedAt IS NULL")
                ->setParameter('idLineStrategic', $idLineStrategic)
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * Retorna los indicadores de acuerdo a una Línea EStratégica seleccioanda y ordenados de acuerdo a como se mostrarán
     * @param type $idLineStrategic
     * @param type $orderBy
     */
    public function findByLineStrategicAndOrderShowFromParent($idLineStrategic, $orderBy = 'ASC', $parameters = array()) {
        $parameters = new \Doctrine\Common\Collections\ArrayCollection($parameters);

        $qb = $this->getQueryBuilder();
        $qb
                ->innerJoin('i.lineStrategics', 'ls')
                ->andWhere("ls.id = :idLineStrategic")
                ->andWhere("i.deletedAt IS NULL")
                ->setParameter('idLineStrategic', $idLineStrategic)
                ->orderBy('i.orderShowFromParent', $orderBy)
        ;

        if (($specific = $parameters->remove('specific')) != null) {
            $qb->andWhere('i.showByDashboardSpecific = 1');
            if (($complejo = $parameters->remove('complejo')) != null) {
                $qb->andWhere('i.complejoDashboardSpecific = :complejo')
                        ->setParameter('complejo', $complejo)
                ;
            }
        } else {
            $qb->andWhere('i.showByDashboardSpecific = 0');
        }

        $this->applyPeriodCriteria($qb);

        return $qb->getQuery()->getResult();
    }

    public function findByIndicatorGroup($groupId) {
        //$parameters = new \Doctrine\Common\Collections\ArrayCollection($parameters);

        $qb = $this->getQueryBuilder();
        $qb
                ->innerJoin('i.indicatorGroup', 'ig')
                ->andWhere("ig.id = :group")
                ->andWhere("i.deletedAt IS NULL")
                ->setParameter('group', $groupId)
        //->orderBy('i.orderShowFromParent', $orderBy)
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * 
     * @param type $idParent
     * @param type $orderBy
     * @return type
     */
    function findByParentAndOrderShow($idParent, $orderBy = 'ASC') {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder
                ->innerJoin('i.parent', 'ip')
                ->andWhere("ip.id = :idParent")
                ->andWhere("i.deletedAt IS NULL")
                ->andWhere("ip.deletedAt IS NULL")
                ->setParameter('idParent', $idParent)
                ->orderBy('i.orderShowFromParent', $orderBy)
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    /*
     * Query que retorna los indicadores que se les debe recalcular el resultado
     */

    public function findQueryWithResultNull(\Pequiven\SEIPBundle\Entity\Period $period) {
        $qb = $this->getQueryBuilder();
        $qb
                ->addSelect('i_o')
//            ->leftJoin('i.objetives', 'i_o')
                ->innerJoin('i.indicatorLevel', 'i_il')
                ->andWhere('i.period = :period')
                ->andWhere($qb->expr()->isNull('i.lastDateCalculateResult'))
                ->orderBy('i_il.level', 'DESC')
                ->setParameter('period', $period)
        ;
//        print_r($qb->getQuery()->getSQL());die();
        return $qb;
    }

    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);

        //Vinculación con el objetivo al que esta vinculado el indicador

        $queryBuilder
                ->andWhere('i.tmp = 0');
        //Visualización SIG
        if (($forviewSig = $criteria->remove('for_viewsig')) != null) {
            //$queryBuilder->addSelect('ms');

            $queryBuilder
                    ->innerJoin('i.objetives', 'o')
                    ->andWhere('o.deletedAt IS NULL')
                    ->andWhere('i.deletedAt IS NULL')
                    ->innerJoin('i.managementSystems', 'ms');

            //Filtro de Sistemas de Gestión
            if (($managementSystems = $criteria->remove('managementSystems')) != null) {
                $queryBuilder
                        ->andWhere('ms.id = :managementSystems')
                        ->setParameter('managementSystems', $managementSystems)
                ;
            }
        }
        // Visualización SEIP
        if (($forView = $criteria->remove('for_view')) !== null) {
            $queryBuilder
                    ->innerJoin('i.objetives', 'o')
                    ->andWhere('o.deletedAt IS NULL')
                    ->andWhere('i.deletedAt IS NULL')
            ;
        }
        //Filtro por referencia o descripción
        if (($description = $criteria->remove('description')) !== null) {
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('i.description', "'%" . $description . "%'"), $queryBuilder->expr()->like('i.ref', "'%" . $description . "%'")));
        }

        //Filtro por Tendencia
        if (($tendency = $criteria->remove('tendency')) !== null) {
            $queryBuilder->innerJoin('i.tendency', 't');
            $queryBuilder->andWhere($queryBuilder->expr()->like('t.description', "'%" . $tendency . "%'"));
        }

        //Filtro nivel del Indicador
        if (($level = $criteria->remove('indicatorLevel')) !== null) {
            if ($level > IndicatorLevel::LEVEL_ESTRATEGICO) {
                $queryBuilder->innerJoin('o.gerencia', 'g');
            }
            $queryBuilder->andWhere("i.indicatorLevel = " . $level);
        }

        //Filtro Localidad
        if (($complejo = $criteria->remove('complejo')) !== null) {
            $queryBuilder->andWhere('g.complejo = ' . $complejo);
        }

        //Filtro Gerencia 1ra Línea
        if (($gerencia = $criteria->remove('firstLineManagement')) !== null) {
            $queryBuilder->andWhere('o.gerencia = ' . $gerencia);
        }

        //Filtro Frecuencia de Notificación del Indicador
        if (($frequencyNotification = $criteria->remove('frequencyNotification')) !== null) {
            $queryBuilder->leftJoin('i.frequencyNotificationIndicator', 'fn');
            $queryBuilder->andWhere("i.frequencyNotificationIndicator = " . $frequencyNotification);
        }

        //Filtro Gerencia 2da Línea
        if (($gerenciaSecond = $criteria->remove('secondLineManagement')) !== null) {
            $queryBuilder->andWhere("o.gerenciaSecond = " . $gerenciaSecond);
        }

        //Filtro Misceláneo
        if (($miscellaneous = $criteria->remove('miscellaneous')) !== null) {
            if ($miscellaneous == Indicator::INDICATOR_WITHOUT_FORMULA) {
                $queryBuilder->andWhere('i.formula IS NULL');
            } elseif ($miscellaneous == Indicator::INDICATOR_WITH_RESULT) {
                $queryBuilder->andWhere($queryBuilder->expr()->orX('i.progressToDate > 0', 'i.lastDateCalculateResult IS NOT NULL'));
            } elseif ($miscellaneous == Indicator::INDICATOR_WITHOUT_RESULT) {
                $queryBuilder->andWhere($queryBuilder->expr()->orX('i.progressToDate = 0', 'i.lastDateCalculateResult IS NULL'));
//                $queryBuilder->andWhere('i.progressToDate = 0');
//                $queryBuilder->andWhere('i.lastDateCalculateResult IS NULL');
            } elseif ($miscellaneous == Indicator::INDICATOR_WITHOUT_FREQUENCY_NOTIFICATION) {
                if ($frequencyNotification == null) {
                    $queryBuilder->leftJoin('i.frequencyNotificationIndicator', 'fn');
                }
                $queryBuilder->andWhere('i.frequencyNotificationIndicator IS NULL');
            }
        }

        //Filtro Gerencias de Apoyo
        if (($support = $criteria->remove('type_gerencia_support')) != null) {
            if ($support == Gerencia::TYPE_WITH_GERENCIA_SECOND_SUPPORT) {//Incluir Gerencias de Apoyo
                $queryBuilder
                        ->innerJoin('o.gerenciaSecond', 'gs')
                        ->leftJoin('gs.gerenciaSupports', 'gsp')
                        ->orWhere('gsp.id = :gerencia')
                        ->setParameter('gerencia', $gerencia)
                ;
                if ($gerenciaSecond != null) {
                    $queryBuilder->andWhere('gs.id = ' . $gerenciaSecond);
                }
            } elseif ($support == Gerencia::TYPE_WITHOUT_GERENCIA_SECOND_SUPPORT) {//Excluir Gerencias de Apoyo
                if ($gerencia != null) {
                    $queryBuilder
                            ->innerJoin('o.gerenciaSecond', 'gs')
                            ->innerJoin('gs.gerencia', 'g1')
                            ->leftJoin('g1.gerenciaSecondVinculants', 'gv')
                            ->andWhere($queryBuilder->expr()->orX('g1.id = :gerencia AND gs.complejo = :complejo', 'gv.modular = 1 AND g1.id = :gerencia'))
                            ->setParameter('gerencia', $gerencia)
                            ->setParameter('complejo', $complejo)
                    ;
                } else {
                    $queryBuilder
                            ->innerJoin('o.gerenciaSecond', 'gs')
                            ->innerJoin('gs.gerencia', 'g1')
                            ->leftJoin('g1.gerenciaSecondVinculants', 'gv')
                            ->andWhere($queryBuilder->expr()->orX('gs.complejo = :complejo', 'gv.modular = 1'))
                            ->setParameter('complejo', $complejo)
                    ;
                }
            }
        }

        $applyPeriodCriteria = $criteria->remove('applyPeriodCriteria');
        parent::applyCriteria($queryBuilder, $criteria->toArray());
        //print_r($this->applyPeriodCriteria($queryBuilder));
        //print_r($queryBuilder->getQuery()->getSQL());
        //die();
        if ($applyPeriodCriteria) {
            $this->applyPeriodCriteria($queryBuilder);
        }
    }

    protected function applySorting(\Doctrine\ORM\QueryBuilder $queryBuilder, array $sorting = null) {
//        $sorting = new \Doctrine\Common\Collections\ArrayCollection($sorting);
//        
//        if(($sortByResultReal = $sorting->remove('resultReal')) !== null){
//            $queryBuilder->orderBy("i.resultReal",  strtoupper($sortByResultReal));
//        }

        parent::applySorting($queryBuilder, $sorting);
    }

    public function findQueryIndicatorValid($period, $level) {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder
                ->select('i')
                ->andWhere('i.period = :period')
                ->andWhere('i.indicatorLevel = :level')
                ->andWhere('i.showEvolutionView = :show')
                ->setParameter('period', $period)
                ->setParameter('level', $level)
                ->setParameter('show', 1)
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    protected function getAlias() {
        return 'i';
    }

}
