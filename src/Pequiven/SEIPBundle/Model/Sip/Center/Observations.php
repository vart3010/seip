<?php

namespace Pequiven\SEIPBundle\Model\Sip\Center;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo Categorias de las Observaciones
 *
 * @author Maximo Sojo <maxsojo13@gmail.com>
 */
abstract class Observations {

    /**
     * Categorias
     *
     */
    const PROPAGANDA = 1;
    const TRANSPORTE = 2;
    const HIDRATACIÓN = 3;
    const LOGISTICA = 4;
    const ASISTENCIA = 5;
    const TELEFONIA = 6;

    /**
     * Status
     *
     */
    const ABIERTO = 1;
    const PENDIENTE = 2;
    const SEGUIMIENTO = 3;
    const CERRADO = 4;
    const RECHAZADO = 5;

    /**
     * @var integer
     *
     * @ORM\Column(name="categorias", type="integer")
     */
    protected $categorias;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    protected $status;

    /**
     * 
     * @param integer
     * @return 
     */
    function setCategorias($categorias) {
        $this->categorias = $categorias;
        return $this;
    }

    /**
     * 
     * @param integer
     * @return 
     */
    function getCategorias() {
        return $this->categorias;
    }

    /**
     * 
     * @param integer
     * @return 
     */
    function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * 
     * @param integer
     * @return 
     */
    function getStatus() {
        return $this->status;
    }

    static function getCategoriasObservations() {
        static $levelProcessArray = [
            self::PROPAGANDA => 'Propaganda',
            self::TRANSPORTE => 'Transporte',
            self::HIDRATACIÓN => 'Hidratación',
            self::LOGISTICA => 'Logistica',
            self::ASISTENCIA => 'Asistencia',
            self::TELEFONIA => 'Telefonia',
        ];
        return $levelProcessArray;
    }

    static function getStatusObservations() {
        static $status = [
            self::PENDIENTE => 'Pendiente',
            self::SEGUIMIENTO => 'Seguimiento',
            self::CERRADO => 'Cerrado',
            self::RECHAZADO => 'Rechazado',
        ];
        return $status;
    }

}
