<?php

namespace Pequiven\SEIPBundle\Service;

/**
 * Enviar correo desde una plantilla twig (pequiven_seip.mailer.twig_swift)
 *
 * @author Carlos Mendoza <inhak20@tecnocreaciones.com>
 */
class TwigSwiftMailer {
    protected $mailer;
    protected $twig;
    
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }
    
    public function renderMessage($templateName, $context, $fromEmail, $toEmail)
    {
        $template = $this->twig->loadTemplate($templateName);
        $subject = $template->renderBlock('subject', $context);
        $textBody = $template->renderBlock('body_text', $context);
        $htmlBody = $template->renderBlock('body_html', $context);

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail);

        if (!empty($htmlBody)) {
            $message->setBody($htmlBody, 'text/html')
                ->addPart($textBody, 'text/plain');
        } else {
            $message->setBody($textBody);
        }
        return $message;
    }
    
    /**
     * @param string $templateName
     * @param array  $context
     * @param string $fromEmail
     * @param string $toEmail
     */
    public function sendMessage($templateName, $context, $fromEmail, $toEmail)
    {
        $message = $this->renderMessage($templateName, $context, $fromEmail, $toEmail);
        return $this->mailer->send($message);
    }
}
