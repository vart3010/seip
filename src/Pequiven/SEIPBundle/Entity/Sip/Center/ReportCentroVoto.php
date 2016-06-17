<?php

namespace Pequiven\SEIPBundle\Entity\Sip\Center;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Report de Centro
 * @author Maximo Sojo <maxsojo13@gmail.com>
 * @ORM\Table(name="sip_centro_report_voto")
 * @ORM\Entity()
 */
class ReportCentroVoto{

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
     * @ORM\Column(name="votos", type="integer")
     */
    private $votos;

    /**
     * Report
     * @var \Pequiven\SEIPBundle\Entity\Sip\Centro
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\Sip\Centro", inversedBy="report")
     * @ORM\JoinColumn(name="centro_id", referencedColumnName="id")
     */
    protected $centro;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * Constructor
     */
    public function __construct() {

    }
    
    
    function getId() {
        return $this->id;
    }  

    function setVotos($votos) {
        $this->votos = $votos;
    }
    
    function getVotos() {
        return $this->votos;
    }

    /**
     * Set centro
     *
     * @param \Pequiven\SEIPBundle\Entity\Sip\Centro $centro
     * @return Indicator
     */
    public function setCentro(\Pequiven\SEIPBundle\Entity\Sip\Centro $centro) {
        
        $this->centro = $centro;

        return $this;
    }

    /**
     * Get centro
     *
     * @return \Pequiven\SEIPBundle\Entity\Sip\Centro
     */
    public function getCentro() {
        return $this->centro;
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

}
