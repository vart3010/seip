<?php

namespace Pequiven\SEIPBundle\Entity\Sip\Center;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Report de Centro
 * @author Maximo Sojo <maxsojo13@gmail.com>
 * @ORM\Table(name="sip_centro_report_observations")
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class ReportCentroNotifications{

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
     * @ORM\Column(name="day", type="integer")
     */
    private $day;

    /**
     * @var time
     *
     * @ORM\Column(name="hora", type="time")
     */
    private $hora;

    /**
     * @var integer
     *
     * @ORM\Column(name="notification", type="integer", nullable=true)
     */
    private $notification;

    /**
     * @var text
     *
     * @ORM\Column(name="observations", type="text", nullable=true)
     */
    private $observations;

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
     * Report
     * @var \Pequiven\SEIPBundle\Entity\Sip\Center\ReportCentro
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Sip\Center\ReportCentro", inversedBy="observations")
     * @ORM\JoinColumn(name="report_id", referencedColumnName="id")
     */
    protected $report;    

    /**
     * Constructor
     */
    public function __construct()
    {
        
    }
    
    function getId() {
        return $this->id;
    }   

    function setDay($day) {
        $this->day = $day;
    }
    
    function getDay() {
        return $this->day;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }
    
    function getHora() {
        return $this->hora;
    }

    function setNotification($notification) {
        $this->notification = $notification;
    }
    
    function getNotification() {
        return $this->notification;
    }

    function setObservations($observations) {
        $this->observations = $observations;
    }
    
    function getObservations() {
        return $this->observations;
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
     * Set report
     *
     * @param \Pequiven\SEIPBundle\Entity\Sip\Center\ReportCentro $report
     * @return Indicator
     */
    public function setReport(\Pequiven\SEIPBundle\Entity\Sip\Center\ReportCentro $report) {
        
        $this->report = $report;

        return $this;
    }

    /**
     * Get report
     *
     * @return \Pequiven\SEIPBundle\Entity\Sip\Center\ReportCentro
     */
    public function getReport() {
        return $this->report;
    }

}
