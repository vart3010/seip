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

class NewSeipPdf extends TCPDF implements ContainerAwareInterface {

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
        $logopqv = $this->generateAsset('bundles/pequivenseip/logotipos-pqv/logotipos-pdf/Logo_Pequiven.jpg'); //K_PATH_IMAGES.'logo_example.jpg';
        $logoseip = $this->generateAsset('bundles/pequivenseip/logotipos-pqv/logotipos-pdf/Logo_Seip.jpg'); //K_PATH_IMAGES.'logo_example.jpg';
        $tittle = $this->title;
        $period = $this->period->getDescription();


        // Set font
        $this->SetFont('helvetica', 'B', 8);
        $this->SetTextColor(0, 0, 0);
        // Title
        $text = '
        <table width="100%">
            <tr>
                <td width="60%"><img src="'.$logopqv .'" width=150 height=25></td>
                <td width="30%" style="text-align: rigth;"><br><br><br>Sistema Estadístico de Información Petroquímica</td>
                <td width="10%"><img src="'.$logoseip.'" width=5 height=5></td>
            </tr>
        </table>
        
        <table width="100%">
            <tr>
                <td width="100%" style="text-align: center; font-size: large">'.$tittle.' - '.$period.'</td>
            </tr>
        </table>
        <br>';
        $this->writeHTML($text);
        // Logo Pqv
//        $this->Image($image_file, 190, 13, 15, 15, 'jpg', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Línea HR
//        $lineRed = array('width' => 1.0, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
//        $this->Line(0, 27, 300, 27, $lineRed);
    }

    // Footer del pdf de resultados
    public function Footer() {
        // Position at 27 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
//        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        $footer = '<div align="center"><span style="color: red;font-size: 1.3em;font-weight: bold;font-variant: small-caps;">' . $this->footerText . '</span><br><span>' . $this->trans('pequiven_seip.pdf.pageFooter', array('%page%' => $this->getAliasNumPage(), '%totalPage%' => $this->getAliasNbPages()), 'PequivenSEIPBundle') . '</span></div>';
        $this->writeHTML($footer);

        //Línea HR
        $lineRed = array('width' => 1.0, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
        if ($this->printLineFooter === true) {
            $this->Line(0, 190, 300, 190, $lineRed);
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
