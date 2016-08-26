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

        // Logo CET
        $logoCET = 'bundles/pequivenseip/logotipos-pqv/logotipos-pdf/LogoCTE.png';
        $tittle = $this->title;

        // Set font
        $this->SetFont('helvetica', 'B', 8);
        $this->SetTextColor(0, 0, 0);

        $text = '<table width="100%" cellpadding="2">'
                . '<tr>'
                . '<td width="100%" style="text-align: center;">'
                . '<img src="' . $logoCET . '" width="950px" height="120px">'
                . '</td>'
                . '</tr>'
                . '<tr bgcolor="#D9D9D9">'
                . '<td width="100%" height="20px" style="text-align: center; font-size: 10pt; color: #C00000; vertical-align: middle; font-family: sans-serif;">   ' . strtr(strtoupper($tittle), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ") . '</td>'
                . '</tr>'
                . '</table>';

        $this->writeHTML($text);
    }

    // Footer del pdf de resultados
    public function Footer() {

        $this->SetFont('helvetica', 'I', 8);
        $logoeslogan = 'bundles/pequivenseip/logotipos-pqv/logotipos-pdf/Patriotas_Unidos.jpg';
        $logoministerio = 'bundles/pequivenseip/logotipos-pqv/logotipos-pdf/Ministerio.jpg';

        $margin = $this->getPageDimensions();
        $lineRed = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(193, 36, 44));
        $text = $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages();
        $html = '<div style="text-align: center; font-size: 6pt; font-weight: bold; color: #B00000; vertical-align: middle; font-family: sans-serif;">'
                . 'Gerencia Corporativa de Planificación Estratégica y Nuevos Desarrollos'
                . '</div>';

        if ($margin['or'] == 'P') {
            $html = '<p style="text-align: center; font-size: 6pt; font-weight: bold; color: #B00000; vertical-align: middle; font-family: sans-serif;">'
                    . 'Gerencia Corporativa de Planificación Estratégica y Nuevos Desarrollos'
                    . '</p>';
            $this->Line(15, 254, 200, 254, $lineRed);
            $this->Image($logoministerio, 15, 255, 75, 10, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->Image($logoeslogan, 160, 255, 40, 10, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->Text(120, 255, $text);
            $this->writeHTMLCell(60, 20, 95, 260, $html);
        } else {
            $html = '<div style="text-align: center; font-size: 8pt; font-weight: bold; color: #B00000; vertical-align: middle; font-family: sans-serif;">'
                    . 'Gerencia Corporativa de Planificación Estratégica y Nuevos Desarrollos'
                    . '</div>';
            $this->Line(15, 192, 265, 192, $lineRed);
            $this->Image($logoministerio, 15, 193, 75, 10, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->Image($logoeslogan, 225, 193, 40, 10, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->Text(150, 196, $text);
            $this->writeHTMLCell(100, 10, 105, 200, $html);
        }
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
