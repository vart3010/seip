<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pequiven\SEIPBundle\Model\PDF;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TCPDF;

class CETSeipPdf extends TCPDF implements ContainerAwareInterface {

    /**
     * @var ContainerInterface
     *
     * @api
     */
    private $container;
    protected $period;
    protected $footerText;
    private $printLineFooter = true;

    //Header del documento pdf de resultados
    public function Header() {

        // Logo SEIP
//        $logopqv = $this->generateAsset('bundles/pequivenseip/logotipos-pqv/logotipos-pdf/Logo_Pequiven.jpg'); //K_PATH_IMAGES.'logo_example.jpg';
//        $logoseip = $this->generateAsset('bundles/pequivenseip/logotipos-pqv/logotipos-pdf/Logo_Seip.jpg'); //K_PATH_IMAGES.'logo_example.jpg';

        $logoCET = $this->generateAsset('bundles/pequivenseip/logotipos-pqv/logotipos-pdf/LogoCTE.png');

        $tittle = $this->title;

        // Set font
        $this->SetFont('helvetica', 'B', 8);
        $this->SetTextColor(0, 0, 0);
        // Title
        /*$text = '<table width="100%" cellpadding="2">'
                . '<tr bgcolor="#C00000">'
                . '<td width="100%" height="65px" style="text-align: center;">'
                . '&nbsp;'
                . '</td>'
                . '</tr>'
                . '</table>'
                . '<table width="100%">'
                . '<tr bgcolor="#D9D9D9">'
                . '<td width="100%" height="20px" style="text-align: left; font-size: 10pt; color: #C00000; vertical-align: middle; font-family: sans-serif;">   ' . strtr(strtoupper($tittle), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ") . '</td>'
                . '</tr>'
                . '</table>';*/


       $this->Image($logoCET, 7 , 5, 197, 35, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);


        //$this->writeHTML($text);
    }

    // Footer del pdf de resultados
    public function Footer() {
        // Position at 27 mm from bottom
        $this->SetY(-30);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        $logoeslogan = $this->generateAsset('bundles/pequivenseip/logotipos-pqv/logotipos-pdf/Pueblo_Victorioso.png');
        $logoministerio = $this->generateAsset('bundles/pequivenseip/logotipos-pqv/logotipos-pdf/Ministerio.jpg');
        // Page number
        //. $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages() .

        $this->Image($logoministerio, 10, 282, 75, 10, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Image($logoeslogan, 175, 282, 20, 10, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

//        $footer = '<div style="text-align: rigth; margin-top: 100px; margin-left: 50px">'                
//                . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages()                
//                . '</div>';
////                . '<span style="color: #bb0707; font-size: 1.3em;font-weight: bold;font-variant: small-caps;">' . $this->footerText . '</span><br><span>' . $this->trans('pequiven_seip.pdf.pageFooter', array('%page%' => $this->getAliasNumPage(), '%totalPage%' => $this->getAliasNbPages()), 'PequivenSEIPBundle') . '</span></div>';
//        $this->writeHTML($footer);
        //);
        $text = $this->getAliasNumPage() . '/' . $this->getAliasNbPages();
        $this->Text(190, 277, $text);

        //Línea HR
        $lineRed = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(192, 0, 0));
        $this->Line(10, 281, 200, 281, $lineRed);
    }

    /**
     * Servicio que setea el período
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     */
    public function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period) {
        $this->period = $period;
    }

    /**
     * Texto que va en el footer
     * @param type $text
     */
    public function setFooterText($text) {
        $this->footerText = $text;
    }

    /**
     * Servicio para generar los assets
     * @param type $path
     * @param type $packageName
     * @return type
     */
    protected function generateAsset($path, $packageName = null) {
        return $this->container->get('templating.helper.assets')
                        ->getUrl($path, $packageName);
    }

    protected function trans($id, array $parameters = array(), $domain = 'messages') {
        return $this->container->get('translator')->trans($id, $parameters, $domain);
    }

    /**
     * Servicio que setea el container
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container
        ;
    }

    function setPrintLineFooter($printLineFooter) {
        $this->printLineFooter = $printLineFooter;
    }

}
