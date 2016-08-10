<?php

namespace Pequiven\SEIPBundle\Service\DataLoad;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PhpExcelReaderService implements ContainerAwareInterface {

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    public function getSheetValues($filePath) {
        $obj = \PHPExcel_IOFactory::load($filePath);
        $objWorksheet = $obj->setActiveSheetIndex(2);
        $sheetData = $objWorksheet->toArray(null,true,true,true); 
        var_dump($sheetData); 
        die();
    }

}
