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

    /**
     * FUNCION QUE CREA EL PDF DE LOS REPORTES DEL SEIP
     * @param type $data
     * @param type $title
     * @param type $template
     * @param type $orientation
     * @param type $archiveTittle
     */
    public function generatePDF($data, $title, $template, $orientation, $archiveTittle = null) {

        if ($archiveTittle == null) {
            $archiveTittle = $title;
        }

        $pdf = new \Pequiven\SEIPBundle\Model\PDF\NewSeipPdf($orientation, 'mm', 'LETTER', true, 'UTF-8', false);
        $pdf->setPrintLineFooter(false);
        $pdf->setContainer($this->container);
        $pdf->setPeriod($this->getPeriodService()->getPeriodActive());
        $pdf->setFooterText('Gerencia Corporativa de Planificación Estratégica y Nuevos Desarrollos');
        $pdf->SetCreator('SEIP');
        $pdf->SetAuthor('SEIP');
        $pdf->setTitle($title);
        $pdf->SetSubject($archiveTittle);
        $pdf->SetKeywords('PDF, SEIP, Resultados');
        $pdf->setHeaderFont(Array('helvetica', '', 10));
        $pdf->setFooterFont(Array('helvetica', '', 8));
        $pdf->SetDefaultMonospacedFont('courier');
        $pdf->SetMargins(15, 42, 15);
        $pdf->SetHeaderMargin(15);
        $pdf->SetFooterMargin(15);
        $pdf->SetAutoPageBreak(TRUE, 28);
        $pdf->setImageScale(1.25);
        $pdf->AddPage();
        $html = $this->renderView($template, $data);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output(($archiveTittle) . '.pdf', 'D');
    }

    /**
     * FUNCION QUE CREA EL PDF DE LOS REPORTES DE HOUSESUPPLY
     * @param type $data
     * @param type $title
     * @param type $template
     * @param type $orientation
     * @param type $archiveTittle
     */
    public function generateHouseSupplyPDF($data, $title, $template, $orientation, $archiveTittle = null) {

        if ($archiveTittle == null) {
            $archiveTittle = $title;
        }

        $pdf = new \Pequiven\SEIPBundle\Model\PDF\HouseSupplyPdf($orientation, 'mm', 'LETTER', true, 'UTF-8', false);
        $pdf->setPrintLineFooter(false);
        $pdf->setContainer($this->container);
        $pdf->setPeriod($this->getPeriodService()->getPeriodActive());
        $pdf->setFooterText('Gerencia Corporativa de Planificación Estratégica y Nuevos Desarrollos');
        $pdf->SetCreator('SEIP');
        $pdf->SetAuthor('SEIP');
        $pdf->setTitle($title);
        $pdf->SetSubject($archiveTittle);
        $pdf->SetKeywords('PDF, SEIP, Casa-Abasto');
        $pdf->setHeaderFont(Array('helvetica', '', 10));
        $pdf->setFooterFont(Array('helvetica', '', 8));
        $pdf->SetDefaultMonospacedFont('courier');
        $pdf->SetMargins(15, 42, 15);
        $pdf->SetHeaderMargin(15);
        $pdf->SetFooterMargin(15);
        $pdf->SetAutoPageBreak(TRUE, 28);
        $pdf->setImageScale(1.25);
        $pdf->AddPage();
        $html = $this->renderView($template, $data);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output(($archiveTittle) . '.pdf', 'D');
    }
    
     /**
     * FUNCION QUE CREA EL PDF DE LOS REPORTES DE CIRCULOS DE ESTUDIO Y TRABAJO
     * @param type $data
     * @param type $title
     * @param type $template
     * @param type $orientation
     * @param type $archiveTittle
     */
    public function generateCETPDF($data, $title, $template, $orientation, $archiveTittle = null) {

        if ($archiveTittle == null) {
            $archiveTittle = $title;
        }

        $pdf = new \Pequiven\SEIPBundle\Model\PDF\CETSeipPdf($orientation, 'mm', 'LETTER', true, 'UTF-8', false);
        $pdf->setPrintLineFooter(false);
        $pdf->setContainer($this->container);
        $pdf->setPeriod($this->getPeriodService()->getPeriodActive());
        $pdf->setFooterText('Gerencia Corporativa de Planificación Estratégica y Nuevos Desarrollos');
        $pdf->SetCreator('SEIP');
        $pdf->SetAuthor('SEIP');
        $pdf->setTitle($title);
        $pdf->SetSubject($archiveTittle);
        $pdf->SetKeywords('PDF, SEIP, Circulo de Estudio y Trabajo Petroquímico');
        $pdf->setHeaderFont(Array('helvetica', '', 10));
        $pdf->setFooterFont(Array('helvetica', '', 8));
        $pdf->SetDefaultMonospacedFont('courier');
        $pdf->SetMargins(15, 60, 15);
        $pdf->SetHeaderMargin(15);
        $pdf->SetFooterMargin(15);
        $pdf->SetAutoPageBreak(TRUE, 28);
        $pdf->setImageScale(1.25);
        $pdf->AddPage();
        $html = $this->renderView($template, $data);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output(($archiveTittle) . '.pdf', 'D');
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null) {
        $this->container = $container;
    }

    protected function getPeriodService() {
        return $this->container->get('pequiven_seip.service.period');
    }

    public function renderView($view, array $parameters = array()) {
        if ($this->container->has('templating')) {
            return $this->container->get('templating')->render($view, $parameters);
        }

        if (!$this->container->has('twig')) {
            throw new \LogicException('You can not use the "renderView" method if the Templating Component or the Twig Bundle are not available.');
        }

        return $this->container->get('twig')->render($view, $parameters);
    }

}
