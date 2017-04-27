<?php

/*
 * This file is part of the Beloop package.
 *
 * Copyright (c) 2017 AHDO Studio B.V.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Arkaitz Garro <arkaitz.garro@gmail.com>
 */

namespace Beloop\Admin\CourseBundle\EventListener;

use Symfony\Component\Translation\TranslatorInterface;

use Beloop\Component\User\Event\EnrolmentEvent;
use Beloop\Web\CommonBundle\EventListener\Abstracts\AbstractEmailSenderEventListener;

/**
 * Class SendEnrolmentEmailEventListener
 */
class SendEnrolmentEmailEventListener extends AbstractEmailSenderEventListener
{
    /**
     * @var TranslatorInterface
     *
     * Translator service
     */
    protected $translator;

    /**
     * Set translator service
     *
     * @param TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Send email
     *
     * @param EnrolmentEvent $event Event
     */
    public function sendEnrolmentEmail(EnrolmentEvent $event)
    {
        $user = $event->getUser();
        $course = $event->getCourse();

        $this->translator->setLocale($user->getLanguage()->getIso());

        $this->sendEmail(
            'AdminCourseBundle:Email:enrolment.html.twig',
            [
                'subject' => $this->translator->trans('email.user.enrolment.subject', [ '%course_name%' => $course->getName() ]),
                'user' => $user,
                'course' => $course,
            ],
            'no-reply@deliciousyetbeautiful.com',
            $user->getEmail()
        );
    }
}
