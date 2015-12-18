<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Servicio para exportar fusionchart como imagen (pequiven_seip.service.fusion_chart)
 */
class FusionChartExportService extends ContainerAware 
{   

// List the default exportParameter values taken if not provided by chart
public $defaultParameterValues = array(
    "exportfilename" => "FusionCharts",
    "exportaction" => "download",
    "exporttargetwindow" => "_self",
    "exportformat" => "PNG"
);

public $notices = "";

public $exportRequestStream;

public $exportData;

public $exporterResource;

public $exportObject;

public $exportedStatus;

    public function exportFusionChart($post) {
        
        define("SAVE_PATH", "php-export-handler/ExportedImages/");
    
        define("HTTP_URI", "ExportedImages/");
        
        define("EXPORT_HANDLER", "FCExporter_");
    
        define("HANDLER_ASSOCIATIONS", "RLE:PDF=PDF;JPEG=IMG;JPG=IMG;PNG=IMG;GIF=IMG|SVG:SVG=ALL;PDF=ALL;JPEG=ALL;JPG=ALL;PNG=ALL;GIF=ALL");
    
        define( "MIME_TO_FORMAT", "image/jpg=jpg;image/jpeg=jpg;image/gif=gif;image/png=png;application/pdf=pdf;image/svg+xml=svg" );
    
        define("RESOURCE_PATH", "Resources/");
    
        define("OVERWRITEFILE", true);
        define("INTELLIGENTFILENAMING", true);
        define("FILESUFFIXFORMAT", "TIMESTAMP"); // value can be either 'TIMESTAMP' or 'RANDOM';
        define("MIMETYPES", "jpg=image/jpeg;jpeg=image/jpeg;gif=image/gif;png=image/png;pdf=application/pdf;svg=image/svg+xml");
        define("EXTENSIONS", "jpg=jpg;jpeg=jpg;gif=gif;png=png;pdf=pdf;svg=svg");

        define('TEMP_PATH', 'temp/');
        define('INKSCAPE_PATH', '/usr/bin/inkscape');
        define('CONVERT_PATH', '/usr/bin/convert'); // imagemagic
        
        $type = $post['charttype'];
        $this->exportRequestStream = $post;
        $this->exportData = $this->parseExportRequestStream($this->exportRequestStream);
        $this->exporterResource = $this->getExporter($this->exportData ['parameters'] ["exportformat"], $this->exportData ["streamtype"]);
    //    
//        if (!@include( $this->exporterResource )) {
//            raise_error(404, true);
//        }
    //    
        $this->exportObject = $this->exportProcessor($this->exportData ['stream'], $this->exportData ['meta'], $this->exportData ['parameters'], $type);
        if(strlen($this->exportObject) > 0){
            return $this->exportObject;
        } else{
            return false;
        }
    //    
        $this->exportedStatus = $this->outputExportObject($this->exportObject, $this->exportData ['parameters']);
        
        $response = $this->flushStatus($this->exportedStatus, $this->exportData ['meta']);
        
        if(count($response) > 0){
            $resp = explode('=',$response[5]);
            if($resp[1] == "success"){
                return true;
            } else{
                return false;
            }
        } else{
            return false;
        }
    }
    
