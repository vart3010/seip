<?php

namespace Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram;

use Doctrine\ORM\Mapping as ORM;

/**
 * Detalles del programa de gestion
 *
 * @author Carlos Mendoza<inhack20@gmail.com>
 * @ORM\Table(name="ArrangementProgramDetails")
 * @ORM\Entity()
 */
class Details 
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
     * Revisado por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     */
    private $reviewedBy;

    /**
     * Fecha de revision
     * @var \DateTime
     *
     * @ORM\Column(name="revisionDate", type="datetime",nullable=true)
     */
    private $revisionDate;

    /**
     * Aprobado por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     */
    private $approvedBy;

    /**
     * Fecha de aprobacion
     * @var \DateTime
     *
     * @ORM\Column(name="approvalDate", type="datetime",nullable=true)
     */
    private $approvalDate;

    /**
     * Enviado a revision por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     */
    private $sendToReviewBy;

    /**
     * Fecha que se envio a revision
     * @var \DateTime
     *
     * @ORM\Column(name="sendToReviewDate", type="datetime",nullable=true)
     */
    private $sendToReviewDate;
    
    /**
     * Rechazado por
     * @var \Pequiven\SEIPBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User")
     */
    private $rejectedBy;

    /**
     * Fecha que se rechazo
     * @var \DateTime
     *
     * @ORM\Column(name="rejectedDate", type="datetime",nullable=true)
     */
    private $rejectedDate;
    
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
     * Set revisionDate
     *
     * @param \DateTime $revisionDate
     * @return ArrangementProgram
     */
    public function setRevisionDate($revisionDate)
    {
        $this->revisionDate = $revisionDate;

        return $this;
    }

    /**
     * Get revisionDate
     *
     * @return \DateTime 
     */
    public function getRevisionDate()
    {
        return $this->revisionDate;
    }

    /**
     * Set approvalDate
     *
     * @param \DateTime $approvalDate
     * @return ArrangementProgram
     */
    public function setApprovalDate($approvalDate)
    {
        $this->approvalDate = $approvalDate;

        return $this;
    }

    /**
     * Get approvalDate
     *
     * @return \DateTime 
     */
    public function getApprovalDate()
    {
        return $this->approvalDate;
    }
    
    /**
     * Set reviewedBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $reviewedBy
     * @return ArrangementProgram
     */
    public function setReviewedBy(\Pequiven\SEIPBundle\Entity\User $reviewedBy = null)
    {
        $this->reviewedBy = $reviewedBy;

        return $this;
    }

    /**
     * Get reviewedBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getReviewedBy()
    {
        return $this->reviewedBy;
    }

    /**
     * Set approvedBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $approvedBy
     * @return ArrangementProgram
     */
    public function setApprovedBy(\Pequiven\SEIPBundle\Entity\User $approvedBy = null)
    {
        $this->approvedBy = $approvedBy;

        return $this;
    }

    /**
     * Get approvedBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getApprovedBy()
    {
        return $this->approvedBy;
    }
    

    /**
     * Set sendToReviewDate
     *
     * @param \DateTime $sendToReviewDate
     * @return Details
     */
    public function setSendToReviewDate($sendToReviewDate)
    {
        $this->sendToReviewDate = $sendToReviewDate;

        return $this;
    }

    /**
     * Get sendToReviewDate
     *
     * @return \DateTime 
     */
    public function getSendToReviewDate()
    {
        return $this->sendToReviewDate;
    }

    /**
     * Set sendToReviewBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $sendToReviewBy
     * @return Details
     */
    public function setSendToReviewBy(\Pequiven\SEIPBundle\Entity\User $sendToReviewBy = null)
    {
        $this->sendToReviewBy = $sendToReviewBy;

        return $this;
    }

    /**
     * Get sendToReviewBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getSendToReviewBy()
    {
        return $this->sendToReviewBy;
    }

    /**
     * Set rejectedDate
     *
     * @param \DateTime $rejectedDate
     * @return Details
     */
    public function setRejectedDate($rejectedDate)
    {
        $this->rejectedDate = $rejectedDate;

        return $this;
    }

    /**
     * Get rejectedDate
     *
     * @return \DateTime 
     */
    public function getRejectedDate()
    {
        return $this->rejectedDate;
    }

    /**
     * Set rejectedBy
     *
     * @param \Pequiven\SEIPBundle\Entity\User $rejectedBy
     * @return Details
     */
    public function setRejectedBy(\Pequiven\SEIPBundle\Entity\User $rejectedBy = null)
    {
        $this->rejectedBy = $rejectedBy;

        return $this;
    }

    /**
     * Get rejectedBy
     *
     * @return \Pequiven\SEIPBundle\Entity\User 
     */
    public function getRejectedBy()
    {
        return $this->rejectedBy;
    }
}
