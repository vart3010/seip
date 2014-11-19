<?php

namespace Pequiven\IndicatorBundle\Entity\Indicator;

use Doctrine\ORM\Mapping as ORM;

/**
 * Detalles del indicador
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @ORM\Table()
 * @ORM\Entity()
 */
class IndicatorDetails
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
     * Ultimo valor del indicador
     * 
     * @var integer
     * @ORM\Column(name="lastValue",type="integer")
     */
    private $previusValue = 0;
    
    /**
     * Persona que notifico la ultima vez valor al indicador
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     */
    private $lastNotificationBy;
    
    /**
     * Fecha de ultima notificacion
     * 
     * @var \DateTime
     * @ORM\Column(name="lastNotificationAt", type="datetime",nullable=true)
     */
    private $lastNotificationAt;
    
    /**
     * Ultimos parametros de las variables de la formula
     * 
     * @var array
     * @ORM\Column(name="lastNotificationParameters",type="array")
     */
    private $lastNotificationParameters;

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
     * Set previusValue
     *
     * @param integer $previusValue
     * @return IndicatorDetails
     */
    public function setPreviusValue($previusValue)
    {
        $this->previusValue = $previusValue;

        return $this;
    }

    /**
     * Get previusValue
     *
     * @return integer 
     */
    public function getPreviusValue()
    {
        return $this->previusValue;
    }

    /**
     * Set lastNotificationAt
     *
     * @param \DateTime $lastNotificationAt
     * @return IndicatorDetails
     */
    public function setLastNotificationAt($lastNotificationAt)
    {
        $this->lastNotificationAt = $lastNotificationAt;

        return $this;
    }

    /**
     * Get lastNotificationAt
     *
     * @return \DateTime 
     */
    public function getLastNotificationAt()
    {
        return $this->lastNotificationAt;
    }

    /**
     * Set lastNotificationBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $lastNotificationBy
     * @return IndicatorDetails
     */
    public function setLastNotificationBy(\Pequiven\SEIPBundle\Entity\User $lastNotificationBy = null)
    {
        $this->lastNotificationBy = $lastNotificationBy;

        return $this;
    }

    /**
     * Get lastNotificationBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getLastNotificationBy()
    {
        return $this->lastNotificationBy;
    }

    /**
     * Set lastNotificationParameters
     *
     * @param array $lastNotificationParameters
     * @return IndicatorDetails
     */
    public function setLastNotificationParameters($lastNotificationParameters)
    {
        $this->lastNotificationParameters = $lastNotificationParameters;

        return $this;
    }

    /**
     * Get lastNotificationParameters
     *
     * @return array 
     */
    public function getLastNotificationParameters()
    {
        return $this->lastNotificationParameters;
    }
}
