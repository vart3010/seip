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
                <td width="60%"><img src="'.$logopqv .'" width="500px" height="100px"></td>
                <td width="30%" style="text-align: rigth; padding: 20px;"><br><br><br>Sistema Estadístico de Información Petroquímica</td>
                <td width="10%" style="text-align: rigth;"><br><br><img src="'.$logoseip.'" width="50px" height="50px"></td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <td width="100%" style="text-align: center; font-size: 12; color: #bb0707;">'.$tittle.'. '.$period.'</td>
            </tr>
        </table>
        ';
        $this->writeHTML($text);

    }

    // Footer del pdf de resultados
    public function Footer() {
        // Position at 27 mm from bottom
        $this->SetY(-15);        
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        $logoeslogan = $this->generateAsset('bundles/pequivenseip/logotipos-pqv/logotipos-pdf/Eslogan.jpg'); //K_PATH_IMAGES.'logo_example.jpg';
        // Page number

        $footer = '<table width="100%">'                
                    . '<tr>'
                       
                        . '<td width="85%" style="text-align: center; font-size: 10; font-weight: bold; color: #bb0707;">'.$this->footerText.'</td>'
                        . '<td width="15%" style="text-align: rigth;">'.$this->getAliasNumPage().' de '.$this->getAliasNbPages(). '</td>'
                    . '</tr>'
                . '</table>';                
//                . '<span style="color: #bb0707; font-size: 1.3em;font-weight: bold;font-variant: small-caps;">' . $this->footerText . '</span><br><span>' . $this->trans('pequiven_seip.pdf.pageFooter', array('%page%' => $this->getAliasNumPage(), '%totalPage%' => $this->getAliasNbPages()), 'PequivenSEIPBundle') . '</span></div>';
        $this->writeHTML($footer);

        //Línea HR
        $lineRed = array('width' => 1.0, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(187, 7, 7));
        $this->Line(0, 280, 300, 280, $lineRed);
        if ($this->printLineFooter === true) {
            
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
