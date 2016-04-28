<?php

namespace Pequiven\SEIPBundle\Entity\Sip\Center;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Report de Centro
 * @author Maximo Sojo <maxsojo13@gmail.com>
 * @ORM\Table(name="sip_centro_report")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class ReportCentro{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="codigoCentro", type="integer")
     */
    private $codigoCentro;

    /**
     * @var integer
     *
     * @ORM\Column(name="mesa", type="integer")
     */
    private $mesa;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * Observaciones
     * 
     * @var \Pequiven\SEIPBundle\Entity\Sip\Center\ReportCentroNotifications
     * @ORM\OneToMany(targetEntity="Pequiven\SEIPBundle\Entity\Sip\Center\ReportCentroNotifications",mappedBy="report",cascade={"persist","remove"})
     */
    protected $observations;

    /**
     * Constructor
     */
    public function __construct() {

        $this->observations = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    
    function getId() {
        return $this->id;
    }   

    function setMesa($mesa) {
        $this->mesa = $mesa;
    }

    function getMesa() {
        return $this->mesa;
    }

    function setCodigoCentro($codigoCentro) {
        $this->codigoCentro = $codigoCentro;
    }
    
    function getCodigoCentro() {
        return $this->codigoCentro;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return material
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return PrePlanning
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
     * Add observations
     *
     * @param \Pequiven\SEIPBundle\Entity\Sip\Center\ReportCentroNotifications $observations
     * @return Indicator
     */
    public function addObservations(\Pequiven\SEIPBundle\Entity\Sip\Center\ReportCentroNotifications $observations) {

        $this->observations->add($observations);

        return $this;
    }

    /**
     * Remove observations
     *
     * @param \Pequiven\SEIPBundle\Entity\Sip\Center\ReportCentroNotifications $observations
     */
    public function removeObservations(\Pequiven\SEIPBundle\Entity\Sip\Center\ReportCentroNotifications $observations) {
        $this->observations->removeElement($observations);
    }

    /**
     * Get observations
     *
     * @return \Pequiven\SEIPBundle\Entity\Sip\Center\ReportCentroNotifications     */
    public function getObservations() {
        return $this->observations;
    }   
}
