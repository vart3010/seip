<?php

namespace Pequiven\SEIPBundle\Service\Reports;

include_once('clases/tcpdf/tcpdf.php');
include_once('clases/PHPJasperXML.inc.php');

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
        $this->version = "0.9d"; // esta la version del PHPJasperXML no lo borren 
        $this->pchartfolder = "class/pchart2";
    }

    /**
     * METODO PARA DESCARGA DIRECTA DE REPORTES PDF
     * @param array $parameter
     * @param type $route
     */
    public function DownloadReportService(array $parameter = null, $route) {

        $server = $this->container->getParameter('database_host'); // Nombre del Server 
        $db = $this->container->getParameter('database_name'); // Nombre de la BD 
        $user = $this->container->getParameter('database_user'); // usuario 
        $pass = $this->container->getParameter('database_password'); // password 
        // $parameters, parametros de consulta del reporte
        // $route, la ruta absoluta del reporte

        $route = $this->container->getParameter('kernel.root_dir') . "/../web/Reports/" . $route;

        $PHPJasperXML = new PHPJasperXML();
        $PHPJasperXML->arrayParameter = $parameter;
        $xml = simplexml_load_file($route);
        $PHPJasperXML->xml_dismantle($xml);
        $PHPJasperXML->transferDBtoArray($server, $user, $pass, $db);
        $PHPJasperXML->outpage("D");    //page output method I:standard output  D:Download file        
    }

    public function ViewReportService(array $parameter = null, $route) {


        $server = $this->container->getParameter('database_host'); // Nombre del Server 
        $db = $this->container->getParameter('database_name'); // Nombre de la BD 
        $user = $this->container->getParameter('database_user'); // usuario 
        $pass = $this->container->getParameter('database_password'); // password 
        
        // $parameters, parametros de consulta del reporte
        // $route, la ruta absoluta del reporte

        $route = $this->container->getParameter('kernel.root_dir') . "/../web/Reports/" . $route;

        $PHPJasperXML = new PHPJasperXML();
        $PHPJasperXML->arrayParameter = $parameter;
        $xml = simplexml_load_file($route);
        $PHPJasperXML->xml_dismantle($xml);
        $PHPJasperXML->transferDBtoArray($server, $user, $pass, $db);
        $PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file        
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }

}
