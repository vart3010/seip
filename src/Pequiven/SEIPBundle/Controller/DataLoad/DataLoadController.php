<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller\DataLoad;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Controlador de carga de datos
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class DataLoadController extends Controller
{
    public function indexAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        return $this->render("PequivenSEIPBundle:DataLoad:DataLoad/index.html.twig");
    }
}
