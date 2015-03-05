<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Entity\CEI;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\CEI\Location as Model;

/**
 * Sede (Control estadistico de informacion)
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @ORM\Table(name="seip_cei_Location")
 * @ORM\Entity()
 */
class Location extends Model
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
     * Empresa
     * @var Company
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\Company")
     * @ORM\Joincolumn(nullable=false)
     */
    private $company;
    
    /**
     * Nombre de la sede
     * @var String 
     * @ORM\Column(name="name",type="text",nullable=false)
     */
    private $name;
    
    /**
     * Tipo de sede
     * @var \Pequiven\SEIPBundle\Entity\CEI\TypeLocation
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\CEI\TypeLocation")
     * @ORM\Joincolumn(nullable=false)
     */
    private $typeLocation;
}
