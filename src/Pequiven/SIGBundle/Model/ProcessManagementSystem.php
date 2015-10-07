<?php

namespace Pequiven\SIGBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo Procesos de los Sistema de Gestión
 *
 * @author maximo
 */
abstract class ProcessManagementSystem
{	
	/**
	 *	Nivel Control
	 *
	 */
    const LEVEL_CONTROL = 1;

    /**
	 *	Nivel Medulares
	 *
	 */
    const LEVEL_MEDULARES = 2;

    /**
	 *	Nivel Apoyo
	 *
	 */
    const LEVEL_APOYO = 3;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="levelProcess", type="integer")
     */
    protected $levelProcess;
    
    /**
     * 
     * 
     * @param integer
     * @return 
     */
    function setLevelProcess($levelProcess) {
        $this->levelProcess = $levelProcess;

        return $this;
    }

    /**
     * 
     * 
     * @param integer
     * @return 
     */
    function getLevelProcess() {
       
        return $this->levelProcess;
    }

    static function getlevelProcessArray()
    {
    	static $levelProcessArray = [
	        self::LEVEL_CONTROL => 'Procesos de Dirección y Control',
	        self::LEVEL_MEDULARES => 'Procesos Medulares',
	        self::LEVEL_APOYO => 'Procesos de Apoyo',	        
	    ];
	    return $levelProcessArray;
    }   
    
}
