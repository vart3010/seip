<?php

namespace Pequiven\SEIPBundle\Repository\Politic;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de categorias de archivos
 * @author Victor Tortolero vart10.30@gmail.com
 */
class CategoryFileRepository extends SeipEntityRepository {

    function findCategoryFile() {
        $qb = $this->getQueryBuilder();
        return $qb->getQuery()->getResult();
    }

    protected function getAlias() {
        return 'cf';
    }

}
