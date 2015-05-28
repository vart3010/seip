<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad\Production;

use Doctrine\ORM\Mapping as ORM;

/**
 * Detalles de la produccion no realizada en un dia
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_product_unrealized_production_day")
 * @ORM\Entity()
 */
class UnrealizedProductionDay 
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
     * Causas interna de falla
     * @var CauseFail
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\CauseFail")
     * @ORM\JoinTable(name="unrealizedproductionday_internalcauses")
     */
    private $internalCauses;
    
    /**
     * Causas externa de falla
     * @var CauseFail
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\CauseFail")
     * @ORM\JoinTable(name="unrealizedproductionday_externalcauses")
     */
    private $externalCauses;
    
    /**
     * Causa interna por materia prima
     * @var UnrealizedProductionDay\RawMaterialRequired
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay\RawMaterialRequired",cascade={"persist","remove"})
     * @ORM\JoinTable(name="unrealizedproductionday_internalcauses_mp")
     */
    private $internalCauseMp;
    
    /**
     * Causa interna por materia prima
     * @var UnrealizedProductionDay\RawMaterialRequired
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay\RawMaterialRequired",cascade={"persist","remove"})
     * @ORM\JoinTable(name="unrealizedproductionday_externalcauses_mp")
     */
    private $externalCauseMp;
     
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->internalCauses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->externalCauses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->internalCauseMp = new \Doctrine\Common\Collections\ArrayCollection();
        $this->externalCauseMp = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add internalCauses
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\CauseFail $internalCauses
     * @return UnrealizedProductionDay
     */
    public function addInternalCause(\Pequiven\SEIPBundle\Entity\DataLoad\Production\CauseFail $internalCauses)
    {
        $this->internalCauses->add($internalCauses);

        return $this;
    }

    /**
     * Remove internalCauses
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\CauseFail $internalCauses
     */
    public function removeInternalCause(\Pequiven\SEIPBundle\Entity\DataLoad\Production\CauseFail $internalCauses)
    {
        $this->internalCauses->removeElement($internalCauses);
    }

    /**
     * Get internalCauses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInternalCauses()
    {
        return $this->internalCauses;
    }

    /**
     * Add externalCauses
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\CauseFail $externalCauses
     * @return UnrealizedProductionDay
     */
    public function addExternalCause(\Pequiven\SEIPBundle\Entity\DataLoad\Production\CauseFail $externalCauses)
    {
        $this->externalCauses->add($externalCauses);

        return $this;
    }

    /**
     * Remove externalCauses
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\CauseFail $externalCauses
     */
    public function removeExternalCause(\Pequiven\SEIPBundle\Entity\DataLoad\Production\CauseFail $externalCauses)
    {
        $this->externalCauses->removeElement($externalCauses);
    }

    /**
     * Get externalCauses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExternalCauses()
    {
        return $this->externalCauses;
    }

    /**
     * Add internalCauseMp
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay\RawMaterialRequired $internalCauseMp
     * @return UnrealizedProductionDay
     */
    public function addInternalCauseMp(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay\RawMaterialRequired $internalCauseMp)
    {
        $this->internalCauseMp->add($internalCauseMp);

        return $this;
    }

    /**
     * Remove internalCauseMp
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay\RawMaterialRequired $internalCauseMp
     */
    public function removeInternalCauseMp(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay\RawMaterialRequired $internalCauseMp)
    {
        $this->internalCauseMp->removeElement($internalCauseMp);
    }

    /**
     * Get internalCauseMp
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInternalCauseMp()
    {
        return $this->internalCauseMp;
    }

    /**
     * Add externalCauseMp
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay\RawMaterialRequired $externalCauseMp
     * @return UnrealizedProductionDay
     */
    public function addExternalCauseMp(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay\RawMaterialRequired $externalCauseMp)
    {
        $this->externalCauseMp->add($externalCauseMp);

        return $this;
    }

    /**
     * Remove externalCauseMp
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay\RawMaterialRequired $externalCauseMp
     */
    public function removeExternalCauseMp(\Pequiven\SEIPBundle\Entity\DataLoad\Production\UnrealizedProductionDay\RawMaterialRequired $externalCauseMp)
    {
        $this->externalCauseMp->removeElement($externalCauseMp);
    }

    /**
     * Get externalCauseMp
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExternalCauseMp()
    {
        return $this->externalCauseMp;
    }
}
