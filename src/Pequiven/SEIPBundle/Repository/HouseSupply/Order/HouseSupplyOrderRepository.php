<?php

namespace Pequiven\SEIPBundle\Repository\HouseSupply\Order;

use Pequiven\SEIPBundle\Entity\Period;
use Pequiven\SEIPBundle\Entity\User;
use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio de Ordenes HouseSupply
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class HouseSupplyOrderRepository extends EntityRepository {

    function FindNextOrderNro($type) {

        $qb = $this->getQueryBuilder();
        $qb
                ->select('MAX(HSOrder.nroOrder) as nro')
        // ->andWhere('HSOrder.type= :type')
        // ->setParameter('type', $type)
        ;

        return $qb->getQuery()->getResult();
    }

    function DeleteItemOrder($id) {
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql = 'DELETE FROM seip_gsh_order_items WHERE id="' . $id . '"';

        $stmt = $db->prepare($sql);
        $stmt->execute();
    }

    function TotalOrder($type = null, $id = null, $wsc = null) {
        $em = $this->getEntityManager();
        $db = $em->getConnection();

        $sql1 = 'SELECT '
                . ' prod.description AS product,'
                . ' SUM(item.cant) AS cant,'
                . ' SUM(item.totalLine) totalLine,'
                . ' SUM(item.totalLinetaxes) AS TotalLinetaxes'
                . ' FROM'
                . ' seip_gsh_order_items AS item'
                . ' INNER JOIN'
                . ' seip_gsh_product AS prod ON (item.product_id = prod.id)'
                . ' WHERE'
                . ' type = ' . $type;

        if ($wsc != null) {
            $sql4 = ' AND workStudyCircle_id = ' . $wsc;
        } else {
            $sql4 = '';
        }


        if ($id != null) {
            $sql2 = ' AND order_id=' . $id;
        } else {
            $sql2 = '';
        }

        $sql3 = ' GROUP BY item.workStudyCircle_id, item.product_id';

        $sql = $sql1 . $sql2 . $sql4 . $sql3;

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    function getAlias() {
        return 'HSOrder';
    }

}
