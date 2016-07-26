<?php

namespace Pequiven\SEIPBundle\Model\HouseSupply\Order;

abstract class HouseSupplyOrder {

    /**
     * MAESTROS DE ESTATUS
     */
    const REGISTRADA = 1;
    const DEVUELTA = 2;
    const ESPERA = 3;
    const PAGADA = 4;    
    const ENTREGADA = 5;    
        
    /**
     * 
     * @staticvar array $array
     * @return string
     */
    static function getStatus() {
        static $array = [
            self::REGISTRADA => 'Registrada',
            self::DEVUELTA => 'Devuelta/Anulada',
            self::ESPERA => 'En Proceso',
            self::PAGADA => 'Pagada/Confirmada',
            self::ENTREGADA => 'Despachada'
        ];
        return $array;
    }

}
