<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\DataLoad;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\DataLoad\ReportTemplate as BaseModel;

/**
 * Reporte de datos en el sistema
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_report_template")
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\DataLoad\ReportTemplateRepository")
 */
class ReportTemplate extends BaseModel
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
     * Sede
     * @var \Pequiven\SEIPBundle\Entity\CEI\Location
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Location")
     */
    private $location;

    /**
     * Descripcion de la plantilla
     * @var string
     * @ORM\Column(name="description")
     */
    private $description;

    /**
     * Tipo de reporte (REPORT_TEMPLATE_TYPE_*)
     * @var integer
     * @ORM\Column(name="type_report",type="integer")
     */
    private $typeReport;
    
    /**
     * Product
     * @var \Pequiven\SEIPBundle\Entity\CEI\Product
     * @ORM\ManyToMany(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Product")
     * @ORM\JoinTable(name="reporttemplate_product")
     */
    private $products;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set typeReport
     *
     * @param integer $typeReport
     * @return ReportTemplate
     */
    public function setTypeReport($typeReport)
    {
        $this->typeReport = $typeReport;

        return $this;
    }

    /**
     * Get typeReport
     *
     * @return integer 
     */
    public function getTypeReport()
    {
        return $this->typeReport;
    }

    /**
     * Add products
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Product $products
     * @return ReportTemplate
     */
    public function addProduct(\Pequiven\SEIPBundle\Entity\CEI\Product $products)
    {
        $this->products->add($products);

        return $this;
    }

    /**
     * Remove products
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Product $products
     */
    public function removeProduct(\Pequiven\SEIPBundle\Entity\CEI\Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ReportTemplate
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
     * Set location
     *
     * @param \Pequiven\SEIPBundle\Entity\CEI\Location $location
     * @return ReportTemplate
     */
    public function setLocation(\Pequiven\SEIPBundle\Entity\CEI\Location $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \Pequiven\SEIPBundle\Entity\CEI\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }
    
    public function __toString() 
    {
        return $this->getDescription() ?:"-";
    }
}
