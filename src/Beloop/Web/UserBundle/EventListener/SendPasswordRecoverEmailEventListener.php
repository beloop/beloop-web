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

use Beloop\Component\User\Event\PasswordRecoverEvent;
use Beloop\Web\CommonBundle\EventListener\Abstracts\AbstractEmailSenderEventListener;

class SendPasswordRecoverEmailEventListener extends AbstractEmailSenderEventListener
{
    /**
     * Send email
     *
     * @param PasswordRecoverEvent $event Event
     */
    public function sendPasswordRecoverEmail(PasswordRecoverEvent $event)
    {
        $user = $event->getUser();

        $this->sendEmail(
            'WebUserBundle:Email:recover.html.twig',
            [
                'subject' => 'email.user.recover_password.subject',
                'user' => $user,
            ],
            'no-reply@deliciousyetbeautiful.com',
            $user->getEmail()
        );
    }
}