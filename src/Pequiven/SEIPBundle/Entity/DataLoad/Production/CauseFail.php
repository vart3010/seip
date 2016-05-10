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
 * Causa de PNR
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_product_unrealized_production_day_cause_fail")
 * @ORM\Entity()
 */
class CauseFail 
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
     * Causa o falla
     * @var \Pequiven\SEIPBundle\Entity\CEI\Fail
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Fail")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fail;
    
    /**
     * Cantidad
     * @var float
     * @ORM\Column(name="mount",type="float")
     */
    private $mount = 0.0;

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
     * Set mount
     *
     * @param float $mount
     * @return CauseFail
     */
    public function setMount($mount)
    {
        $this->mount = $mount;

        return $this;
    }

    /**
     * Get mount
     *
     * @return float 
     */
    public function getMount()
    {
        return $this->mount;
    }

    /**
     * Set fail
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Fail $fail
     * @return CauseFail
     */
    public function setFail(\Pequiven\SEIPBundle\Entity\CEI\Fail $fail)
    {
        $this->fail = $fail;

        return $this;
    }

    /**
     * Get fail
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Fail 
     */
    public function getFail()
    {
        return $this->fail;
    }
    
    public function __toString() {
        return $this->id;
    }
}
