<?php

namespace Pequiven\SEIPBundle\Model\Sip\Center;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo Reporte de Centro
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
abstract class CenterReport {

    /**
     * Categorias
     *
     */
    const MIEMBRO_MESA = 1;
    const OPERADOR_MAQUINA = 2;
    const FALTA_MAQUINA = 3;
    const MAQUINA_DAÑADA = 4; 
    const OTROS = 5; 
    
    static function getReportCenter() {
        static $LabelsReport = [
            self::MIEMBRO_MESA => 'Miembro de Mesa',
            self::OPERADOR_MAQUINA => 'Operador de Maquina',
            self::FALTA_MAQUINA => 'Falta Maquina',
            self::MAQUINA_DAÑADA => 'Maquina Dañada',        
            self::OTROS => 'Otros...'
        ];
        return $LabelsReport;
    }

}
