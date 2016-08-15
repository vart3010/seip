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

/**
 * HEADER Y FOOTER DE REPORTES CASA-ABASTO
 * @author Gilbert C. <glavrjk@gmail.com>
 */
class HouseSupplyPdf extends TCPDF implements ContainerAwareInterface {

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

        $logopqv = $this->generateAsset('bundles/pequivenseip/logotipos-pqv/logotipos-pdf/housesupply/Casa_Abasto_Cintillo.png');
        $logoseip = $this->generateAsset('bundles/pequivenseip/logotipos-pqv/logotipos-pdf/housesupply/Casa_Abasto.png');


        $tittle = $this->title;

        // Set font
        $this->SetFont('helvetica', 'B', 8);
        $this->SetTextColor(0, 0, 0);
        // Title
        $text = '<table width="100%" cellpadding="2">'
                . '<tr>'
                . '<td width="50%" height="85px" style="text-align: left;">'
                . '<img src="' . $logopqv . '" height="80px">'
                . '</td>'
                . '<td width="35%" height="85px" style="text-align: left; font-size: 12pt; color: #C00000; vertical-align: middle; font-family: sans-serif;">   '
                . '<br><br><br>'
                . strtr(strtoupper($tittle), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ")
                . '</td>'
                . '<td width="15%" height="85px" style="text-align: center; font-size: 3pt;">'
                . '<br><br><img src="' . $logoseip . '" height="80px">'
                . '</td>'
                . '</tr>'
                . '</table>';
        $this->writeHTML($text);
    }

    // Footer del pdf de resultados
    public function Footer() {
        // Position at 27 mm from bottom
        //      $this->SetY(-30);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
//        $logoeslogan = $this->generateAsset('bundles/pequivenseip/logotipos-pqv/logotipos-pdf/Patriotas_Unidos.jpg');
//        $logoministerio = $this->generateAsset('bundles/pequivenseip/logotipos-pqv/logotipos-pdf/Ministerio.jpg');
        // Page number
        //. $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages() .

        $margin = $this->getPageDimensions();
        $lineRed = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(192, 0, 0));
        $text = $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages();

        if ($margin['or'] == 'P') {
//            $html = '<p style="text-align: center; font-size: 6pt; font-weight: bold; color: #B00000; vertical-align: middle; font-family: sans-serif;">'
//                    . 'Gerencia Corporativa de Planificación Estratégica y Nuevos Desarrollos'
//                    . '</p>';
            $this->Line(15, 260, 200, 260, $lineRed);
//            $this->Image($logoministerio, 15, 255, 75, 10, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//            $this->Image($logoeslogan, 160, 255, 40, 10, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->Text(110, 262, $text);
//            $this->writeHTMLCell(60, 20, 95, 260, $html);
        } else {
//            $html = '<div style="text-align: center; font-size: 8pt; font-weight: bold; color: #B00000; vertical-align: middle; font-family: sans-serif;">'
//                    . 'Gerencia Corporativa de Planificación Estratégica y Nuevos Desarrollos'
//                    . '</div>';
            $this->Line(15, 198, 265, 198, $lineRed);
//            $this->Image($logoministerio, 15, 193, 75, 10, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//            $this->Image($logoeslogan, 225, 193, 40, 10, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->Text(140, 200, $text);
//            $this->writeHTMLCell(100, 10, 105, 200, $html);
        }

//        $footer = '<div style="text-align: rigth; margin-top: 100px; margin-left: 50px">'                
//                . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages()                
//                . '</div>';
////                . '<span style="color: #bb0707; font-size: 1.3em;font-weight: bold;font-variant: small-caps;">' . $this->footerText . '</span><br><span>' . $this->trans('pequiven_seip.pdf.pageFooter', array('%page%' => $this->getAliasNumPage(), '%totalPage%' => $this->getAliasNbPages()), 'PequivenSEIPBundle') . '</span></div>';
//        $this->writeHTML($footer);
        //);
        //Línea HR
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
