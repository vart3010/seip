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

use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Exception\InvalidArgumentException;

/**
 * Description of ToolService
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class ToolService 
{
    /**
     * Retorna el ultimo dia del mes y año necesitado
     * @param type $elAnio
     * @param type $elMes
     * @return type
     */
    public static function getLastDayMonth($elAnio,$elMes) {
        return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
    }
    
    /**
     * Validates whether the given variable is a valid form name.
     *
     * @param string|int $name The tested form name.
     *
     * @throws UnexpectedTypeException  If the name is not a string or an integer.
     * @throws InvalidArgumentException If the name contains invalid characters.
     */
    public static function validateName($name)
    {
        if (null !== $name && !is_string($name) && !is_int($name)) {
            throw new UnexpectedTypeException($name, 'string, integer or null');
        }

        if (!self::isValidName($name)) {
            throw new InvalidArgumentException(sprintf(
                'El nombre "%s" contiene caracteres invalidos. El nombre debe empezar con una letra y solo debe contener letras sin caracteres especiales, ni espacios para reemplazar el espacio utilice underscores ("_").',
                $name
            ));
        }
    }
    
    /**
     * Returns whether the given variable contains a valid form name.
     *
     * A name is accepted if it
     *
     *   * is empty
     *   * starts with a letter, digit or underscore
     *   * contains only letters, digits, numbers, underscores ("_"),
     *     hyphens ("-") and colons (":")
     *
     * @param string $name The tested form name.
     *
     * @return bool Whether the name is valid.
     */
    public static function isValidName($name)
    {
        return '' === $name || null === $name || preg_match('/^[a-zA-Z0-9_]*$/D', $name);
    }
    
    /**
     * Trunca un texto
     * @param string $description
     * @param array $parameters
     * limit: 80<br/>
     * sufix: ...<br/>
     * @return string
     */
    public static function truncate($description,array $parameters = array()) 
    {
        $limit = 80;
        $sufix = '...';
        if(isset($parameters['limit'])){
            $limit = (int)$parameters['limit'];
        }
        if(isset($parameters['sufix'])){
            $sufix = $parameters['sufix'];
        }
        
        if(strlen($description) > $limit)
        {
            $description = mb_substr($description, 0,$limit,'UTF-8').$sufix;
        }
        return $description;
    }
    
    /**
     * Elimina los acentos de una cadena
     * @param type $str
     * @return type
     */
    public static function normalizeStr($str) 
    {
        $invalid = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y');
        $str = str_replace(array_keys($invalid), array_values($invalid), $str);

        return $str;
    }
    
    /**
     * Retorna los meses del año con las etiquetas
     * @return type
     */
    public static function getMonthsLabels()
    {
        $months = array();
        for($i = 1; $i <= 12; $i++){
            $months[$i] = sprintf("pequiven_seip.month.%s",$i);
        }
        return $months;
    }
    
     public function calculatePnr($plan,$real){
        $pnr = $plan - $real;
        if($pnr < 0){
            $pnr = 0;
        }
        return $pnr;
    }
    public function calculatePercentaje($plan,$real){
        $percentaje = 0;
        if($plan > 0){
            $percentaje = ($real * 100) / $plan;
        }
        return $percentaje;
    }
    
    /**
     * Formatea los decimales antes de enviar los resultados.
     * @param type $result
     * @return type
     */
    static function formatResult($result){
        return number_format($result,2);
    }
    
    
    /**
     * Buscar objetivos del programa de gestion
     * @param type $arrangementPrograms
     * @param type $objetives
     */
    static function getObjetiveFromPrograms($arrangementPrograms,&$objetives) {
        foreach ($arrangementPrograms as $arrangementProgram) {
            $objetive = null;
            if($arrangementProgram->getType() == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_OPERATIVE){
                $objetive = $arrangementProgram->getOperationalObjective();
            }elseif ($arrangementProgram->getType() == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::TYPE_ARRANGEMENT_PROGRAM_TACTIC) {
                $objetive = $arrangementProgram->getTacticalObjective();
            }
            if($objetive){
                $objetives[$objetive->getId()] = $objetive;
            }
        }
    }
    
    /**
     * Formatea la fecha antes de enviarla en la api.
     * 
     * @param type $date
     * @return type
     */
    static function formatDateTime($date) {
        $r = '';
        if(is_a($date, 'DateTime')){
            $r = $date->format('d-m-Y');
        }else{
            $r = $date;
        }
        return $r;
    }

    
}
