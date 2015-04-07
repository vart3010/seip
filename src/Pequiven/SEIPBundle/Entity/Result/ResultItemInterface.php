<?php

namespace Pequiven\SEIPBundle\Entity\Result;

/**
 * Definicion del item de los resultados
 * @author inhack20
 */
interface ResultItemInterface
{
    /**
     * Retorna el peso del item
     */
    function getWeight();
    
    /**
     * Retorna el resultado con peso
     */
    function getResultWithWeight();
    
    /**
     * Retorna el resultado del item en funcion al 100%
     */
    function getResult();
    
    /**
     * Guarda la fecha de la ultima vez que se calculo el resultado
     */
    function updateLastDateCalculateResult();
    
    /**
     * Limpia la fecha de la ultima vez que se calculo el resultado
     */
    function clearLastDateCalculateResult();
    
    /**
     * Funcion para incluir o excluir el resultado de los calculos
     */
    function isAvailableInResult();
    
    /**
     * Devuelve verdadero si el item se puede penalizar.
     */
    function isCouldBePenalized();
    
    /**
     * ¿Forzar penalizacion?
     */
    function isForcePenalize();
    
    /**
     * Resultado original (Sin ningun tipo de modificacion)
     */
    function setResultReal($resultReal);
    
    /**
     * Resultado del item
     */
    function setResult($result);
    
    /**
     * Status del item
     */
    function setStatus($status);
    
    function getStatus();
}
