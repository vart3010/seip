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

class SeipPdf extends TCPDF implements ContainerAwareInterface{
    /**
     * @var ContainerInterface
     *
     * @api
     */
    private $container;
    
    
    //Page header
    public function Header() {
        // Logo SEIP
        $image_file = $this->generateAsset('bundles/pequivenseip/logotipos-pqv/logo_menu_seip.png'); //K_PATH_IMAGES.'logo_example.jpg';
        $this->Image($image_file, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        $this->SetTextColor(255,0,0);
        // Title
        $this->Cell(0, 15, $this->title, 0, false, 'C', 0, '', 0, false, 'T', 'T');
        // Logo Pqv
        $image_file = $this->generateAsset('bundles/pequivenseip/logotipos-pqv/logo_pqv2.gif'); //K_PATH_IMAGES.'logo_example.jpg';
        $this->Image($image_file, 180, 10, 15, '', 'GIF', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
    
    /**
     * Seteamos el título del documento
     * @param type $title
     */
    public function setTitle($title = ''){
        $this->title = $title;
    }
    
    /**
     * 
     * @return type
     */
    public function getTitle(){
        return $this->title;
    }
    
    /**
     * 
     * @param type $path
     * @param type $packageName
     * @return type
     */
    function generateAsset($path,$packageName = null){
        return $this->container->get('templating.helper.assets')
               ->getUrl($path, $packageName);
    }
    
    
    /**
     * 
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container
        ;
    }
}