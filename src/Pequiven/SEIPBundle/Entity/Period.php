<?php

namespace Pequiven\SEIPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\Period as Base;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Periodo
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="name_idx", columns={"name"})})
 * @ORM\Entity(repositoryClass="Pequiven\SEIPBundle\Repository\PeriodRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Period extends Base implements \Serializable {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Nombre del periodo
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * Description del periodo
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * Fecha de inicio
     * @var \DateTime
     *
     * @ORM\Column(name="dateStart", type="date", nullable=false)
     */
    private $dateStart;

    /**
     * Fecha fin
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnd", type="date", nullable=false)
     */
    private $dateEnd;

    /**
     * Estatus del periodo
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status = false;

    /**
     * ¿El periodo esta abierto? (Si, esta cerrado no se permitira edicion alguna)
     * @var boolean
     *
     * @ORM\Column(name="opened", type="boolean")
     */
    private $opened = true;

    /**
     * Fecha inicio de notificación de programas de gestion.
     * @var \DateTime
     *
     * @ORM\Column(name="dateStartNotificationArrangementProgram", type="date", nullable=true)
     */
    private $dateStartNotificationArrangementProgram;

    /**
     * Fecha fin de notificación de programas de gestion.
     * @var \DateTime
     *
     * @ORM\Column(name="dateEndNotificationArrangementProgram", type="date", nullable=true)
     */
    private $dateEndNotificationArrangementProgram;

    /**
     * Fecha inicio de carga de programas de gestion.
     * @var \DateTime
     *
     * @ORM\Column(name="dateStartLoadArrangementProgram", type="date", nullable=true)
     */
    private $dateStartLoadArrangementProgram;

    /**
     * Fecha fin de carga de programas de gestión.
     * @var \DateTime
     *
     * @ORM\Column(name="dateEndLoadArrangementProgram", type="date", nullable=true)
     */
    private $dateEndLoadArrangementProgram;

    /**
     * Fecha inicio de carga de programas de gestion para SIG.
     * @var \DateTime
     *
     * @ORM\Column(name="dateStartLoadSigArrangementProgram", type="date", nullable=true)
     */
    private $dateStartLoadSigArrangementProgram;

    /**
     * Fecha fin de carga de programas de gestión para SIG.
     * @var \DateTime
     *
     * @ORM\Column(name="dateEndLoadSigArrangementProgram", type="date", nullable=true)
     */
    private $dateEndLoadSigArrangementProgram;

    /**
     * Fecha inicio de carga de objetivos.
     * @var \DateTime
     *
     * @ORM\Column(name="dateStartLoadObjetive", type="date", nullable=true)
     */
    private $dateStartLoadObjetive;

    /**
     * Fecha fin de carga de objetivos.
     * @var \DateTime
     *
     * @ORM\Column(name="dateEndLoadObjetive", type="date", nullable=true)
     */
    private $dateEndLoadObjetive;

    /**
     * Fecha inicio de carga de indicadores.
     * @var \DateTime
     *
     * @ORM\Column(name="dateStartLoadIndicator", type="date", nullable=true)
     */
    private $dateStartLoadIndicator;

    /**
     * Fecha fin de carga de indicadores.
     * @var \DateTime
     *
     * @ORM\Column(name="dateEndLoadIndicator", type="date", nullable=true)
     */
    private $dateEndLoadIndicator;

    /**
     * Fecha inicio de carga de circulos de estudio.
     * @var \DateTime
     *
     * @ORM\Column(name="dateStartLoadWorkStudyCircle", type="date", nullable=true)
     */
    private $dateStartLoadWorkStudyCircle;

    /**
     * Fecha fin de carga de circulos de estudio.
     * @var \DateTime
     *
     * @ORM\Column(name="dateEndLoadWorkStudyCircle", type="date", nullable=true)
     */
    private $dateEndLoadWorkStudyCircle;

    /**
     * Fecha inicio de holgura de notificación de programas de gestion
     * @var \DateTime
     *
     * @ORM\Column(name="dateStartClearanceNotificationArrangementProgram", type="date", nullable=true)
     */
    private $dateStartClearanceNotificationArrangementProgram;

    /**
     * Fecha inicio de penalizacion
     * @var \DateTime
     *
     * @ORM\Column(name="dateStartPenalty", type="date", nullable=true)
     */
    private $dateStartPenalty;

    /**
     * Fecha fin de penalizacion
     * @var \DateTime
     *
     * @ORM\Column(name="dateEndPenalty", type="date", nullable=true)
     */
    private $dateEndPenalty;

    /**
     * Porcentaje de penalizacion
     * @var \DateTime
     *
     * @ORM\Column(name="percentagePenalty", type="float", nullable=false)
     */
    private $percentagePenalty;

    /**
     * Fecha fin de holgura de notificación de programas de gestion
     * @var \DateTime
     *
     * @ORM\Column(name="dateEndClearanceNotificationArrangementProgram", type="date", nullable=true)
     */
    private $dateEndClearanceNotificationArrangementProgram;

    /**
     * Periodo anterior o padre
     * 
     * @var type 
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period",inversedBy="child")
     */
    private $parent;

    /**
     *
     * @var type 
     * @ORM\OneToOne(targetEntity="Pequiven\SEIPBundle\Entity\Period",mappedBy="parent")
     */
    private $child;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;
    //****CHECKS PARA ACTIVAR O DESACTIVAR UN TRIMESTRE (Notificación de Indicadores)***/////
    /**
     * @ORM\Column(name="isLoadIndicatorTrim1", type="boolean", nullable=true)
     */
    private $isLoadIndicatorTrim1 = false;

    /**
     * @ORM\Column(name="isLoadIndicatorTrim2", type="boolean", nullable=true)
     */
    private $isLoadIndicatorTrim2 = false;

    /**
     * @ORM\Column(name="isLoadIndicatorTrim3", type="boolean", nullable=true)
     */
    private $isLoadIndicatorTrim3 = false;

    /**
     * @ORM\Column(name="isLoadIndicatorTrim4", type="boolean", nullable=true)
     */
    private $isLoadIndicatorTrim4 = false;

    //********************************************//

    /**
     * Fecha inicio de planificacion de reportes
     * @var \DateTime
     * @ORM\Column(name="dateStartPlanningReport", type="date", nullable=true)
     */
    private $dateStartPlanningReport;

    /**
     * Fecha fin de planificacion de reportes
     * @var \DateTime
     * @ORM\Column(name="dateEndPlanningReport", type="date", nullable=true)
     */
    private $dateEndPlanningReport;

    /**
     * ¿Habilita la planificacion?
     * @ORM\Column(name="isPlanningReportEnabled", type="boolean", nullable=true)
     */
    private $isPlanningReportEnabled = false;


    /* fecha apra abrir grupo de productos* */

    /**
     * Fecha inicio de planificacion de reportes
     * @var \DateTime
     * @ORM\Column(name="dateStartLoadGroupProduct", type="date", nullable=true)
     */
    private $dateStartLoadGroupProduct;

    /**
     * Fecha fin de planificacion de reportes
     * @var \DateTime
     * @ORM\Column(name="dateEndLoadGroupProduct", type="date", nullable=true)
     */
    private $dateEndLoadGroupProduct;

    /**
     * ¿Habilita la planificacion?
     * @ORM\Column(name="isLoadGroupProductEnabled", type="boolean", nullable=true)
     */
    private $isLoadGroupProductEnabled = false;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Period
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     * @return Period
     */
    public function setDateStart($dateStart) {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime 
     */
    public function getDateStart() {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return Period
     */
    public function setDateEnd($dateEnd) {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime 
     */
    public function getDateEnd() {
        return $this->dateEnd;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Period
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus() {
        return $this->status;
    }

    function getDescription() {
        return $this->description;
    }

    /**
     * 
     * @param type $description
     * @return \Pequiven\SEIPBundle\Entity\Period
     */
    function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Set dateStartNotificationArrangementProgram
     *
     * @param \DateTime $dateStartNotificationArrangementProgram
     * @return Period
     */
    public function setDateStartNotificationArrangementProgram($dateStartNotificationArrangementProgram) {
        $this->dateStartNotificationArrangementProgram = $dateStartNotificationArrangementProgram;

        return $this;
    }

    /**
     * Get dateStartNotificationArrangementProgram
     *
     * @return \DateTime 
     */
    public function getDateStartNotificationArrangementProgram() {
        return $this->dateStartNotificationArrangementProgram;
    }

    /**
     * Set dateEndNotificationArrangementProgram
     *
     * @param \DateTime $dateEndNotificationArrangementProgram
     * @return Period
     */
    public function setDateEndNotificationArrangementProgram($dateEndNotificationArrangementProgram) {
        $this->dateEndNotificationArrangementProgram = $dateEndNotificationArrangementProgram;

        return $this;
    }

    /**
     * Get dateEndNotificationArrangementProgram
     *
     * @return \DateTime 
     */
    public function getDateEndNotificationArrangementProgram() {
        return $this->dateEndNotificationArrangementProgram;
    }

    /**
     * Set dateStartLoadArrangementProgram
     *
     * @param \DateTime $dateStartLoadArrangementProgram
     * @return Period
     */
    public function setDateStartLoadArrangementProgram($dateStartLoadArrangementProgram) {
        $this->dateStartLoadArrangementProgram = $dateStartLoadArrangementProgram;

        return $this;
    }

    /**
     * Get dateStartLoadArrangementProgram
     *
     * @return \DateTime 
     */
    public function getDateStartLoadArrangementProgram() {
        return $this->dateStartLoadArrangementProgram;
    }

    /**
     * Set dateEndLoadArrangementProgram
     *
     * @param \DateTime $dateEndLoadArrangementProgram
     * @return Period
     */
    public function setDateEndLoadArrangementProgram($dateEndLoadArrangementProgram) {
        $this->dateEndLoadArrangementProgram = $dateEndLoadArrangementProgram;

        return $this;
    }

    /**
     * Get dateEndLoadArrangementProgram
     *
     * @return \DateTime 
     */
    public function getDateEndLoadArrangementProgram() {
        return $this->dateEndLoadArrangementProgram;
    }

    /**
     * Set dateStartLoadSigArrangementProgram
     *
     * @param \DateTime $dateStartLoadSigArrangementProgram
     * @return Period
     */
    public function setDateStartLoadSigArrangementProgram($dateStartLoadSigArrangementProgram) {
        $this->dateStartLoadSigArrangementProgram = $dateStartLoadSigArrangementProgram;

        return $this;
    }

    /**
     * Get dateStartLoadSigArrangementProgram
     *
     * @return \DateTime 
     */
    public function getDateStartLoadSigArrangementProgram() {
        return $this->dateStartLoadSigArrangementProgram;
    }

    /**
     * Set dateEndLoadSigArrangementProgram
     *
     * @param \DateTime $dateEndLoadSigArrangementProgram
     * @return Period
     */
    public function setDateEndLoadSigArrangementProgram($dateEndLoadSigArrangementProgram) {
        $this->dateEndLoadSigArrangementProgram = $dateEndLoadSigArrangementProgram;

        return $this;
    }

    /**
     * Get dateEndLoadSigArrangementProgram
     *
     * @return \DateTime 
     */
    public function getDateEndLoadSigArrangementProgram() {
        return $this->dateEndLoadSigArrangementProgram;
    }

    /**
     * Set dateStartLoadObjetive
     *
     * @param \DateTime $dateStartLoadObjetive
     * @return Period
     */
    public function setDateStartLoadObjetive($dateStartLoadObjetive) {
        $this->dateStartLoadObjetive = $dateStartLoadObjetive;

        return $this;
    }

    /**
     * Get dateStartLoadObjetive
     *
     * @return \DateTime 
     */
    public function getDateStartLoadObjetive() {
        return $this->dateStartLoadObjetive;
    }

    /**
     * Set dateEndLoadObjetive
     *
     * @param \DateTime $dateEndLoadObjetive
     * @return Period
     */
    public function setDateEndLoadObjetive($dateEndLoadObjetive) {
        $this->dateEndLoadObjetive = $dateEndLoadObjetive;

        return $this;
    }

    /**
     * Get dateEndLoadObjetive
     *
     * @return \DateTime 
     */
    public function getDateEndLoadObjetive() {
        return $this->dateEndLoadObjetive;
    }

    /**
     * Set dateStartLoadIndicator
     *
     * @param \DateTime $dateStartLoadIndicator
     * @return Period
     */
    public function setDateStartLoadIndicator($dateStartLoadIndicator) {
        $this->dateStartLoadIndicator = $dateStartLoadIndicator;

        return $this;
    }

    /**
     * Get dateStartLoadIndicator
     *
     * @return \DateTime 
     */
    public function getDateStartLoadIndicator() {
        return $this->dateStartLoadIndicator;
    }

    /**
     * Set dateEndLoadIndicator
     *
     * @param \DateTime $dateEndLoadIndicator
     * @return Period
     */
    public function setDateEndLoadIndicator($dateEndLoadIndicator) {
        $this->dateEndLoadIndicator = $dateEndLoadIndicator;

        return $this;
    }

    /**
     * Get dateEndLoadIndicator
     *
     * @return \DateTime 
     */
    public function getDateEndLoadIndicator() {
        return $this->dateEndLoadIndicator;
    }

    /**
     * Set dateStartLoadWorkStudyCircle
     *
     * @param \DateTime $dateStartLoadWorkStudyCircle
     * @return Period
     */
    public function setDateStartLoadWorkStudyCircle($dateStartLoadWorkStudyCircle) {
        $this->dateStartLoadWorkStudyCircle = $dateStartLoadWorkStudyCircle;

        return $this;
    }

    /**
     * Get dateStartLoadWorkStudyCircle
     *
     * @return \DateTime 
     */
    public function getDateStartLoadWorkStudyCircle() {
        return $this->dateStartLoadWorkStudyCircle;
    }

    /**
     * Set dateEndLoadWorkStudyCircle
     *
     * @param \DateTime $dateEndLoadWorkStudyCircle
     * @return Period
     */
    public function setDateEndLoadWorkStudyCircle($dateEndLoadWorkStudyCircle) {
        $this->dateEndLoadWorkStudyCircle = $dateEndLoadWorkStudyCircle;

        return $this;
    }

    /**
     * Get dateEndLoadWorkStudyCircle
     *
     * @return \DateTime 
     */
    public function getDateEndLoadWorkStudyCircle() {
        return $this->dateEndLoadWorkStudyCircle;
    }

    /**
     * Set dateStartClearanceNotificationArrangementProgram
     *
     * @param \DateTime $dateStartClearanceNotificationArrangementProgram
     * @return Period
     */
    public function setDateStartClearanceNotificationArrangementProgram($dateStartClearanceNotificationArrangementProgram) {
        $this->dateStartClearanceNotificationArrangementProgram = $dateStartClearanceNotificationArrangementProgram;

        return $this;
    }

    /**
     * Get dateStartClearanceNotificationArrangementProgram
     *
     * @return \DateTime 
     */
    public function getDateStartClearanceNotificationArrangementProgram() {
        return $this->dateStartClearanceNotificationArrangementProgram;
    }

    /**
     * Set dateEndClearanceNotificationArrangementProgram
     *
     * @param \DateTime $dateEndClearanceNotificationArrangementProgram
     * @return Period
     */
    public function setDateEndClearanceNotificationArrangementProgram($dateEndClearanceNotificationArrangementProgram) {
        $this->dateEndClearanceNotificationArrangementProgram = $dateEndClearanceNotificationArrangementProgram;

        return $this;
    }

    /**
     * Get dateEndClearanceNotificationArrangementProgram
     *
     * @return \DateTime 
     */
    public function getDateEndClearanceNotificationArrangementProgram() {
        return $this->dateEndClearanceNotificationArrangementProgram;
    }

    /**
     * Set parent
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $parent
     * @return Period
     */
    public function setParent(\Pequiven\SEIPBundle\Entity\Period $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pequiven\SEIPBundle\Entity\Period 
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Set child
     *
     * @param \Pequiven\SEIPBundle\Entity\Period $child
     * @return Period
     */
    public function setChild(\Pequiven\SEIPBundle\Entity\Period $child = null) {
        $this->child = $child;

        return $this;
    }

    /**
     * Get child
     *
     * @return \Pequiven\SEIPBundle\Entity\Period 
     */
    public function getChild() {
        return $this->child;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Period
     */
    public function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt() {
        return $this->deletedAt;
    }

    /**
     * Set dateStartPenalty
     *
     * @param \DateTime $dateStartPenalty
     * @return Period
     */
    public function setDateStartPenalty($dateStartPenalty) {
        $this->dateStartPenalty = $dateStartPenalty;

        return $this;
    }

    /**
     * Get dateStartPenalty
     *
     * @return \DateTime 
     */
    public function getDateStartPenalty() {
        return $this->dateStartPenalty;
    }

    /**
     * Set dateEndPenalty
     *
     * @param \DateTime $dateEndPenalty
     * @return Period
     */
    public function setDateEndPenalty($dateEndPenalty) {
        $this->dateEndPenalty = $dateEndPenalty;

        return $this;
    }

    /**
     * Get dateEndPenalty
     *
     * @return \DateTime 
     */
    public function getDateEndPenalty() {
        return $this->dateEndPenalty;
    }

    /**
     * Set percentagePenalty
     *
     * @param float $percentagePenalty
     * @return Period
     */
    public function setPercentagePenalty($percentagePenalty) {
        $this->percentagePenalty = $percentagePenalty;

        return $this;
    }

    /**
     * Get percentagePenalty
     *
     * @return float 
     */
    public function getPercentagePenalty() {
        return $this->percentagePenalty;
    }

    /**
     * 
     * @return type
     */
    public function getIsLoadIndicatorTrim1() {
        return $this->isLoadIndicatorTrim1;
    }

    /**
     * 
     * @param type $isLoadIndicatorTrim1
     */
    public function setIsLoadIndicatorTrim1($isLoadIndicatorTrim1) {
        $this->isLoadIndicatorTrim1 = $isLoadIndicatorTrim1;
    }

    /**
     * 
     * @return type
     */
    public function getIsLoadIndicatorTrim2() {
        return $this->isLoadIndicatorTrim2;
    }

    /**
     * 
     * @param type $isLoadIndicatorTrim2
     */
    public function setIsLoadIndicatorTrim2($isLoadIndicatorTrim2) {
        $this->isLoadIndicatorTrim2 = $isLoadIndicatorTrim2;
    }

    /**
     * 
     * @return type
     */
    public function getIsLoadIndicatorTrim3() {
        return $this->isLoadIndicatorTrim3;
    }

    /**
     * 
     * @param type $isLoadIndicatorTrim3
     */
    public function setIsLoadIndicatorTrim3($isLoadIndicatorTrim3) {
        $this->isLoadIndicatorTrim3 = $isLoadIndicatorTrim3;
    }

    /**
     * 
     * @return type
     */
    public function getIsLoadIndicatorTrim4() {
        return $this->isLoadIndicatorTrim4;
    }

    /**
     * 
     * @param type $isLoadIndicatorTrim4
     */
    public function setIsLoadIndicatorTrim4($isLoadIndicatorTrim4) {
        $this->isLoadIndicatorTrim4 = $isLoadIndicatorTrim4;
    }

    //TODO Objeto falla al ser serializado
    public function serialize() {
        $data = serialize(array(
            $this->name,
            $this->description,
            $this->dateStart,
            $this->dateEnd,
            $this->status,
            $this->dateStartNotificationArrangementProgram,
            $this->dateEndNotificationArrangementProgram,
            $this->dateStartLoadArrangementProgram,
            $this->dateEndLoadArrangementProgram,
            $this->dateStartLoadSigArrangementProgram,
            $this->dateEndLoadSigArrangementProgram,
            $this->dateStartClearanceNotificationArrangementProgram,
            $this->dateStartPenalty,
            $this->dateEndPenalty,
            $this->percentagePenalty,
            $this->dateEndClearanceNotificationArrangementProgram,
            base64_encode(serialize($this->parent)),
            base64_encode(serialize($this->child)),
            $this->id,
        ));
//        echo $data;
//        var_dump(unserialize(utf8_encode(utf8_decode($data))));
////        echo utf8_decode(var_export(unserialize(utf8_encode($data)),true));
//        die;
        return base64_encode($data);
    }

    //TODO Objeto falla al ser desserializado
    public function unserialize($serialized) {
        $data = unserialize(base64_decode($serialized));
//        var_dump($data);
//        die;
        // add a few extra elements in the array to ensure that we have enough keys when unserializing
        // older data which does not include all properties.
        $data = array_merge($data, array_fill(0, 2, null));
//        var_dump($data);
        $data[14] = base64_decode($data[14]);
        $data[15] = base64_decode($data[15]);
        list(
                $this->name,
                $this->description,
                $this->dateStart,
                $this->dateEnd,
                $this->status,
                $this->dateStartNotificationArrangementProgram,
                $this->dateEndNotificationArrangementProgram,
                $this->dateStartLoadArrangementProgram,
                $this->dateEndLoadArrangementProgram,
                $this->dateStartLoadSigArrangementProgram,
                $this->dateEndLoadSigArrangementProgram,
                $this->dateStartClearanceNotificationArrangementProgram,
                $this->dateStartPenalty,
                $this->dateEndPenalty,
                $this->percentagePenalty,
                $this->dateEndClearanceNotificationArrangementProgram,
                $this->parent,
                $this->child,
                $this->id,
                ) = $data;
        $this->parent = unserialize($this->parent);
        $this->child = unserialize($this->child);
    }

    function isOpened() {
        return $this->opened;
    }

    function getOpened() {
        return $this->opened;
    }

    function setOpened($opened) {
        $this->opened = $opened;
    }

    function getDateStartPlanningReport() {
        return $this->dateStartPlanningReport;
    }

    function getDateEndPlanningReport() {
        return $this->dateEndPlanningReport;
    }

    function getIsPlanningReportEnabled() {
        return $this->isPlanningReportEnabled;
    }

    function setDateStartPlanningReport(\DateTime $dateStartPlanningReport) {
        $this->dateStartPlanningReport = $dateStartPlanningReport;
    }

    function setDateEndPlanningReport(\DateTime $dateEndPlanningReport) {
        $this->dateEndPlanningReport = $dateEndPlanningReport;
    }

    function setIsPlanningReportEnabled($isPlanningReportEnabled) {
        $this->isPlanningReportEnabled = $isPlanningReportEnabled;
    }

    function getDateStartLoadGroupProduct() {
        return $this->dateStartLoadGroupProduct;
    }

    function getDateEndLoadGroupProduct() {
        return $this->dateEndLoadGroupProduct;
    }

    function getIsLoadGroupProductEnabled() {
        return $this->isLoadGroupProductEnabled;
    }

    function setDateStartLoadGroupProduct(\DateTime $dateStartLoadGroupProduct) {
        $this->dateStartLoadGroupProduct = $dateStartLoadGroupProduct;
    }

    function setDateEndLoadGroupProduct(\DateTime $dateEndLoadGroupProduct) {
        $this->dateEndLoadGroupProduct = $dateEndLoadGroupProduct;
    }

    function setIsLoadGroupProductEnabled($isLoadGroupProductEnabled) {
        $this->isLoadGroupProductEnabled = $isLoadGroupProductEnabled;
    }

    public function __toString() {
        return $this->getDescription()? : '-';
    }

}
