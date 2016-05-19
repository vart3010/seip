<?php

namespace Pequiven\SEIPBundle\Repository\Sip;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio de 1x10
 * @author Victor Tortolero vart10.30@gmail.com
 */
class OnePerTenRepository extends EntityRepository {



    public function createPaginatorByOnePerTen(array $criteria = null, array $orderBy = null) {
        $criteria['for_one'] = true;
        return $this->createPaginator($criteria, $orderBy);
    }
    
    /*
     * Query que retorna los usuarios que se les debe recalcular el perfil
     */

    public function findQueryWithResultNull(\Pequiven\SEIPBundle\Entity\Period $period) {
        $qb = $this->getQueryBuilder();
        $qb
                ->innerJoin('opt.user', 'u')
                ->andWhere($qb->expr()->isNull('opt.lastDateCalculateProfile'))
        ;

        return $qb;
    }

    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);

        if(($for_one = $criteria->remove('for_one')) != null){
            $queryBuilder
                    ->innerJoin('opt.user', 'u')
//                    ->innerJoin('opt.ten', 't')
            ;
        }
        
        if (($description = $criteria->remove('userName')) != null) {
            $queryBuilder->andWhere($queryBuilder->expr()->orX($queryBuilder->expr()->like('u.firstname', "'%" . $description . "%'"), $queryBuilder->expr()->like('u.lastname', "'%" . $description . "%'")));
        }
        if (($complejo = $criteria->remove('complejo')) != null) {
            $queryBuilder
                    ->andWhere("u.complejo = :complejo")
                    ->setParameter("complejo", $complejo);
        }

        if (($gerencia = $criteria->remove('firstLineManagement'))) {
            $queryBuilder
                    ->andWhere('u.gerencia= :gerencia')
                    ->setParameter('gerencia', $gerencia)
            ;
        }

        if (($gerenciaSecond = $criteria->remove('secondLineManagement'))) {
            $queryBuilder
                    ->andWhere('u.gerenciaSecond = :gerenciaSecond')
                    ->setParameter('gerenciaSecond', $gerenciaSecond)
            ;
        }

        if (($workStudyCircle = $criteria->remove('workStudyCircle'))) {
            $queryBuilder
                    ->andWhere('u.workStudyCircle = :workStudyCircle')
                    ->setParameter('workStudyCircle', $workStudyCircle)
            ;
        }
        
        if (($profileValue = $criteria->remove('profilesPoliticEvaluation'))) {
            $queryBuilder
                    ->andWhere('opt.profileValue = :profileValue')
                    ->setParameter('profileValue', $profileValue)
            ;
        }
        
        if (($voto = $criteria->remove('voto'))) {
            $numVoto = 0;
            if($voto == 'SI'){
                $numVoto = 1;
            }
            $queryBuilder->andWhere('opt.voto = '.$numVoto);
        }

        parent::applyCriteria($queryBuilder, $criteria->toArray());
    }

//    public function getValidUsers() {
//
//        $query = $this->getQueryBuilder();
//
//        $query->select("u.cedula")
//                ->from("seip_user", "u")
//                ->innerJoin('i.indicatorLevel', 'o_il')
//                ->andWhere('i.enabled = 1');
//
//        $q = $query->getQuery();
//
//        return $q->getResult();
//    }

    public function getOnePerTen($id) {

        $query = $this->getQueryBuilder();

        $query
                ->andWhere('opt.user = :idOne')
                ->setParameter("idOne", $id)
        ;

        $q = $query->getQuery();

        return $q->getResult();
    }

    public function getOnePerTenVoto($cedula) {

        $query = $this->getQueryBuilder();

        $query
                ->andWhere('opt.cedula = :ced')
                ->setParameter("ced", $cedula)
        ;

        $q = $query->getQuery();

        return $q->getResult();
    }
    
    protected function getAlias() {
        return 'opt';
    }

}
