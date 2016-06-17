<?php

namespace Pequiven\SEIPBundle\Service\Sip;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of ApiCne
 *
 * @author Victor Tortolero vart10.30@gmail.com
 */
class ApiCneService {

    private $container;

    public function getDatosCne($ci) {
        $url = "http://www.cne.gov.ve/web/registro_electoral/ce.php?nacionalidad=V&cedula=$ci";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // almacene en una variable
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        /**
         * CONFIGURACION DE PROXY
         */
        curl_setopt($curl, CURLOPT_PROXY, "http://pqvzivprx02.pequiven.com/proxy.pac"); //your proxy url
        curl_setopt($curl, CURLOPT_PROXYPORT, "8080"); // your proxy port number 
//        curl_setopt($curl, CURLOPT_PROXYUSERPWD, "username:pass"); //username:pass 
        $cne = '';

        if (curl_exec($curl) === false) {
            echo 'Curl error: ' . curl_error($curl);
        } else {
            $cne = curl_exec($curl);

            if (strpos($cne, '<table cellpadding="2" width="530">')) {
                $bandera = true;
            } elseif (strpos($cne, '<table width="100%" border="0" cellspacing="0" cellpadding="0">')) {
                $bandera = false;
            } else {
                $bandera = false;
            }

            if ($bandera) {
                $campos = $this->ExtraerFrase('<table cellpadding="2" width="530">', '</table>', $cne);
                $cne = strip_tags(htmlspecialchars_decode($campos));
                $ci = explode('Nombre:', $cne);

                //CEDULA
                $n_ci = explode(':', $ci[0]);
                $cedula = trim($n_ci[1]);
                //NOMBRE
                $datos = explode(':', $ci[1]);
                $nombre = explode("Estado", $datos[0]);
                $nombre = trim($nombre[0]);
                //var_dump($nombre);
                //die();
                //ESTADO
                $datos = explode(':', $ci[1]);
                $estado = explode("Municipio", $datos[1]);
                $estado = trim($estado[0]);

                //MUNICPIO
                $datos = explode(':', $ci[1]);
                $mcpo = explode("Parroquia", $datos[2]);
                $mcpo = trim($mcpo[0]);

                //PARROQUIA
                $datos = explode(':', $ci[1]);
                $parroquia = explode("Centro", $datos[3]);
                $parroquia = trim($parroquia[0]);

                //DIRECCION
                $datos = explode(':', $ci[1]);
                $direccion = explode("Dirección", $datos[4]);
                $direccion = trim($direccion[0]);

                //DIRECCION
                $datos = explode(':', $ci[1]);
                $centro = trim($datos[5]);
            }
        }
        curl_close($curl);
        if (isset($cedula)) {
            return array(
                "cedula" => $cedula,
                "nombre" => $nombre,
                "estado" => $estado,
                "municipio" => $mcpo,
                "parroquia" => $parroquia,
                "direccion" => $centro,
                "centro" => $direccion
            );
        } else {
            return array(
                "cedula" => "xx",
                "nombre" => "",
                "estado" => "",
                "municipio" => "",
                "parroquia" => "",
                "direccion" => "",
                "centro" => ""
            );
        }
    }

    public function ExtraerFrase($separador1, $separador2, $cadena) {
        if (strpos($cadena, $separador1) !== false) {
            $pos = strpos($cadena, $separador1);
            $a = substr($cadena, $pos + strlen($separador1));
            if (strpos($a, $separador2) !== false) {
                $npos = strpos($a, $separador2);
                $b = substr($a, 0, $npos);
                return $b;
            } else
                return $a;
        } else
            return false;
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function getDoctrine() {
        if (!$this->container->has('doctrine')) {
            throw new LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }

}
