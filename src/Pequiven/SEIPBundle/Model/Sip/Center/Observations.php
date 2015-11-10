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
    /**
     * Categorias
     *
     */
    const PROPAGANDA  = 1;

    const TRANSPORTE  = 2;
    
    const HIDRATACIÓN = 3;

	const LOGISTICA   = 4;

    const ASISTENCIA  = 5;

    /**
     * Status
     *
     */
    const RECIBIDO  = 2;
    const APROBADO  = 3;
    const RECHAZADO = 4;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="categorias", type="integer")
     */
    protected $categorias;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    protected $status;
    
    /**
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
     * @param integer
     * @return 
     */
    function getCategorias() {       
        return $this->categorias;
    }

    /**
     * 
     * @param integer
     * @return 
     */
    function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * 
     * @param integer
     * @return 
     */
    function getStatus() {       
        return $this->status;
    }

    static function getCategoriasObservations()
    {
    	static $levelProcessArray = [
            self::PROPAGANDA   => 'Propaganda',
            self::TRANSPORTE   => 'Transporte',
	        self::HIDRATACIÓN  => 'Hidratación',
	        self::LOGISTICA    => 'Logistica',
	        self::ASISTENCIA   => 'Asistencia',	        
	    ];
	    return $levelProcessArray;
    }   

    static function getStatusObservations()
    {
        static $status = [
            self::RECIBIDO  => 'Recibido',
            self::APROBADO  => 'Aprobado',
            self::RECHAZADO => 'Rechazado',            
        ];
        return $status;
    }   
    
}
