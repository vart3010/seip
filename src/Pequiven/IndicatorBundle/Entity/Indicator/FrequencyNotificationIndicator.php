<?php

namespace Pequiven\IndicatorBundle\Entity\Indicator;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Frecuencia de notificacion del indicador
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @ORM\Table(name="seip_c_indicator_frequency_notification")
 * @ORM\Entity(repositoryClass="Pequiven\IndicatorBundle\Entity\Indicator\FrequencyNotificationIndicatorRepository")
 * @ORM\Entity()
 */
class FrequencyNotificationIndicator implements \Pequiven\SEIPBundle\Entity\PeriodItemInterface
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
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
    
    /**
     * Descripcion
     * 
     * @var string
     * @ORM\Column(name="description", type="string", length=200,nullable=false)
     */
    private $description;
    
    /**
     * Texto que se mostrara en la abreviacion
     * 
     * @var string
     * @ORM\Column(name="textAbbr", type="string", length=20,nullable=false)
     */
    private $textAbbr;

    /**
     * Dias de frecuencia, contando de cero a partir del inicio del periodo y mes.
     * @ORM\Column(name="days", type="integer")
     */
    private $days;

    /**
     * Cantidad de resultados de la frecuencia
     * @ORM\Column(name="numberResultsFrequency", type="integer")
     */
    private $numberResultsFrequency = 0;
    
    /**
     * Habilitado o no.
     * @var boolean
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = true;
    
    /**
     * Periodo.
     * 
     * @var \Pequiven\SEIPBundle\Entity\Period
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period")
     * @ORM\JoinColumn(nullable=false)
     */
    private $period;
    
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return FrequencyNotificationIndicator
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return FrequencyNotificationIndicator
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return FrequencyNotificationIndicator
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set days
     *
     * @param integer $days
     * @return FrequencyNotificationIndicator
     */
    public function setDays($days)
    {
        $this->days = $days;

        return $this;
    }

    /**
     * Get days
     *
     * @return integer 
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return FrequencyNotificationIndicator
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
    
    public function __toString() {
        return $this->getDescription()?:'-';
    }

    /**
     * Set textAbbr
     *
     * @param string $textAbbr
     * @return FrequencyNotificationIndicator
     */
    public function setTextAbbr($textAbbr)
    {
        $this->textAbbr = $textAbbr;

        return $this;
    }

    /**
     * Get textAbbr
     *
     * @return string 
     */
    public function getTextAbbr()
    {
        return $this->textAbbr;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set numberResultsFrequency
     *
     * @param integer $numberResultsFrequency
     * @return FrequencyNotificationIndicator
     */
    public function setNumberResultsFrequency($numberResultsFrequency)
    {
        $this->numberResultsFrequency = $numberResultsFrequency;

        return $this;
    }

    /**
     * Get numberResultsFrequency
     *
     * @return integer 
     */
    public function getNumberResultsFrequency()
    {
        return $this->numberResultsFrequency;
    }
    
    function getPeriod() 
    {
        return $this->period;
    }

    function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) 
    {
        $this->period = $period;
        
        return $this;
    }
    
    public function __clone() {
        if($this->id > 0){
            $this->id = null;
            $this->createdAt = null;
            $this->updatedAt = null;
            $this->period = null;
        }
    }
}
