<?php

namespace Pequiven\SEIPBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Configuracion del usuario
 *
 * @author inhack20
 * @ORM\Entity()
 * @ORM\Table(name="seip_user_configuration")
 */
class Configuration 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * Localizaciones del usuario
     * 
     * @var \Pequiven\SEIPBundle\Entity\User\Localization
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\User\Localization",mappedBy="configuration")
     */
    private $localizations;
    
    /**
     * Pre-Planificacion
     * 
     * @var \Pequiven\SEIPBundle\Entity\User\PrePlanningConfiguration
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\User\PrePlanningConfiguration",mappedBy="configuration")
     */
    private $prePlanningConfiguration;
    
    /**
     * Usuario asociado a la configuracion
     * 
     * @var \Pequiven\SEIPBundle\Entity\User
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\User",mappedBy="configuration",cascade={"persist","remove"})
     */
    private $user;
    
    /**
     * Date created
     * 
     * @var type 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $createdAt;

    public function __construct() {
        $this->localizations = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Add localizations
     *
     * @param \Pequiven\SEIPBundle\Entity\User\Localization $localizations
     * @return Configuration
     */
    public function addLocalization(\Pequiven\SEIPBundle\Entity\User\Localization $localizations)
    {
        $this->localizations->add($localizations);

        return $this;
    }

    /**
     * Remove localizations
     *
     * @param \Pequiven\SEIPBundle\Entity\User\Localization $localizations
     */
    public function removeLocalization(\Pequiven\SEIPBundle\Entity\User\Localization $localizations)
    {
        $this->localizations->removeElement($localizations);
    }

    /**
     * Get localizations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLocalizations()
    {
        return $this->localizations;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Configuration
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
     * Set user
     *
     * @param \Pequiven\SEIPBundle\Entity\User $user
     * @return Configuration
     */
    public function setUser(\Pequiven\SEIPBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    
    public function __toString() {
        return $this->id.'';
    }

    /**
     * Set prePlanningConfiguration
     *
     * @param \Pequiven\SEIPBundle\Entity\User\PrePlanningConfiguration $prePlanningConfiguration
     * @return Configuration
     */
    public function setPrePlanningConfiguration(\Pequiven\SEIPBundle\Entity\User\PrePlanningConfiguration $prePlanningConfiguration = null)
    {
        $this->prePlanningConfiguration = $prePlanningConfiguration;

        return $this;
    }

    /**
     * Get prePlanningConfiguration
     *
     * @return \Pequiven\SEIPBundle\Entity\User\PrePlanningConfiguration 
     */
    public function getPrePlanningConfiguration()
    {
        return $this->prePlanningConfiguration;
    }
}
