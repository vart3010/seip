<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\CEI;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Dia de parada de produccion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_cei_day_stop")
 * @ORM\Entity()
 */
class DayStop extends BaseModel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Numero del dia en el mes
     * @var integer
     * @ORM\Column(name="nro_day",type="integer")
     */
    private $nroDay;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nroDay
     *
     * @param integer $nroDay
     * @return DayStop
     */
    public function setNroDay($nroDay)
    {
        $this->nroDay = $nroDay;

        return $this;
    }

    /**
     * Get nroDay
     *
     * @return integer 
     */
    public function getNroDay()
    {
        return $this->nroDay;
    }

    public function __toString() 
    {
        $_toString = "-";
        if($this->getNroDay() > 0){
            $_toString = $this->getNroDay()."";
        }
        return $_toString;
    }
}
