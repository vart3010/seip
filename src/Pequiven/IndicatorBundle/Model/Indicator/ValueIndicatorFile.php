<?php

/**
 * @author Victor Tortolero <vart10.30@gmail.com>
 */

namespace Pequiven\IndicatorBundle\Model\Indicator;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo del valor de indicador
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class ValueIndicatorFile {

    const NAME_FILE = "FICHA_";
    const LOCATION_UPLOAD_FILE = "uploads/documents/indicator_files";
    const TYPES_FILE = array("pdf");

    static function getTypesFile() {
        return self::TYPES_FILE;
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
