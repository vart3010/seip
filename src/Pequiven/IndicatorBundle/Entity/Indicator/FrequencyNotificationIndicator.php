<?php

namespace Pequiven\IndicatorBundle\Entity\Indicator;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Frecuencia de notificacion del indicador
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @ORM\Table(name="seip_c_indicator_frequency_notification")
 * @ORM\Entity()
 */
class FrequencyNotificationIndicator
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
     * Dias de frecuencia, contando de cero a partir del inicio del periodo y mes.
     * @ORM\Column(name="days", type="integer")
     */
    private $days;
    
    /**
     * Habilitado o no.
     * @var boolean
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = true;

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
}
