<?php

namespace Pequiven\SEIPBundle\Model\HouseSupply;

abstract class HouseSupplyPayments {

    /**
     * MAESTROS DE PAGOS
     */
    const TRANSFERENCIA = 1;
    const DEPOSITO = 2;
    const TARJETA_DEBITO = 3;
    const TARJETA_CREDITO = 4;        
        
    /**
     * 
     * @staticvar array $array
     * @return string
     */
    static function getPaymentsTypes() {
        static $array = [
            self::TRANSFERENCIA => 'Transferencia',
            self::DEPOSITO => 'Depósito',
            self::TARJETA_DEBITO => 'Tarjeta de Débito',
            self::TARJETA_CREDITO => 'Tarjeta de Crédito',            
        ];
        return $array;
    }

}
