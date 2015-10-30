<?php

namespace Pequiven\SEIPBundle\Service;

include_once('class/tcpdf/tcpdf.php');
include_once('class/PHPJasperXML.inc.php');

use PHPJasperXML;

/**
 * Servicio de Reporteador Jasper Report
 * 
 * service seip.service.result
 * @author inhack20
 */
class ReportService implements ContainerAwareInterface {

    protected $errors;

    public function __construct() {
        $this->errors = array();

        $this->server = "127.0.0.1"; // Nombre del Server 
        $this->db = "seip"; // Nombre de la BD 
        $this->user = "root"; // usuario 
        $this->pass = "a1b2c3$"; // password 
        $this->version = "0.9d"; // esta la version del PHPJasperXML no lo borren 
    }

    /**
     * METODO PARA DESCARGA DIRECTA DE REPORTES PDF
     * @param array $parameter
     * @param type $route
     */
    public function DownloadReportService(array $parameter, $route) {

        // $parameters, parametros de consulta del reporte
        // $route, la ruta absoluta del reporte

        $PHPJasperXML = new PHPJasperXML();
        $PHPJasperXML->arrayParameter = $parameter;
        $PHPJasperXML->load_xml_file($route);
        $PHPJasperXML->transferDBtoArray($this->server, $this->user, $this->pass, $this->db);
        $PHPJasperXML->outpage("D");    //page output method I:standard output  D:Download file
    }

}
