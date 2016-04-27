<?php

namespace Pequiven\SEIPBundle\Repository\Sip\Centro;

use Pequiven\SEIPBundle\Entity\Sip\Center\Inventory;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio de Inevntarios
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
class InventoryRepository extends EntityRepository {    
   	
   	/**
     * Crea un paginador para el inventario
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function createPaginatorByInventory(array $criteria = null, array $orderBy = null) {
        //$criteria['for_view_inv'] = true;
        return $this->createPaginator($criteria, $orderBy);
    }

    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);

        /*if (($nombreCentro = $criteria->remove('centro'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('ctro.description', "'%" . $nombreCentro . "%'"));
        }*/

        if (($codigoCentro = $criteria->remove('codigoCentro'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('inv.codigoCentro', "'%" . $codigoCentro . "%'"));
        }
        
        if (($fecha = $criteria->remove('fecha'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('inv.fecha', "'%" . $fecha . "%'"));
        }

        if (($observations = $criteria->remove('observations'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('inv.observations', "'%" . $observations . "%'"));
        }

        if (($material = $criteria->remove('material.description'))) {                
                $queryBuilder  
                    ->innerJoin('inv.material', 'mat')                    
                    ->andWhere($queryBuilder->expr()->like('mat.description', "'%" . $material . "%'"))                    
                ;
        }

        if (($cantidad = $criteria->remove('cantidad'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('inv.cantidad', "'%" . $cantidad . "%'"));
        }

        if (($centro = $criteria->remove('centro'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('inv.centro', "'%" . $centro . "%'"));
        }

        if (($parroquia = $criteria->remove('parroquia'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('inv.parroquia', "'%" . $parroquia . "%'"));
        }

        if (($municipio = $criteria->remove('municipio'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('inv.municipio', "'%" . $municipio . "%'"));
        }

        if (($estado = $criteria->remove('estado'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('inv.estado', "'%" . $estado . "%'"));
        }
        
        parent::applyCriteria($queryBuilder, $criteria->toArray());
    }

    protected function getAlias() {
        return "inv";
    }  
}