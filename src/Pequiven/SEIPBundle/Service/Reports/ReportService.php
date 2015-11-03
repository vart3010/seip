<?php

namespace Pequiven\SEIPBundle\Service\Reports;

include_once('class/tcpdf/tcpdf.php');
include_once('class/PHPJasperXML.inc.php');

use PHPJasperXML;

/**
 * Servicio de Reporteador Jasper Report
 * 
 * service seip.service.result
 * @author inhack20
 */
class ReportService implements \Symfony\Component\DependencyInjection\ContainerAwareInterface {

    protected $errors;
    protected $container;

    public function __construct() {
        $this->errors = array();
        $this->server = "127.0.0.1"; // Nombre del Server 
        $this->db = "seip"; // Nombre de la BD 
        $this->user = "root"; // usuario 
        $this->pass = "a1b2c3$"; // password 
        $this->version = "0.9d"; // esta la version del PHPJasperXML no lo borren 
        $this->pchartfolder="class/pchart2";
    }

    /**
     * METODO PARA DESCARGA DIRECTA DE REPORTES PDF
     * @param array $parameter
     * @param type $route
     */
    public function DownloadReportService(array $parameter = null, $route) {

        // $parameters, parametros de consulta del reporte
        // $route, la ruta absoluta del reporte
        
        $route = $this->container->getParameter('kernel.root_dir') . "/../web/Reports/".$route;
        
        $PHPJasperXML = new PHPJasperXML();
        $PHPJasperXML->arrayParameter = $parameter;
        $PHPJasperXML->load_xml_file($route);
        $PHPJasperXML->transferDBtoArray($this->server, $this->user, $this->pass, $this->db);
        $PHPJasperXML->outpage("D");    //page output method I:standard output  D:Download file
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }

}
