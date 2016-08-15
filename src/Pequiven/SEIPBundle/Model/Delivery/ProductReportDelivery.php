<?php

namespace Pequiven\SEIPBundle\Model\Delivery;

use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Modelo de productos despacho
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
abstract class ProductReportDelivery extends BaseModel  {
    /*
     * A GRANEL
     */
     const TYPE_BULK = 0;
     
     /*
      * ENSACADO
      */
    const TYPE_BAGGED = 1;
    
    static function getTypesProducts() {
        static $typesProducts = array(
            self::TYPE_BULK => 'delivery_product.type.bulk',
            self::TYPE_BAGGED => 'delivery_product.type.bagged'
        );
        return $typesProducts;
    }
    
}
