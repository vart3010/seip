<?php

namespace Pequiven\SEIPBundle\Repository\Sip;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de onePerTenFile
 *
 * @author Matías Jiménez matei249@gmail.com
 */
class OnePerTenFileRepository extends SeipEntityRepository {

    function createPaginatorMeetingFile(array $criteria = null, array $orderBy = null) {
        return $this->createPaginator($criteria, $orderBy);
    }

    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);

        $queryBuilder->innerJoin('optf.meeting', 'm');

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

        if (($workStudyCircle = $criteria->remove('workStudyCircle'))) {
            $queryBuilder
                    ->andWhere('wsc.id = :workStudyCircle')
                    ->setParameter('workStudyCircle', $workStudyCircle)
            ;
        }
        
        if (($categoryFile = $criteria->remove('categoryFile'))) {
            $queryBuilder
                    ->innerJoin('optf.categoryFile', 'cf')
                    ->andWhere('cf.id= :categoryFile')
                    ->setParameter('categoryFile', $categoryFile)
            ;
        }

        parent::applyCriteria($queryBuilder, $criteria->toArray());
    }

    protected function getAlias() {
        return 'optf';
    }

}
