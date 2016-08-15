<?php

namespace Pequiven\SEIPBundle\Service\DataLoad;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
class PhpExcelReaderService implements ContainerAwareInterface {

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * 
     * METODO QUE RETORNA UN VECTOR INDEXADO CON LOS VALORES PARAMETERIZADOS
     * "file"=>"test.xlsx", --> ARCHIVO
     * "sheet"=>0, --> HOJA DE DONDE SE LEERAN LOS DATOS
     * "titles"=>"A1:C1", --> RANGO DE LOS TITULOS DE LA SECCION
     * "data"=>"A2:C19" --> RANGO DE LA DATA DE LA SECCION
     * 
     * @param type $fileData
     * @return type
     */
    public function getSheetValues($fileData) {
        $secciones = array();
        $arrayData = array();

        foreach ($fileData as $seccion) {
            $obj = \PHPExcel_IOFactory::load($seccion["file"]);
            $worksheet = $obj->getSheet($seccion["sheet"]);

            $fields = $worksheet->rangeToArray($seccion["titles"]);
            #SE OBTIENEN UN ARRAY INDEXADO CON LOS DATOS
            $data = $worksheet->rangeToArray($seccion["data"]);

            $arrayData = array(
                "fields" => $fields,
                "data" => $data
            );
            $secciones[] = $arrayData;
            #array_push($arrayData, $secciones);
        }


        return $secciones;

        /*
          //$worksheet  = $objPHPExcel->setActiveSheetIndexbyName('Sheet1');
          $worksheet = $obj->getSheet($fileData["sheet"]);

          #$highestRow = $worksheet->getHighestRow(); // e.g. 10
          #$highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
          #$highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
          #OBTENER LA PAGINA COMPLETA
          #$sheetData = $objWorksheet->toArray(null, true, true, true);
          #SE OBTIENEN LA FILA DE TITULOS
          $fields = $worksheet->rangeToArray($fileData["titles"]);
          #SE OBTIENEN UN ARRAY INDEXADO CON LOS DATOS
          $data = $worksheet->rangeToArray($fileData["data"]);

          $arrayData = array(
          "fields" => $fields,
          "data" => $data
          );

          return $arrayData; */
    }

}
