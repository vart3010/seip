<?php

namespace Pequiven\MasterBundle\Repository;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * GerenciaRepository (pequiven.repository.gerenciafirst)
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GerenciaRepository extends EntityRepository
{
    public function getGerenciaOptions($options = array()){
        $data = array();
        
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
                        ->select('g')
                        ->from('\Pequiven\MasterBundle\Entity\Gerencia', 'g')
                        ->andWhere('g.enabled = ' . 1);
//        var_dump($options);
//        var_dump("<br>");
//        var_dump(count($options['complejos']));
//        die();
        if(isset($options['complejoArray'])){
            $search = '';
            $total = count($options['complejoArray']);
            for($i=0;$i<$total;$i++){
                if($i == ($total-1)){
                    $search .= $options['complejoArray'][$i];
                } else{
                    $search .= $options['complejoArray'][$i].',';
                }
            }
            $query->andWhere('g.complejo IN (' . $search .')');
        } elseif(isset($options['complejos']) && $options['complejos'] != 0){
            $query->andWhere('g.complejo IN (' . $options['complejos'] .')');
        }
        
        
        $gerencias = $query->getQuery()
                           ->getResult();
        
        foreach($gerencias as $gerencia){
            if(!$gerencia->getComplejo()){
                continue;
            } 
            if(!array_key_exists($gerencia->getComplejo()->getDescription(), $data)){
                $data[$gerencia->getComplejo()->getDescription()] = array();
            }
            
            $data[$gerencia->getComplejo()->getDescription()][$gerencia->getId()] = $gerencia;
        }
        
        return $data;
    }
    
     /**
     * Crea un paginador para las gerencias de 1ra línea
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    function createPaginatorGerenciaFirst(array $criteria = null, array $orderBy = null) {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $user = $this->getUser();
        $queryBuilder->leftJoin('g.complejo', 'c');

        if(isset($criteria['description'])){
            $queryBuilder->andWhere($queryBuilder->expr()->like('g.description', "'%".$criteria['description']."%'"));
        }
        //Filtro localidad
        if(isset($criteria['complejo'])){
            $queryBuilder->andWhere($queryBuilder->expr()->like('c.description', "'%".$criteria['complejo']."%'"));
        }
        
        if(!$this->getSecurityContext()->isGranted(array('ROLE_WORKER_PLANNING','ROLE_DIRECTIVE','ROLE_DIRECTIVE_AUX'))){
            $queryBuilder->andWhere('g.id = '.$user->getGerencia()->getId());
        }
        
        
//        if(isset($criteria['rif'])){
//            $rif = $criteria['rif'];
//            unset($criteria['rif']);
//            $queryBuilder->andWhere($queryBuilder->expr()->like('o.rif', "'%".$rif."%'"));
//        }
//var_dump($queryBuilder->getQuery()->getSQL());
//die();
//        $this->applyCriteria($queryBuilder, $criteria);
//        $this->applySorting($queryBuilder, $orderBy);
        
        return $this->getPaginator($queryBuilder);
    }
    
    function findGerencia(array $criteria = null)
    {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        if(($complejo = $criteria->remove('complejo'))){
            $queryBuilder
                    ->innerJoin('g.complejo', 'c')
                    ->andWhere('c.id = :complejo')
                    ->setParameter('complejo', $complejo)
                ;
        }
        return $queryBuilder->getQuery()->getResult();
    }
 
    public function findWithObjetives($id) 
    {
        $qb = $this->getQueryBuilder();
        $qb
            ->addSelect('g_ot')
            ->addSelect('g_ot_c')
            ->addSelect('g_ot_p')
            ->leftJoin('g.tacticalObjectives', 'g_ot')
            ->leftJoin('g_ot.childrens', 'g_ot_c')
            ->leftJoin('g_ot.parents', 'g_ot_p')
            ->leftJoin('g_ot.objetiveLevel', 'g_ot_ol')
            ->andWhere('g.id = :gerencia')
            ->andWhere('g_ot_ol.level = :level')
            ->setParameter('gerencia', $id)
            ->setParameter('level',  \Pequiven\ObjetiveBundle\Entity\ObjetiveLevel::LEVEL_TACTICO)
        ;
        $this->applyPeriodCriteria($qb);
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    protected function getAlias() {
        return 'g';
    }
}