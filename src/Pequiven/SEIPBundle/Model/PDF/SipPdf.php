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

class SipPdf extends TCPDF implements ContainerAwareInterface{
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
//        $image_file = $this->generateAsset('bundles/pequivenseip/logotipos-pqv/logo_circulos.png'); //K_PATH_IMAGES.'logo_example.jpg';
//        $this->Image($image_file, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 16);
        $this->SetTextColor(255,0,0);
        // Title
//        $text='<div align="center" style="font-size: 1em;color: red;">'.$this->title.'<br>'.$this->period->getDescription().'</div>';
        $text='<div align="center" style="font-size: 1em;color: red;">'.$this->title.'</div>';
        $this->writeHTML($text);
        // Logo Pqv
//        $image_file = $this->generateAsset('bundles/pequivenseip/logotipos-pqv/logo_circulos.png'); //K_PATH_IMAGES.'logo_example.jpg';
//        $this->Image($image_file, 190, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Línea HR
        $lineRed = array('width' => 1.0, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
        $this->Line(0, 27, 300, 27, $lineRed);
    }

    // Footer del pdf de resultados
    public function Footer() {
        // Position at 27 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
//        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        
        $footer = '<div align="center"><span style="color: red;font-size: 1.3em;font-weight: bold;font-variant: small-caps;">Sala de Gestión de Información Política</span><br><span>'.$this->trans('pequiven_seip.pdf.pageFooter', array('%page%' => $this->getAliasNumPage(),'%totalPage%' => $this->getAliasNbPages()),'PequivenSEIPBundle').'</span></div>';
        $this->writeHTML($footer);
        
        //Línea HR
        $lineRed = array('width' => 1.0, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
        if($this->printLineFooter === true){
            $this->Line(0, 190, 300, 190, $lineRed);
        }

    }
    
    /**
     * Servicio que setea el período
     * @param \Pequiven\SEIPBundle\Entity\Period $period
     */
    public function setPeriod(\Pequiven\SEIPBundle\Entity\Period $period){
        $this->period = $period;
    }
    
    /**
     * Texto que va en el footer
     * @param type $text
     */
    public function setFooterText($text){
        $this->footerText = $text;
    }
    
    /**
     * Servicio para generar los assets
     * @param type $path
     * @param type $packageName
     * @return type
     */
    protected function generateAsset($path,$packageName = null){
        return $this->container->get('templating.helper.assets')
               ->getUrl($path, $packageName);
    }
    
    protected function trans($id,array $parameters = array(), $domain = 'messages')
    {
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