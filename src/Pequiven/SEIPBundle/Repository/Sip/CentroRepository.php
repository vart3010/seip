<?php

namespace Pequiven\SEIPBundle\Repository\Sip;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository as EntityRepository;

/**
 * Description of CentroRepository
 *
 * @author Victor Tortolero vart10.30@gmail.com
 */
class CentroRepository extends EntityRepository {

    public function getCentro($codCentro) {
        $query = $this->getQueryBuilder();

        $query->select("cen.description")
                ->andWhere('cen.codigoCentro = :codCentro')
                ->setParameter('codCentro', $codCentro);

        $q = $query->getQuery();

        return $q->getResult();
    }

    protected function getAlias() {
        return 'cen';
    }

}
