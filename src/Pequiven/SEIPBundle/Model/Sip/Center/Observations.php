<?php

namespace Pequiven\SEIPBundle\Model\Sip\Center;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo Categorias de las Observaciones
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
abstract class Observations
{	
    const PROPAGANDA = 1;

    const TRANSPORTE = 2;
    
    const HIDRATACIÓN = 3;

	const LOGISTICA = 4;

    const ASISTENCIA = 5;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="categorias", type="integer")
     */
    protected $categorias;
    
    /**
     * 
     * 
     * @param integer
     * @return 
     */
    function setCategorias($categorias) {
        $this->categorias = $categorias;

        return $this;
    }

    /**
     * 
     * 
     * @param integer
     * @return 
     */
    function getCategorias() {
       
        return $this->categorias;
    }

    static function getCategoriasObservations()
    {
    	static $levelProcessArray = [
            self::PROPAGANDA => 'Propaganda',
            self::TRANSPORTE => 'Transporte',
	        self::HIDRATACIÓN => 'Hidratación',
	        self::LOGISTICA => 'Logistica',
	        self::ASISTENCIA => 'Asistencia',	        
	    ];
	    return $levelProcessArray;
    }   
    
}
