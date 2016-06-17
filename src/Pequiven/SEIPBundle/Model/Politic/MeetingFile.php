<?php

namespace Pequiven\SEIPBundle\Model\Politic;

use Doctrine\ORM\Mapping as ORM;
use Pequiven\SEIPBundle\Model\BaseModel;

/**
 * Modelo de las propuestas del círculo de estudio de trabajo
 * @author Victor Tortolero vart10.30@gmail.com
 */
abstract class MeetingFile {

    const NAME_FILE = "CET_";
    const LOCATION_UPLOAD_FILE = "uploads/documents/cet_files";

//TODO: Investigar para colocarlo en esta varaible, los tipos de archivos permitidos, y colocarlo por el administrador
//    protected $type_file = array("pdf");

    static function getTypesFile() {
        return array("pdf");
    }

    public function getUploadRootDir() {
        // the absolute directory path where uploaded
        // documents should be saved
        return basename(__DIR__);
    }

    static function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return self::LOCATION_UPLOAD_FILE;
    }

}