    function parseExportRequestStream($exportRequestStream) {
    // Check for SVG
    $exportData ['streamtype'] = strtoupper(@$exportRequestStream ['stream_type']);
    // backward compatible SVG stream type detection
    if (!$exportData ['streamtype']) {
        if (@$exportRequestStream ['svg']) {
            $exportData ['streamtype'] = "SVG";
        }
        else {
        	//raise error as this export handler only accepts SVG as the input stream.
            $this->raise_error("Invalid input stream type. Only SVG is accepted.");
        }
    }

    // get string of compressed/encoded image data
    // halt with error message  if stream is not found
    $exportData ['stream'] = (string)@$exportRequestStream ['stream']
            or $exportData ['stream'] = (string)@$exportRequestStream ['svg'] // backward compatible
            or $this->raise_error(100, true);

    // get all export related parameters and parse to validate and process these
    // add notice if 'parameters' is not retrieved. In that case default values would be taken
    if (!@$exportRequestStream['parameters'])
        $this->raise_error(102);

    // parse parameters
    $exportData ['parameters'] = $this->parseExportParams(@$exportRequestStream ['parameters'], @$exportRequestStream);
    $exportData ['parameters'] ["exportformat"] = strtoupper(@$exportData ['parameters'] ["exportformat"]);

    // get width and height of the chart
    // halt with error message  if width/height is/are not retrieved
    $exportData ['meta']['width'] = (int) @$exportRequestStream ['meta_width']
            or $exportData ['meta']['width'] = (int) @$exportRequestStream ['width'] // backward compatible
            or $this->raise_error(101);
    $exportData ['meta']['height'] = (int) @$exportRequestStream ['meta_height']
            or $this->raise_error(101);

    // get background color of chart
    // add notice if background color is not retrieved
    $exportData ['meta']['bgColor'] = @$exportRequestStream ['meta_bgColor'];

    // chart DOMId
    $exportData ['meta']['DOMId'] = @$exportRequestStream ['meta_DOMId'];

    // return collected and processed data    
    return $exportData;
}

/**
 *  Parse export 'parameters' string into an associative array with key => value elements.
 *  Also sync default values from $defaultparameterValues array (global)
 *  @param 	$strParams A string with parameters (key=value pairs) separated  by | (pipe)
 *  @return An associative array of key => value pairs
 */
function parseExportParams($strParams, $exportRequestStream = array()) {
    // get global definition of default parameter values
    global $defaultParameterValues;

    // split string into associative array of [export parameter name => value ]
    $params = $this->bang($strParams, array("|", "="));

    $exportFilename = @$params['exportfilename'];
    $exportFormat = @$params['exportformat'];

     // backward compatible setting to get filename
    if (!$exportFilename) {
        $exportFilename = (string)@$exportRequestStream["filename"];
        if ($exportFilename) {
            $params['exportfilename'] = $exportFilename;
        }
    }
    // backward compatible setting to get exportFormat through mimetype
    if (!$exportFormat) {

        $mimeType = strtolower((string)@$exportRequestStream["type"]);
		$mimeList =$this->bang( @MIME_TO_FORMAT );

        $exportFormat = $mimeList[$mimeType];

        if ($exportFormat) {
           $params['exportformat'] = $exportFormat;
        }
        else {
           $params['exportformat'] = 'png';
        }
    }

    if (is_array($defaultParameterValues)) {
        // sync with default values
        $params = $params + $defaultParameterValues;
    }

    // return parameters' array
    return $params;
}

/**
 *  Builds and returns a path of the Export Resource PHP file needed to
 * 	export the chart to the format specified as parameter.
 *  @param	$strFormat (string) export format specified form chart
 *  @return A path (string) containing the Export Resource PHP file
 * 			for the specified format
 */
function getExporter($strFormat, $streamtype = "RLE") {

    // get array of [format => handler suffix ] from HANDLER_ASSOCIATIONS
    $associationCluster = $this->bang(HANDLER_ASSOCIATIONS, array('|', ':'), true);
    $associations = $this->bang(@$associationCluster[$streamtype], array(";", "="), true);

    // validate and decide on proper suffix form the $associations array
    // if not found take the format as suffix of the Export Resource
    $exporterSuffix = (@$associations [$strFormat]);
    if (!$exporterSuffix) {
        $exporterSuffix = strtoupper($strFormat);
    }

    // build Export Resource PHP file path
    // Add resource path (constant), Export handler (constant) and export suffix
    $path = RESOURCE_PATH . EXPORT_HANDLER . strtoupper($streamtype) . "2{$exporterSuffix}.php";

    return $path;
}

#### ------------------------ OUTPUT EXPORT FILE -------------------------------- ####

/**
 *  Checks whether the export action is download or save.
 *  If action is 'download', send export parameters to 'setupDownload' function.
 *  If action is not-'download', send export parameters to 'setupServer' function.
 *  In either case it gets exportSettings and passes the settings along with
 *  processed export binary (image/PDF) to the output handler function if the
 *  export settings return a 'ready' flag set to 'true' or 'download'. The export
 *  process would stop here if the action is 'download'. In the other case,
 *  it gets back success status from output handler function and returns it.
 *
 *  @param  $exportObj      An export binary/object of mixed type (image/PDF)
 *  @param  $exportParams   An array of export parameters
 *  @return                 export success status ( filename if success, false if not)
 */
function outputExportObject($exportObj, $exportParams) {

    $exportParams['exporttargetwindow'] = '_self';
    // checks whether the export action is 'download'
    $isDownload = strtolower($exportParams ["exportaction"]) == "download";
    // dynamically call 'setupDownload' or 'setupServer' as per export action
    // pass export paramters and get back export settings in an array
    $exportActionSettings = $this->setupServer($exportParams['exportfilename'], $exportParams['exportformat']); //call_user_func('setup' . ($isDownload ? 'Download' : 'Server'), $exportParams['exportfilename'], $exportParams['exportformat'], $exportParams['exporttargetwindow']);
    // check whether export setting gives a 'ready' flag to true/'download'
    // and call output handler
    // return status back (filename if success, false if not success )
    return ( @$exportActionSettings ['ready'] ? $this->exportOutput($exportObj, $exportActionSettings, 1) : false );
}

/**
 *  Flushes exported status message/or any status message to the chart or the output stream on error
 *  It parses the exported status through parser function parseExportedStatus,
 *  builds proper response string using buildResponse function and flushes the response
 *  string to the output stream and terminates the program.
 *  @param  $status     exported status ( false if failed/error, filename as string if success)
 *          $meta       array containing meta descriptions of the chart like width, height
 *          $msg        custom message to be added as statusMessage
 *
 */
function flushStatus($status, $meta, $msg = '') {
//    return $this->buildResponse($this->parseExportedStatus($status, $meta, $msg));
    return $this->parseExportedStatus($status, $meta, $msg);
}

/**
 *  Parses the exported status and builds an array of export status information. As per
 *  status it builds a status array which contains statusCode (0/1), statusMesage, fileName,
 *  width, height, DOMId and notice in some cases.
 *  @param  $status     exported status ( false if failed/error, filename as stirng if success)
 *          $meta       array containing meta descriptions of the chart like width, height and DOMId
 *          $msg        custom message to be added as statusMessage
 *  @return             array of status information
 */
function parseExportedStatus($status, $meta, $msg = '') {
    // get global 'notice' variable
    global $notices;
    global $exportData;

    // add notice
    if ($notices)
        $arrStatus [] = "notice=" . @$notices;

    // Add DOMId
    $arrStatus [] = "DOMId=" . @$meta["DOMId"];

    // add file URI , width and height when status success
    // provide 0 as width and height on failure
    $arrStatus [] = "height=" . ( @$status ? @$meta ['height'] : 0 );
    $arrStatus [] = "width=" . ( @$status ? @$meta ['width'] : 0 );
    $arrStatus [] = "fileName=" . ( @$status ? ( preg_replace('/([^\/]$)/i', '${1}/', HTTP_URI) . @$status ) : "" );

    // add status message . Priority 1 is a custom message if provided
    $arrStatus [] = "statusMessage=" . ( trim(@$msg) ? @$msg :
                    ( $status ? "success" : "failure" ));
    // add statusCode to 1 on success
    $arrStatus [] = "statusCode=" . ( @$status ? "1" : "0" );

    // return status information
    return $arrStatus;
}

/**
 *  Builds response from an array of status information. Each value of the array
 *  should be a string which is one [key=value ] pair. This array are either joined by
 *  a & to build a querystring (to pass to chart) or joined by a HTML <BR> to show neat
 *  and clean status informaton in Browser window if download fails at the processing stage.
 *
 *  @param   $arrMsg    Array of string containing status data as [key=value ]
 *  @return             A string to be written to output stream
 */
function buildResponse($arrMsg) {
    // access global variable to get export action
    global $exportData;

    // check whether export action is download. If so the response output would be at browser
    // i.e. the output format would be HTML
    $isHTML = ( ( $exportData ['parameters']['exportaction'] ) != null ? (strtolower(
                            $exportData ['parameters']['exportaction']) == "download" ) : true );


    // If the output format is not HTML then start building a quertstring hence start with a &
    $msg = ( $isHTML ? "" : "&" );
    // join all status data from array using & or <BE> as per export action
    // Joining with & would convert the string into a querystring as each element already contains
    // key=value.
    $msg .= implode(( $isHTML ? "<BR>" : "&"), $arrMsg);

    // return response
    return $msg;
}

/**
 *  check server permissions and settings and return ready flag to exportSettings
 *  @param  $exportFile     Name of the new file to be created
 *  @param  $exportType     Export type
 *  @param  $target         target window where the download would happen [ Not required here ]
 *  @return     An array containing exportSettings and ready flag
 */
function setupServer($exportFile, $exportType, $target = "_self") {
    // get extension related to specified type
    $ext = '.' . $this->getExtension(strtolower($exportType));

    // set export type
    $retServerStatus ['type'] = $exportType;

    // assume that server is ready
    $retServerStatus['ready'] = true;

    // process SAVE_PATH : the path where export file would be saved
    // add a / at the end of path of / is absent at the end
    $path = preg_replace('/([^\/]$)/i', '${1}/', SAVE_PATH);
    // check whether directory exists
    // raise error and halt execution if directory does not exists
    $fe = file_exists(realpath($path)) or $this->raise_error(" Server Directory does not exist.", true);

    // check if directory is writable or not
    $dirWritable = is_writable(realpath($path));
    shell_exec("chmod 777 -R ".realpath($path)."/*");

    // build filepath
    $retServerStatus ['filepath'] = realpath($path) . '/' . $exportFile . $ext;

    // check whether file exists
    if (!file_exists($retServerStatus ['filepath'])) {
        // need to create a new file if does not exists
        // need to check whether the directory is writable to create a new file
        if ($dirWritable) {
            // if directory is writable return with ready flag
            return $retServerStatus;
        } else {
            // if not writable halt and raise error
            $this->raise_error(403, true);
        }
    }

    // add notice that file exists
    $this->raise_error(" File already exists.");

    //if overwrite is on return with ready flag
    if (OVERWRITEFILE) {
        // add notice while trying to overwrite
        $this->raise_error(" Export handler's Overwrite setting is on. Trying to overwrite.");

        // see whether the existing file is writable
        // if not halt raising error message
        $iw = is_writable($retServerStatus ['filepath']) or
                $this->raise_error(" Overwrite forbidden. File cannot be overwritten.", true);

        // if writable return with ready flag
        return $retServerStatus;
    }

    // raise error and halt execution when overwrite is off and intelligent naming is off
    if (!INTELLIGENTFILENAMING)
        $this->raise_error(" Export handler's Overwrite setting is off. Cannot overwrite.", true);

    $this->raise_error(" Using intelligent naming of file by adding an unique suffix to the exising name.");
    // Intelligent naming
    // generate new filename with additional suffix
    $retServerStatus ['filepath'] = realpath($path) . '/' . $exportFile . "_" . generateIntelligentFileId() . $ext;

    // return intelligent file name with ready flag
    // need to check whether the directory is writable to create a new file
    if ($dirWritable) {
        // if directory is writable return with ready flag
        // add new filename notice
        raise_error(" The filename has changed to " . basename($retServerStatus ['filepath']) . '.');
        return $retServerStatus;
    } else {
        // if not writable halt and raise error
        raise_error(403, true);
    }

    // in any unknown case the export should not execute
    $retServerStatus ['ready'] = false;
    raise_error(" Not exported due to unknown reasons.");
    return $retServerStatus;
}

/**
 *  setup download headers and return ready flag to exportSettings
 *  @param  $exportFile     Name of the new file to be created
 *  @param  $exportType     Export type
 *  @param  $target         target window where the download would happen (_self/_blank/_parent/_top/window name)
 *  @return     An array containing exportSettings and ready flag
 */
function setupDownload($exportFile, $exportType, $target = "_self") {

    $exportType = strtolower($exportType);

    // get mime type list parsing MIMETYPES constant declared in Export Resource PHP file
    $mimeList = $this->bang(@MIMETYPES);

    
    // get the associated extension for the export type
    $ext = getExtension($exportType);

    // set content-type header
    header('Content-type:' . $mimeList [$exportType]);

    // set content-disposition header
    // when target is _self the type is 'attachment'
    // when target is other than self type is 'inline'
    // NOTE : you can comment this line in order to replace present window (_self) content with the image/PDF
    header('Content-Disposition: ' . ( strtolower($target == "_self") ? "attachment" : "inline" ) . '; filename="' . $exportFile . '.' . $ext . '"');
    
    // return exportSetting array. Ready should be set to download
    return array('ready' => 'download', "type" => $exportType);
}

/**
 *  gets file extension checking the export type.
 *  @param  $exportType     (string) export format
 *  @return file extension as string
 */
function getExtension($exportType) {

    // get an associative array of [type=> extension]
    // from EXTENSIONS constant defined in Export Resource PHP file
    $extensionList = $this->bang(@EXTENSIONS);
    $exportType = strtolower($exportType);

    // if extension type is present in $extensionList return it, otherwise return the type
    return ( @$extensionList [$exportType] ? $extensionList [$exportType] : $exportType );
}

/**
 *  generates a file suffix for a existing file name to apply intelligent
 *  file naming
 *  @return 	a string containing UUID and random number /timestamp
 */
function generateIntelligentFileId() {
    //generate UUID
    $UUID = md5(uniqid(rand(), true));

    // chck for additional suffix : timestamp or random
    // accrodingly add random number ot timestamp
    $UUID .= '_' . ( strtolower(FILESUFFIXFORMAT) != "timestamp" ? rand() :
                    date('dmYHis') . '_' . round(microtime(true) - floor(microtime(true)), 2) * 100
            );

    return $UUID;
}

/**
 *  Helper function that splits a string containing delimiter separated key value pairs
 *  into associative array
 *  @param 	$str	(string) delimiter separated key value pairs
 *  @param  $delimiterList	an Array whose first element is the delimiter and the
 * 							second element can be anything which separates key from value
 *
 *  @return An associative array with key => value
 */
function bang($str, $delimiterList = array(";", "="), $retainPropertyCase = false) {

    if (!$delimiterList) {
        $delimiterList = array(";", "=");
    }

    $retArray = array();
    // split string as per first delimiter
    $tmpArray = explode($delimiterList[0], $str);
    // iterate through each element of split string
    for ($i = 0; $i < count($tmpArray); $i++) {
        // split each element as per second delimiter
        $tmp2Array = explode($delimiterList[1], $tmpArray[$i], 2);
        if ($tmp2Array[0] && $tmp2Array[1]) {
            // if the secondary split creats at-least 2 array elements
            // make the fisrt element as the key and the second as the value
            // of the resulting array
            $retArray[$retainPropertyCase ? $tmp2Array[0] : strtolower($tmp2Array[0])] = $tmp2Array[1];
        }
    }
    return $retArray;
}

/**
 *  Error reporter function that has a list of error messages. It can terminate the execution
 *  and send successStatus=0 along with a error message. It can also append notice to a global variable
 *  and continue execution of the program.
 *  @param      $code   error code as Integer (referring to the index of the errMessages
 *                      array containing list of error messages)
 *                      OR, it can be a string containing the error message/notice
 *  @param      $halt   (boolean) Whether to halt execution
 */
function raise_error($code, $halt = false) {

    // access global notice storage
    global $notices;

    //list of error messages
    $errMessages [100] = " Insufficient data.";
    $errMessages [101] = " Width/height not provided.";
    $errMessages [102] = " Insufficient export parameters.";
    $errMessages [400] = " Bad request.";
    $errMessages [401] = " Unauthorized access.";
    $errMessages [403] = " Directory write access forbidden.";
    $errMessages [404] = " Export Resource not found.";


    // take $code as error message  if $code is string
    // if $code is present as index of errorMessages array, take the value of the element
    // take Error! only when all fails
    $err_message = is_string($code) ? $code :
            ( @$errMessages [$code] ? $errMessages [$code] : "statusMessage=ERROR!" );

    // If halt is true stop execution and send response back to chart/output stream
    if ($halt) {
        $this->flushStatus(false, '', $err_message);
    } else {
        // otherwise add the message into global notice repository
        $notices .= $err_message;
    }
}
function exportProcessor($stream, $meta, $exportParams, $type) {
    
    // get mime type list parsing MIMETYPES constant declared in Export Resource PHP file
    $ext = strtolower($exportParams["exportformat"]);

    $ext2 = '';
    $mimeList = $this->bang(@MIMETYPES);
    $mimeType = $mimeList[$ext];
    
    // prepare variables
    if (get_magic_quotes_gpc()) {
        $stream = stripslashes($stream);
    }

    //Creación nombre de Archivo relacionado al usuario que consulta
    $user = $this->getUser()->getId();//Id Usuario    
    $user = str_pad($user, 6,"0", STR_PAD_LEFT);
    $cadena = $user."-".md5(rand())."-".$type;
    
    // create a new export data    
    $tempFileName = $cadena;
    
    if ('jpeg' == $ext || 'jpg' == $ext) {
        $ext = 'png';
        $ext2 = 'jpg';
    }

    $tempInputSVGFile =  $this->container->getParameter('kernel.root_dir')."/../web/php-export-handler/" . TEMP_PATH . "{$tempFileName}.svg";
    
    $tempOutputFile = $this->container->getParameter('kernel.root_dir')."/../web/php-export-handler/" . TEMP_PATH . "{$tempFileName}.{$ext}";
    
    $tempOutputJpgFile = realpath(TEMP_PATH) . "/{$tempFileName}.jpg";
    $tempOutputPngFile = realpath(TEMP_PATH) . "/{$tempFileName}.png";        
         

    if ($ext != 'svg') {
        
        // width format for batik
        $width = @$meta['width'];
        $height = @$meta['height'];

        $size = '';
        if (!empty($width) && !empty($height)) {
            $size = "-w {$width} -h {$height}";
        }
        // override the size in case of pdf output
        if ('pdf' == $ext) {
            $size = '';
        }

        //batik bg color format
        $bg = @$meta['bgColor'];
        if ($bg) {
            $bg = " --export-background=".$bg;
        }

        $nameSVG = '';
        
        $routingTemp = $this->container->getParameter('kernel.root_dir')."/../web/php-export-handler/*";

        // generate the temporary file
        if (!file_put_contents($tempInputSVGFile, $stream)) {
            die("Couldn't create temporary file. Check that the directory permissions for
            the " . TEMP_PATH . " directory are set to 777.");
        } else{
            $nameSVG = "{$tempFileName}.svg";
        }        
        
        $nameTemp = $nameSVG;        
        //return $nameSVG;
        // do the conversion
        $width = 950;
        $height = 750;
        $size = "-w {$width} -h {$height}";
        $command = INKSCAPE_PATH . "$bg --without-gui {$tempInputSVGFile} --export-{$ext} $tempOutputFile {$size}";
        $output = shell_exec($command);        
        //shell_exec("chmod -R 777".$ext.$tempOutputFile);
        
        if ('jpg' == $ext2) {
            $comandJpg = CONVERT_PATH . " -quality 100 $tempOutputFile $tempOutputJpgFile";
            $tempOutputFile = $tempOutputJpgFile;

            $output .= shell_exec($comandJpg);
        }

        shell_exec("rm $tempInputSVGFile");
        
        $nameSVG = $tempOutputFile;                
        //return $nameSVG;

        // catch error
        if (!is_file($tempOutputFile) || filesize($tempOutputFile) < 10) {
            $return_binary = $output;
            $this->raise_error($output, true);
        }
        // stream it
        else {
            $return_binary = file_get_contents($tempOutputFile);
        }
        // delete temp files
        /*if (file_exists($nameTemp)) {
            unlink($nameTemp);            
        }
        if (file_exists($tempOutputFile)) {
            unlink($tempOutputFile);
        }
        if (file_exists($tempOutputPngFile)) {
            unlink($tempOutputPngFile);
        }*/
        
        return $nameSVG;

    // SVG can be streamed back directly
    } else if ($ext == 'svg') {
      
       // width format for batik
        $width = @$meta['width'];
        $height = @$meta['height'];

        $size = '';
        if (!empty($width) && !empty($height)) {
            $size = "-w {$width} -h {$height}";
        }
        // override the size in case of pdf output
        if ('pdf' == $ext) {
            $size = '';
        }

        //batik bg color format
        $bg = @$meta['bgColor'];
        if ($bg) {
            $bg = " --export-background=".$bg;
        }

        $nameSVG = '';
        // generate the temporary file
        if (!file_put_contents($tempInputSVGFile, $stream)) {
            die("Couldn't create temporary file. Check that the directory permissions for
            the " . TEMP_PATH . " directory are set to 777.");
        } else{
            $nameSVG = "{$tempFileName}.svg";
        }
        
        shell_exec("chmod -R 777".$this->container->getParameter('kernel.root_dir')."/../web/php-export-handler/*");

        //return $nameSVG;
        // do the conversion
        $command = INKSCAPE_PATH . "$bg --without-gui {$tempInputSVGFile} --export-{$ext} $tempOutputFile {$size}";
        $output = shell_exec($command);
        shell_exec("chmod -R 777".$ext.$tempOutputFile);
        
        return $nameSVG;
        //return $tempOutputFile;//Dirección completa con svg        
        
        if ('svg' == $ext2) {
            $comandJpg = CONVERT_PATH . " -quality 100 $tempOutputFile $tempOutputJpgFile";
            $tempOutputFile = $tempOutputJpgFile;

            $output .= shell_exec($comandJpg);
        }
        
        // catch error
        if (!is_file($tempOutputFile) || filesize($tempOutputFile) < 10) {
            $return_binary = $output;
            $this->raise_error($output, true);
        }
        // stream it
        else {
            $return_binary = file_get_contents($tempOutputFile);
        }

        // delete temp files
        if (file_exists($tempInputSVGFile)) {
            unlink($tempInputSVGFile);
        }
        if (file_exists($tempOutputFile)) {
            unlink($tempOutputFile);
        }
        if (file_exists($tempOutputPngFile)) {
            unlink($tempOutputPngFile);
        }
        // stream it
        else {
            $return_binary = file_get_contents($tempOutputFile);
        }
        //$return_binary = $stream;
    } else {
        $this->raise_error("Invalid Export Format.", true);
    }
    // return export ready binary data
    return @$return_binary;
}

/**
 *  exports (save/download) SVG to export formats.
 *  @param	$exportObj 		(mixed) binary/objct exported by exportProcessor
 * 	@param	$exportSettings	(array) various server-side export settings stored in keys like
 * 					"type", "ready" "filepath" etc. Required for 'save' expotAction.
 * 					For 'download' action "filepath" is blank (this is checked to find
 * 					whether the action is "download" or not.
 * 	@param	$quality		(integer) quality factor 0-1 (1 being the best quality). As of now we always pass 1.
 *
 *  @return 				false is fails. {filepath} if succeeds. Only returned when action is 'save'.
 */
function exportOutput($exportObj, $exportSettings, $quality = 1) {

    // calls svgparser function that saves/downloads binary
    // store saving status in $doneExport which receives false if fails and true on success
    $doneExport = $this->filesaver($exportObj, @$exportSettings ['filepath']);

    // check $doneExport and if true sets status to {filepath}'s value
    // set false if fails
    $status = ( $doneExport ? basename(@$exportSettings ['filepath']) : false );

    // return status
    return $status;
}

/**
 *  emulates imagepng/imagegif/imagejpeg. It saves data to server
 *  @param	$exportObj 	(resource) binary exported by exportProcessor
 *  @param	$filepath	(string) Path where the exported is to be stored
 *                              when the action is "download" it is null.
 *
 *  @return     (boolean) false is fails. true if succeeds. Only returned when action is 'save'.
 */
function filesaver($exportObject, $filepath) {

    // when filepath is null the action is 'download'
    // hence write the  bimary to response stream and immediately terminate/close/end stream
    // to prevent any garbage that might get into response and corrupt the  binary
    if (!@$filepath)
        die($exportObject);

    // open file path in write mode
    $fp = @fopen($filepath, "w");

    if ($fp) {
        // write  binary
        $status = @fwrite($fp, $exportObject);
        //close file
        $fc = @fclose($fp);
    }

    // return status
    return (bool) @$status;
}

/**
 * Converts Hex color values to rgb
 *
 * @param string $h Hex values
 * @param string $sep rgb value separator
 * @return string
 */
function hex2rgb($h, $sep = "") {
    $h = str_replace("#", "", $h);

    if (strlen($h) == 3) {
        $r = hexdec(substr($h, 0, 1) . substr($h, 0, 1));
        $g = hexdec(substr($h, 1, 1) . substr($h, 1, 1));
        $b = hexdec(substr($h, 2, 1) . substr($h, 2, 1));
    } else {
        $r = hexdec(substr($h, 0, 2));
        $g = hexdec(substr($h, 2, 2));
        $b = hexdec(substr($h, 4, 2));
    }
    $rgb = array($r, $g, $b);
    if ($sep) {
        $rgb = implode($sep, $rgb);
    }
    return $rgb;
}

    /**
     * Get a user from the Security Context
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @see Symfony\Component\Security\Core\Authentication\Token\TokenInterface::getUser()
     */
    protected function getUser() {
        if (!$this->container->has('security.context')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.context')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }
}
