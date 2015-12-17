<?php

namespace Pequiven\MasterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Pequiven\MasterBundle\Model\Gerencia as modelGerencia;
use Pequiven\MasterBundle\Model\Evaluation\AuditableInterface;
use Pequiven\MasterBundle\Entity\GerenciaSecond;

/**
 * Estructura de Cargos
 *
 * @ORM\Table(name="FeeStructure")
 * @ORM\Entity
 * @author Gilbert <glavrjk@gmail.com>
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class FeeStructure {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * 
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=100)
     */
    private $codigo;

    /**
     * Cargo
     * @var string
     *
     * @ORM\Column(name="charge", type="string")
     */
    private $charge;

    /** ID USUARIO
     *
     * @ORM\ManyToOne(targetEntity="Pequiven\SEIPBundle\Entity\User",inversedBy="feeStructure")
     * @ORM\JoinColumn(nullable=true)
     */
    private $User;

    /**
     * @var boolean
     *
     * @ORM\Column(name="staff", type="boolean")
     */
    private $staff = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = true;

    /**
     * @ORM\ManyToOne(targetEntity="\Pequiven\MasterBundle\Entity\FeeStructure",inversedBy="children")
     * @ORM\JoinColumn(name="fatherFee_id", nullable=true)
     */
    private $parent;

    /**
     * @var \Pequiven\MasterBundle\Entity\FeeStructure
     * @ORM\OneToMany(targetEntity="\Pequiven\MasterBundle\Entity\FeeStructure",mappedBy="parent",cascade={"persist"}))
     */
    protected $children;

}
