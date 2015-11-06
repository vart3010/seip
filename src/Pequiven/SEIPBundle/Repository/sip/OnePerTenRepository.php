<?php

namespace Pequiven\SEIPBundle\Repository\Sip;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Repositorio de 1x10
 * @author Victor Tortolero vart10.30@gmail.com
 */
class OnePerTenRepository {

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

    protected function getAlias() {
        return 'opt';
    }

}
