<?php

namespace Pequiven\SEIPBundle\Repository\Politic;

use Pequiven\SEIPBundle\Entity\Politic\Meeting;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de MEETINGS
 *
 * @author Victor Tortolero vart10.30@gmail.com
 */
class MeetingRepository extends SeipEntityRepository {

    /**
     * Crea un paginador para las reuniones
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorMeetings(array $criteria = null, array $orderBy = null) {
        $orderBy['mtg.id'] = 'ASC';
        return $this->createPaginator($criteria, $orderBy);
    }

    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);

        $queryBuilder->innerJoin('mtg.workStudyCircle', 'wsc');

        if (($phase = $criteria->remove('phase'))) {
            $queryBuilder
                    ->andWhere('wsc.phase = :phase')
                    ->setParameter('phase', $phase)
            ;
        }

        if (($createdAt = $criteria->remove('createdAt'))) {
            $queryBuilder
                    ->andWhere('SUBSTRING(mtg.date, 1, 4) =:createdAt')
                    ->setParameter('createdAt', $createdAt)
            ;
        }

        //Filtro Localidad
        if (($complejo = $criteria->remove('complejo')) !== null) {
            $queryBuilder
                    ->andWhere('wsc.complejo = :complejo')
                    ->setParameter('complejo', $complejo)
            ;
        }

        if (($gerencia = $criteria->remove('firstLineManagement'))) {
            $queryBuilder
                    ->innerJoin('wsc.gerencias', 'g')
                    ->andWhere('g.id = :gerencia')
                    ->setParameter('gerencia', $gerencia)
            ;
        }

        if (($gerenciaSecond = $criteria->remove('secondLineManagement'))) {
            $queryBuilder
                    ->innerJoin('wsc.gerenciaSeconds', 'gs')
                    ->andWhere('gs.id = :gerenciaSecond')
                    ->setParameter('gerenciaSecond', $gerenciaSecond)
            ;
        }

        if (($workStudyCircle = $criteria->remove('workStudyCircle'))) {
            $queryBuilder
                    ->andWhere('wsc.id = :workStudyCircle')
                    ->setParameter('workStudyCircle', $workStudyCircle)
            ;
        }

        parent::applyCriteria($queryBuilder, $criteria->toArray());
    }

    /**
     * Reunioes por complejo
     *
     *
     */
    function findQueryMeetingsComplejo($complejo, $period) {

        $qb = $this->getQueryBuilder();
        $qb
                ->innerJoin('mtg.workStudyCircle', 'wsc')
                ->andWhere('wsc.complejo = :complejo')
                ->andWhere('SUBSTRING(mtg.date, 1, 4) = :period')
                ->setParameter('complejo', $complejo)
                ->setParameter('period', $period)
        ;

        return $qb->getQuery()->getResult();
    }

    function findMeetingsbyPeriod($period) {

        $qb = $this->getQueryBuilder();
        $qb
                ->andWhere('SUBSTRING(mtg.date, 1, 4) = :period')
                ->setParameter('period', $period)
        ;

        return $qb->getQuery()->getResult();
    }

    protected function getAlias() {
        return 'mtg';
    }

}
