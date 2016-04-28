<?php

/*
 * This file is part of the TecnoCreaciones package.
 * 
 * (c) www.tecnocreaciones.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pequiven\SEIPBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controlador para probar funcionalidades
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 * @Route("/test")
 */
class TestController extends Controller  
{
    /**
     * @Route("/sendPrePlanningEmailRevision")
     * @param \Pequiven\SEIPBundle\Controller\Request $request
     */
    function sendPrePlanningEmailRevision(Request $request) 
    {
        $user = $this->getUser();
        $parameters = array(
            'user' => $user,
            'gerencia' => 'Planificacion'
        );
        $template = 'PequivenSEIPBundle:PrePlanning:Email/sendToRevision.html.twig';
        return $this->getTestResponseEmail($template,$parameters,$request);
    }
    /**
     * @Route("/sendPrePlanningEmailToDraft")
     * @param \Pequiven\SEIPBundle\Controller\Request $request
     */
    function sendPrePlanningEmailToDraft(Request $request) 
    {
        $user = $this->getUser();
        $parameters = array(
            'user' => $user,
            'gerencia' => 'Planificacion'
        );
        $template = 'PequivenSEIPBundle:PrePlanning:Email/sendToDraft.html.twig';
        return $this->getTestResponseEmail($template, $parameters, $request);
    }
    
    /**
     * @Route("/testFunction")
     */
    public function testFunctionAction()
    {
        $v = $this->getSeipConfiguration()->getEmailNotifyToRevision();
        var_dump($v);
        die;
    }


    private function getTestResponseEmail($template,array $context,\Symfony\Component\HttpFoundation\Request $request) 
    {
        $send = (boolean)$request->get('send',false);
        $recipientEmail = $request->get('recipient','inhack20@gmail.com');
        $recipient = array(
             $recipientEmail => 'Carlos Mendoza'
        );
        $debug = $request->get('debug',true);
        $from = 'seip@pequiven.com';
        $messageSend = 0;
        if($send){
            $content = $this->get('pequiven_seip.mailer.twig_swift')->renderMessage(
                $template,
                $context,
                $from,
                $recipient
            )->getBody();
            $messageSend = $this->get('pequiven_seip.mailer.twig_swift')->sendMessage(
                $template,
                $context,
                $from,
                $recipient
            );
        }else{
            $content = $this->get('pequiven_seip.mailer.twig_swift')->renderMessage(
                $template,
                $context,
                $from,
                $recipient
            )->getBody();
        }
        $content .=  sprintf('<br><b>Debug: send=%s, recipient=%s, messageSend=%s, debug=%s<b/>',($send ? '1':'0'),$recipientEmail,$messageSend,$debug);
        $response = new \Symfony\Component\HttpFoundation\Response($content);
        return $response;
    }
    
    /**
     * Configuracion global del SEIP
     * 
     * @return \Pequiven\SEIPBundle\Service\Configuration
     */
    protected function getSeipConfiguration() {
        return $this->container->get('seip.configuration');
    }
}
