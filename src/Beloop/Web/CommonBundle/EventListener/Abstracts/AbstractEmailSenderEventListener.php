<?php

/*
 * This file is part of the Beloop package.
 *
 * Copyright (c) 2016 AHDO Studio B.V.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Arkaitz Garro <arkaitz.garro@gmail.com>
 */

namespace Beloop\Web\CommonBundle\EventListener\Abstracts;

use Swift_Mailer;
use Twig_Environment;

abstract class AbstractEmailSenderEventListener
{
    /**
     * @var Swift_Mailer
     *
     * Mailer
     */
    protected $mailer;

    /**
     * @var Twig_Environment
     *
     * Twig
     */
    protected $twig;

    /**
     * Construct
     *
     * @param Swift_Mailer     $mailer          Mailer
     * @param Twig_Environment $twig            Twig
     */
    public function __construct(
        Swift_Mailer $mailer,
        Twig_Environment $twig
    ) {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }
    /**
     * Send email
     *
     * @param string $template      Email template
     * @param array  $context       Context
     * @param string $senderEmail   Sender email
     * @param string $receiverEmail Receiver email
     */
    protected function sendEmail($template, array $context, $senderEmail, $receiverEmail)
    {
        $body = $this
            ->twig
            ->render($template, $context);

        $message = $this
            ->mailer
            ->createMessage()
            ->setSubject($context['subject'])
            ->setFrom($senderEmail)
            ->setTo($receiverEmail)
            ->setBcc('info@deliciousyetbeautiful.com')
            ->setBody($body, 'text/html');

        $this
            ->mailer
            ->send($message);
    }
}
