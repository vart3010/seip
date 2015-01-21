<?php

namespace Pequiven\ArrangementProgramBundle\Repository;

use Tecnocreaciones\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;
use Pequiven\SEIPBundle\Entity\Period;
use Pequiven\SEIPBundle\Entity\User;

/**
 * Repositorio de programa de gestion
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArrangementProgramRepository extends EntityRepository
{
    /**
     * Retorna un programa de gestion pre hidratado para evitar tantas consultas a la base de datos.
     * 
     * @param type $id
     * @return type
     */
    public function findWithData($id) 
    {
        $qb = $this->getQueryBuilder();
        $qb
            ->addSelect('ap_r')
            ->addSelect('ap_t')
            ->addSelect('ap_t_g')
            ->addSelect('ap_t_g_r')
            ->addSelect('ap_r_g')
            ->addSelect('ap_t_g_r_g')
            ->leftJoin('ap.responsibles','ap_r')
            ->leftJoin('ap_r.groups','ap_r_g')
            ->leftJoin('ap.timeline','ap_t')
            ->leftJoin('ap_t.goals','ap_t_g')
            ->leftJoin('ap_t_g.responsibles','ap_t_g_r')
            ->leftJoin('ap_t_g_r.groups','ap_t_g_r_g')
            ->andWhere('ap.id = :id')
            ->setParameter('id', $id)
        ;
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    /**
     * Retorna todos los programas de gestion pre hidratados para evitar tantas consultas
     * @param array $criteria
     * @return type
     */
    public function findAllWithData(array $criteria = array()) 
    {
        $qb = $this->getQueryBuilder();
        $qb
            ->addSelect('ap_r')
            ->addSelect('ap_t')
            ->addSelect('ap_t_g')
            ->addSelect('ap_t_g_r')
            ->addSelect('ap_r_g')
            ->addSelect('ap_t_g_r_g')
            ->leftJoin('ap.responsibles','ap_r')
            ->leftJoin('ap_r.groups','ap_r_g')
            ->leftJoin('ap.timeline','ap_t')
            ->leftJoin('ap_t.goals','ap_t_g')
            ->leftJoin('ap_t_g.responsibles','ap_t_g_r')
            ->leftJoin('ap_t_g_r.groups','ap_t_g_r_g')
        ;
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        if(($period = $criteria->remove('period'))){
            $qb
                ->andWhere('ap.period = :period')
                ->setParameter('period', $period)
            ;
        }
        return $qb->getQuery()->getResult();
    }
    
    /**
     * Retorna los programas de gestion que tengan de responsable el usuario
     */
    function findByUserAndPeriodNotGoals(User $user,Period $period,array $criteria = array())
    {
        $qb = $this->getQueryBuilder();
        $qb->innerJoin('ap.responsibles', 'ap_r')
           ->andWhere('ap_r.id = :responsible')
           ->andWhere('ap.period = :period')
           ->setParameter('responsible', $user)
           ->setParameter('period', $period);
        if(isset($criteria['notArrangementProgram'])){
            $qb->andWhere('ap.id != :arrangementProgram');
            $qb->setParameter('arrangementProgram', $criteria['notArrangementProgram']);
        }
        return $qb->getQuery()->getResult();
    }
    
    function findGroupByType($type,array $criteria = array())
    {
        $qb = $this->getQueryBuilder();
        $qb
            ->andWhere('ap.type = :type')
            ->setParameter('type',$type)
            ->andWhere('ap.status = :status')  
            ->setParameter('status', \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::STATUS_REVISED)
            ;
        $qb
            ->innerJoin('ap.tacticalObjective','to')
            ->innerJoin('to.gerencia','to_g')
            ->innerJoin('to_g.configuration','to_g_c');
        if($type == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC){
            $qb->innerJoin('to_g_c.arrangementProgramUsersToApproveTactical', 'to_g_c_apt')
               ->andWhere('to_g_c_apt.id = :user');
        }else if($type == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
            $qb->innerJoin('to_g_c.arrangementProgramUsersToApproveOperative', 'to_g_c_ap')
               ->andWhere('to_g_c_ap.id = :user');
        }
        $qb->setParameter('user', $this->getUser());
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     * Programas de Gestión Cargados y por status (en borrador, en revisión, revisados, aprobados, rechazados y finalizados)
     * @param array $criteria
     * @return type
     */
    public function getSummaryCharged(array $criteria = null){
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        $gerencia = $criteria['gerencia'];
        $qb = $this->getQueryBuilder();
        $qb
            ->leftJoin('ap.tacticalObjective','to')
            ->andWhere('to.gerencia = '.$gerencia)
                ;
        if(isset($criteria['type']) && $criteria['type'] == ArrangementProgram::SUMMARY_TYPE_CHARGED){
            $qb
                ->andWhere('ap.status <= :status')
                ->setParameter('status', ArrangementProgram::STATUS_APPROVED);
            $criteria->remove('type');
        } else{
            $status = $criteria->remove('status');
            $qb
                ->andWhere('ap.status = :status')
                ->setParameter('status', $status);
        }
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     * Retorna los Programas de Gestión por Notificados, No Notificados o con Proceso de Notificación sin cerrar
     * @param array $criteria
     */
    public function getNotified(array $criteria = null){
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        $gerencia = $criteria['gerencia'];
        $qb = $this->getQueryBuilder();
        $qb
            ->leftJoin('ap.tacticalObjective','to')
            ->andWhere('to.gerencia = '.$gerencia)
            ->andWhere('ap.status = :status')
            ->innerJoin('ap.details', 'd')
            ->setParameter('status', ArrangementProgram::STATUS_APPROVED)
                ;
        if(isset($criteria['type'])){
            if($criteria['type'] == ArrangementProgram::SUMMARY_TYPE_NOTIFIED){
                $qb->andWhere($qb->expr()->orX('d.lastNotificationInProgressByUser IS NOT NULL','ap.totalAdvance > 0'));
            } elseif($criteria['type'] == ArrangementProgram::SUMMARY_TYPE_NOT_NOTIFIED){
                $qb->andWhere($qb->expr()->orX('d.notificationInProgressByUser IS NOT NULL AND ap.totalAdvance = 0','ap.totalAdvance = 0'));
            } elseif($criteria['type'] == ArrangementProgram::SUMMARY_TYPE_NOTIFIED_BUT_STILL_IN_PROGRESS){
                $qb->andWhere('d.notificationInProgressByUser IS NOT NULL');
                $qb->andWhere('ap.totalAdvance > 0');
            }
        } 
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return type
     */
    public function createPaginatorByRol(array $criteria = null, array $orderBy = null) {
        $this->getUser();
        return parent::createPaginator($criteria, $orderBy);
    }
    
    /**
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return type
     */
    public function createPaginatorByGerencia(array $criteria = null, array $orderBy = null) {
        $this->getUser();
        return parent::createPaginator($criteria, $orderBy);
//        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
//        
//        $queryBuilder = $this->getCollectionQueryBuilder();
//        $queryBuilder->innerJoin('ap.tacticalObjective', 'o');
//        if(($gerencia = $criteria->remove('gerencia')) != null){
//            $queryBuilder->andWhere('o.gerencia = ' . $gerencia);
//        }
//        
//        if(isset($criteria['status'])){
//            $queryBuilder->andWhere('ap.status = ' . $criteria['status']);
//        }
//        
////        $this->applyCriteria($queryBuilder, $criteria);
////        $this->applySorting($queryBuilder, $orderBy);
//
//        return $this->getPaginator($queryBuilder);
    }
    
    /**
     * Retorna los programas de gestion los cuales tengo asignados para revision o aprobacion
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return type
     */
    public function createPaginatorByAssigned(array $criteria = null, array $orderBy = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        $user = $criteria->remove('ap.user');
        
        $user->getId();
        $period = $criteria->remove('ap.period');
        
        
        $queryBuilder = $this->getCollectionQueryBuilder();
        $this->applyCriteria($queryBuilder, $criteria->toArray());
        
        $queryBuilder
                ->addSelect('to')
                ->addSelect('to_g')
                ->addSelect('to_g_c')
                ;
        
        $queryBuilder
            ->innerJoin('to_g.configuration','to_g_c');
        
        $queryBuilder->leftJoin('to_g_c.arrangementProgramUserToRevisers', 'to_g_c_apr');
        $queryBuilder->leftJoin('to_g_c.arrangementProgramUsersToApproveTactical', 'to_g_c_apt');
        $queryBuilder->leftJoin('to_g_c.arrangementProgramUsersToApproveOperative', 'to_g_c_ap');
        
        $queryBuilder->andWhere($queryBuilder->expr()->orX('to_g_c_apr.id = :user','to_g_c_apt.id = :user','to_g_c_ap.id = :user'));
        $queryBuilder
            ->andWhere('ap.period = :period')
            ->setParameter('period', $period)
            ;
        
        $queryBuilder->setParameter('user', $user);
        $this->applySorting($queryBuilder, $orderBy);
        
        $results = $queryBuilder->getQuery()->getResult();        
        $filterResults = array();
        foreach ($results as $result) {
            if($result->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
                $gerenciaSecondToNotify = null;
                $objetiveOperative = $result->getOperationalObjective();
                $gerenciaSecond = $objetiveOperative->getGerenciaSecond();
                if(
                    $gerenciaSecond && ($gerencia = $gerenciaSecond->getGerencia()) != null 
                    && ($gerenciaGroup = $gerencia->getGerenciaGroup()) != null
                    && $gerenciaGroup->getGroupName() == \Pequiven\MasterBundle\Entity\GerenciaGroup::TYPE_COMPLEJOS
                    )
                    {
                    $gerenciaSecondToNotify = $gerenciaSecond;
                }
                if($gerenciaSecondToNotify !== null && $user->getGerenciaSecond() !== $gerenciaSecond){
                    continue;
                }
            }
            $filterResults[] = $result;
        }
        $pagerfanta = new \Tecnocreaciones\Bundle\ResourceBundle\Model\Paginator\Paginator(new \Pagerfanta\Adapter\ArrayAdapter($filterResults));
        $pagerfanta->setContainer($this->container);
        return $pagerfanta;
    }
    
    /**
     * Retorna los programas de gestion los cuales tengo asignados para notificar
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return type
     */
    public function createPaginatorByNotified(array $criteria = null, array $orderBy = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        $user = $criteria->remove('ap.user');
        
        $user->getId();
        $period = $criteria->remove('ap.period');
        
        
        $queryBuilder = $this->getCollectionQueryBuilder();
        $this->applyCriteria($queryBuilder, $criteria->toArray());
        
        $queryBuilder
                ->addSelect('to')
                ->addSelect('to_g')
                ->addSelect('to_g_c')
                ;
        
        $queryBuilder
            ->innerJoin('to_g.configuration','to_g_c');
        
        $queryBuilder->leftJoin('to_g_c.arrangementProgramUsersToNotify', 'to_g_c_apn');
        
        $queryBuilder->andWhere($queryBuilder->expr()->orX('to_g_c_apn.id = :user'));
        $queryBuilder
            ->andWhere('ap.period = :period')
            ->setParameter('period', $period)
            ;
        
        $queryBuilder->setParameter('user', $user);
        $this->applySorting($queryBuilder, $orderBy);
        
        $results = $queryBuilder->getQuery()->getResult();        
        $filterResults = array();
        foreach ($results as $result) {
            if($result->getType() == ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
                $gerenciaSecondToNotify = null;
                $objetiveOperative = $result->getOperationalObjective();
                $gerenciaSecond = $objetiveOperative->getGerenciaSecond();
                if(
                    $gerenciaSecond && ($gerencia = $gerenciaSecond->getGerencia()) != null 
                    && ($gerenciaGroup = $gerencia->getGerenciaGroup()) != null
                    && $gerenciaGroup->getGroupName() == \Pequiven\MasterBundle\Entity\GerenciaGroup::TYPE_COMPLEJOS
                    )
                    {
                    $gerenciaSecondToNotify = $gerenciaSecond;
                }
                if($gerenciaSecondToNotify !== null && $user->getGerenciaSecond() !== $gerenciaSecond){
                    continue;
                }
            }
            $filterResults[] = $result;
        }
        $pagerfanta = new \Tecnocreaciones\Bundle\ResourceBundle\Model\Paginator\Paginator(new \Pagerfanta\Adapter\ArrayAdapter($filterResults));
        $pagerfanta->setContainer($this->container);
        return $pagerfanta;
    }
    
    /**
     * Retorna los programas de gestion los cuales tengo asignados para revision o aprobacion
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return type
     */
    public function createPaginatorByAssignedResponsibles(array $criteria = null, array $orderBy = null) {
        
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        
        $qb = $this->getQueryBuilder();
        $qb
            ->innerJoin('ap.responsibles', 'ap_r')
            ->innerJoin('ap.timeline', 't')
            ->innerJoin('t.goals', 't_g')
            ->innerJoin('t_g.responsibles', 't_g_r')
            ;
        
        if(($period = $criteria->remove('ap.period')) != null){
            $qb
                ->andWhere('ap.period = :period')
                ->setParameter('period', $period)
                ;
        }
        if(($user = $criteria->remove('ap.user')) != null){
            $qb
               ->andWhere($qb->expr()->orX('ap_r.id = :responsible','t_g_r.id = :responsible'))
               ->setParameter('responsible', $user)
                ;
        }
        
        $this->applyCriteria($qb,$criteria->toArray());
        $this->applySorting($qb, $orderBy);
        
        return $this->getPaginator($qb);
    }
    
    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        
        $queryBuilder
                ->addSelect('to')
                ->addSelect('to_g')
                ->addSelect('oo')
                ->addSelect('gs')
                ;
                
        $queryBuilder
                    ->leftJoin('ap.tacticalObjective', 'to')
                    ->leftJoin('to.gerencia', 'to_g')
                    ->leftJoin('ap.operationalObjective', 'oo')
                    ->leftJoin('oo.gerenciaSecond', 'gs')
                ;
        if(($ref = $criteria->remove('ap.ref'))){
            $queryBuilder->andWhere($queryBuilder->expr()->like('ap.ref',"'%".$ref."%'"));
        }
        if(($status = $criteria->remove('status')) !== null){
            $queryBuilder
                    ->andWhere('ap.status = :status')
                    ->setParameter('status', $status)
                    ;
        }
        if(($process = $criteria->remove('ap.process'))){
            $queryBuilder->andWhere($queryBuilder->expr()->like('ap.process',"'%".$process."%'"));
        }
        if(($period = $criteria->remove('ap.period'))){
            $queryBuilder->innerJoin('ap.period','p');
            $queryBuilder->andWhere($queryBuilder->expr()->like('p.name',"'%".$period."%'"));
        }
        
        if(($complejo = $criteria->remove('complejo')) != null && $complejo > 0){
            $queryBuilder
                    ->andWhere('to_g.complejo = :complejo')
                ->setParameter('complejo', $complejo)
                ;
        }
        
        if(($responsiblesJson = $criteria->remove('responsibles')) != null && $responsiblesJson != null){
            $responsibles = json_decode($responsiblesJson);
            if(is_array($responsibles)){
                $queryBuilder
                        ->innerJoin('ap.responsibles','ap_r')
                        ->andWhere($queryBuilder->expr()->in('ap_r.id', $responsibles))
                    ;
            }
        }
        if(($responsiblesGoalsJson = $criteria->remove('responsiblesGoals')) != null && $responsiblesGoalsJson != null){
            $responsiblesGoals = json_decode($responsiblesGoalsJson);
            if(is_array($responsiblesGoals)){
                $queryBuilder
                        ->innerJoin('ap.timeline','t')
                        ->innerJoin('t.goals','go')
                        ->innerJoin('go.responsibles','go_r')
                        ->andWhere($queryBuilder->expr()->in('go_r.id', $responsiblesGoals))
                    ;
            }
        }
        if(($tactical = $criteria->remove('tacticalObjective')) != null){
            $queryBuilder
                    ->andWhere('to.id = :tacticalObjective')
                ->setParameter('tacticalObjective', $tactical)
                ;
        }
        if(($operationalObjective = $criteria->remove('operationalObjective')) != null){
            $queryBuilder
                    ->andWhere('oo.id = :operationalObjective')
                ->setParameter('operationalObjective', $operationalObjective)
                ;
        }
        //Filtro de gerencia de primera linea
        if(($firstLineManagement = $criteria->remove('firstLineManagement')) != null){
            $queryBuilder
                    
                    ->andWhere('to_g.id = :firstLineManagement')
                ->setParameter('firstLineManagement', $firstLineManagement)
                ;
        }
        //Filtro de gerencia de segunda linea
        if(($secondLineManagement = $criteria->remove('secondLineManagement')) != null){
            $queryBuilder
                    ->andWhere('gs.id = :secondLineManagement')
                ->setParameter('secondLineManagement', $secondLineManagement)
                ;
        }
        //Filtro de gerencia de segunda linea modular y vinculante
        if(($typeManagement = $criteria->remove('typeManagement')) != null){
            if($typeManagement == \Pequiven\MasterBundle\Model\GerenciaSecond::TYPE_MANAGEMENT_MODULAR){
                $queryBuilder
                        ->andWhere('gs.modular = :typeManagement');
            }else{
                $queryBuilder
                        ->andWhere('gs.vinculante = :typeManagement');
            }
            $queryBuilder
                    ->setParameter('typeManagement', true)
                ;
        }
        
        //VISTA PLANIFICACIÓN POR GERENCIA
        if(isset($criteria['view_planning'])){
            if($criteria['view_planning'] == true){
                $criteria->remove('view_planning');
                $type = $criteria['type'];
                $criteria->remove('type');
                if($type == ArrangementProgram::SUMMARY_TYPE_NOTIFIED){
                    $queryBuilder
                            ->innerJoin('ap.details', 'd')
                            ->andWhere($queryBuilder->expr()->orX('d.lastNotificationInProgressByUser IS NOT NULL','ap.totalAdvance > 0'))
                            ->andWhere('ap.status = :status')
                            ->setParameter('status', ArrangementProgram::STATUS_APPROVED)
                        ;
                } elseif($type == ArrangementProgram::SUMMARY_TYPE_NOT_NOTIFIED){
                    $queryBuilder
                            ->innerJoin('ap.details', 'd')
                            ->andWhere($queryBuilder->expr()->orX('d.notificationInProgressByUser IS NOT NULL AND ap.totalAdvance = 0','ap.totalAdvance = 0'))
                            ->andWhere('ap.status = :status')
                            ->setParameter('status', ArrangementProgram::STATUS_APPROVED)
                        ;
                } elseif($type == ArrangementProgram::SUMMARY_TYPE_NOTIFIED_BUT_STILL_IN_PROGRESS){
                    $queryBuilder
                            ->innerJoin('ap.details', 'd')
                            ->andWhere('d.notificationInProgressByUser IS NOT NULL')
                            ->andWhere('ap.totalAdvance > 0')
                            ->andWhere('ap.status = :status')
                            ->setParameter('status', ArrangementProgram::STATUS_APPROVED)
                            ;
                }
            }
        }
        
        parent::applyCriteria($queryBuilder, $criteria->toArray());
    }
    protected function applySorting(\Doctrine\ORM\QueryBuilder $queryBuilder, array $sorting = null) {
        parent::applySorting($queryBuilder, $sorting);
    }
    
    protected function getAlias() {
        return 'ap';
    }
}
