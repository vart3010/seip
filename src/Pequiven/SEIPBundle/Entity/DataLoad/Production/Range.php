<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad\Production;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\DataLoad\Production\Range as BaseModel;

/**
 * Rango de distribucion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_product_report_range")
 * @ORM\Entity()
 */
class Range extends BaseModel
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
     * Planificacion de producto
     * @var ProductPlanning
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productPlanning;

    /**
     * Fecha de inicio
     * @var \DateTime
     * @ORM\Column(name="date_from",type="datetime")
     */
    private $dateFrom;
    
    /**
     * Fecha fin
     * @var \DateTime
     * @ORM\Column(name="date_end",type="datetime")
     */
    private $dateEnd;
    
    /**
     * Tipo de rango
     * @var integer
     * @ORM\Column(name="type",type="integer")
     */
    private $type;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    function getType() {
        return $this->type;
    }
    
    /**
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     * @return Range
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * Get dateFrom
     *
     * @return \DateTime 
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return Range
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Range
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set productPlanning
     *
     * @param \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning $productPlanning
     * @return Range
     */
    public function setProductPlanning(\Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning $productPlanning)
    {
        $this->productPlanning = $productPlanning;

        return $this;
    }

    /**
     * Get productPlanning
     *
     * @return \Pequiven\SEIPBundle\Entity\DataLoad\Production\ProductPlanning 
     */
    public function getProductPlanning()
    {
        return $this->productPlanning;
    }
}
