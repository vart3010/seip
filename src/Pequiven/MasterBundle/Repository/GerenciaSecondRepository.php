<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\MasterBundle\Repository;

use Pequiven\MasterBundle\Entity\Gerencia;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Description of GerenciaSecondRepository
 *
 * @author matias
 */
class GerenciaSecondRepository extends EntityRepository {

    public function getGerenciaSecondOptions($options = array()) {
        $data = array();

        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
                ->select('gs')
                ->from('\Pequiven\MasterBundle\Entity\GerenciaSecond', 'gs')
                ->andWhere('gs.enabled = ' . 1);

        //En caso de que se conozca las
        if (isset($options['gerencias']) && $options['gerencias'] != 0) {
            $query->andWhere("gs.gerencia IN (" . implode(',', $options['gerencias']) . ')');
        }

        $gerencias = $query->getQuery()
                ->getResult();

        foreach ($gerencias as $gerencia) {
            if (!$gerencia->getGerencia()->getComplejo() && !$gerencia->getGerencia()) {
                continue;
            }
            if (!array_key_exists($gerencia->getGerencia()->getComplejo()->getDescription() . '-' . $gerencia->getGerencia()->getDescription(), $data)) {
                $data[$gerencia->getGerencia()->getComplejo()->getDescription() . '-' . $gerencia->getGerencia()->getDescription()] = array();
            }

            $data[$gerencia->getGerencia()->getComplejo()->getDescription() . '-' . $gerencia->getGerencia()->getDescription()][$gerencia->getId()] = $gerencia;
        }

        return $data;
    }

    /**
     * Crea un paginador para las gerencias de 2da línea
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorGerenciaSecond(array $criteria = null, array $orderBy = null) {
        $queryBuilder = $this->getCollectionQueryBuilder();

        $queryBuilder->leftJoin('gs.gerencia', 'g');
        $queryBuilder->leftJoin('gs.complejo', 'c');

        //Filtro gerencia 2da Línea
        if (isset($criteria['gerenciaSecond'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('gs.description', "'%" . $criteria['gerenciaSecond'] . "%'"));
        }
        if (isset($criteria['gerenciaSecondId'])) {
            $queryBuilder
                    ->andWhere('gs.id = :gerenciaSecondId')
                    ->setParameter('gerenciaSecondId', $criteria['gerenciaSecondId'])
            ;
        }
        //Filtro gerencia 1ra Línea
        if (isset($criteria['gerenciaFirst'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('g.description', "'%" . $criteria['gerenciaFirst'] . "%'"));
        }
        if (isset($criteria['gerenciaFirstId'])) {
            $queryBuilder
                    ->andWhere('g.id = :gerenciaFirstId')
                    ->setParameter('gerenciaFirstId', $criteria['gerenciaFirstId'])
            ;
        }
        //Filtro localidad
        if (isset($criteria['complejo'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('c.description', "'%" . $criteria['complejo'] . "%'"));
        }
        if (isset($criteria['complejoId'])) {
            $queryBuilder
                    ->andWhere('c.id = :complejoId')
                    ->setParameter('complejoId', $criteria['complejoId'])
            ;
        }

//        $this->applyCriteria($queryBuilder, $criteria);
//        $this->applySorting($queryBuilder, $orderBy);

        return $this->getPaginator($queryBuilder);
    }

    /**
     * Filtro de Gerencia de 2da Línea para las diferentes listas en el sistema
     * @param array $criteria
     * @return type
     */
    function findGerenciaSecond(array $criteria = null) {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);

        if (isset($criteria['view_planning'])) {
            $criteria->remove('view_planning');
        }

        $queryBuilder
                ->andWhere('gs.enabled = :enabled')
                ->setParameter('enabled', true)
        ;

