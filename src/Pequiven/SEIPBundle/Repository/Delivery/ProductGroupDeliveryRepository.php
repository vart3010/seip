<?php

namespace Pequiven\SEIPBundle\Repository\Delivery;

use Pequiven\SEIPBundle\Doctrine\ORM\SeipEntityRepository;

/**
 * Repositorio de grupos de productos de despacho
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
class ProductGroupDeliveryRepository extends SeipEntityRepository {

    protected function getAlias() {
        return 'pgr';
    }

}
