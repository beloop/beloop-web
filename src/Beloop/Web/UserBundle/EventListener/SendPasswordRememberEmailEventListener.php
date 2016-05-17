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

namespace Beloop\Web\UserBundle\EventListener;

use Symfony\Component\Translation\TranslatorInterface;

use Beloop\Component\User\Event\PasswordRememberEvent;
use Beloop\Web\CommonBundle\EventListener\Abstracts\AbstractEmailSenderEventListener;

/**
 * Class SendPasswordRememberEmailEventListener
 */
class SendPasswordRememberEmailEventListener extends AbstractEmailSenderEventListener
{
    /**
     * Send email
     *
     * @param PasswordRememberEvent $event Event
     */
    public function sendPasswordRememberEmail(PasswordRememberEvent $event)
    {
        $user = $event->getUser();
        $rememberUrl = $event->getRememberUrl();

        $this->sendEmail(
            'WebUserBundle:Email:remember.html.twig',
            [
                'subject' => 'email.user.remember_password.subject',
                'user' => $user,
                'remember_url' => $rememberUrl,
            ],
            'no-reply@deliciousyetbeautiful.com',
            $user->getEmail()
        );
    }
}