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
}