        //Filtro de gerencia de segunda línea modular y vinculante
        if (($typeManagement = $criteria->remove('typeManagement')) != null) {
            $complejo = $criteria->remove('complejo');
            $queryBuilder
                    ->andWhere('gs.complejo = :complejo');

            if ($typeManagement == \Pequiven\MasterBundle\Model\GerenciaSecond::TYPE_MANAGEMENT_MODULAR) {
                $queryBuilder
                        ->andWhere('gs.modular = :typeManagement');
            } else {
                $queryBuilder
                        ->andWhere('gs.vinculante = :typeManagement');
            }
            $queryBuilder
                    ->setParameter('typeManagement', true)
                    ->setParameter('complejo', $complejo)
            ;
        } else if (($gerencia = $criteria->remove('gerencia')) != null) {
            $complejo = $criteria->remove('complejo');
            if (($typeSupport = $criteria->remove('type_gerencia_support')) != null) {
                $queryBuilder
                        ->innerJoin('gs.gerencia', 'g')
                        ->leftJoin('g.gerenciaSecondVinculants', 'gv')
                ;
                if ($typeSupport == Gerencia::TYPE_WITHOUT_GERENCIA_SECOND_SUPPORT) {//Solo se da para el caso de que la gerencia este en Sede Corporativa
                    $queryBuilder
                            ->andWhere($queryBuilder->expr()->orX('g.id = :gerencia AND gs.complejo = :complejo', 'gv.modular = 1 AND g.id = :gerencia'))
                            ->setParameter('complejo', $complejo)
                    ;
                } elseif ($typeSupport == Gerencia::TYPE_WITH_GERENCIA_SECOND_SUPPORT) {//Solo se da para las gerencias generales de los complejos
                    $queryBuilder
                            ->leftJoin('gs.gerenciaSupports', 'gsp')
                            ->andWhere($queryBuilder->expr()->orX('g.id = :gerencia', 'gv.id = :gerencia', 'gsp.id = :gerencia'))
                    ;
                }
            } else {
                $queryBuilder
                        ->innerJoin('gs.gerencia', 'g')
                        ->leftJoin('gs.gerenciaVinculants', 'gv')
                ;
                $queryBuilder->andWhere($queryBuilder->expr()->orX('g.id = :gerencia', 'gv.id = :gerencia'));
            }

            $queryBuilder
                    ->setParameter('gerencia', $gerencia)
            ;
        } elseif (($complejo = $criteria->remove('complejo')) != null) {
            $queryBuilder
                    ->andWhere('gs.complejo = :complejo')
                    ->setParameter('complejo', $complejo)
            ;
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Gerencias de Segunda Línea de acuerdo a una gerencia de 1ra línea
     * @param type $options
     * @return type
     */
    public function findByGerenciaFirst($options = array()) {
        $qb = $this->getQueryBuilder();

        if (isset($options['gerencia'])) {
            $qb->andWhere('gs.gerencia = ' . $options['gerencia']);
            $qb->leftJoin('gs.gerenciaVinculants', 'gv');
            $qb->orWhere('gv.id = ' . $options['gerencia']);
            $qb->leftJoin('gs.gerenciaSupports', 'gsp');
            $qb->orWhere('gsp.id = ' . $options['gerencia']);
        }

        $qb
                ->andWhere('gs.enabled = :enabled')
                ->setParameter('enabled', true)
        ;

        return $qb->getQuery()->getResult();
    }

    public function findWithObjetives($id) {
        $qb = $this->getQueryBuilder();
        $qb
                ->addSelect('gs_ob')
                ->addSelect('gs_ob_c')
                ->addSelect('gs_ob_p')
                ->leftJoin('gs.operationalObjectives', 'gs_ob', \Doctrine\ORM\Query\Expr\Join::WITH, 'gs_ob.period = :period')
                ->leftJoin('gs_ob.childrens', 'gs_ob_c')
                ->leftJoin('gs_ob.parents', 'gs_ob_p')
                ->andWhere('gs.id = :gerencia')
                ->andWhere('gs.enabled = :enabled')
                ->setParameter('gerencia', $id)
                ->setParameter('enabled', true)
        ;
        $this->setParameterPeriod($qb);
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getgerenciasSecondQueryBuilder($gerencia) {
        $qb = $this->getQueryBuilder();
        $qb
                ->select('gs')
                ->andWhere('gs.enabled= :Enabled')
                ->andWhere('gs.gerencia= :gerencia')
                ->setParameter('Enabled', 1)
                ->setParameter('gerencia', $gerencia);
        return $qb;
    }

    public function getgerenciasSecond($gerencia) {
        $qb = $this->getgerenciasSecondQueryBuilder($gerencia);
        return $qb->getQuery()->getResult();
    }

    protected function getAlias() {
        return 'gs';
    }

}
