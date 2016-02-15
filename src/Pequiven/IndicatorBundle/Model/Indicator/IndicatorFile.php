<?php

/**
 * @author Victor Tortolero <vart10.30@gmail.com>
 */

namespace Pequiven\IndicatorBundle\Model\Indicator;

use Doctrine\ORM\Mapping as ORM;

/**
 * modelo de files indicator
 *
 * @author Victor Tortolero <vart10.30@gmail.com>
 */
abstract class IndicatorFile {

    const NAME_FILE = "IMG_";
    const LOCATION_UPLOAD_FILE = "uploads/documents/indicator_img";

//TODO: Investigar para colocarlo en esta varaible, los tipos de archivos permitidos, y colocarlo por el administrador
//    protected $type_file = array("pdf");

    static function getTypesFile() {
        return array("jpg");
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
