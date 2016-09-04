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

namespace Beloop\Web\CourseBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;

use Beloop\Component\Course\Entity\Interfaces\CourseInterface;

/**
 * Class Controller for Course
 */
class CourseController extends Controller
{
    /**
     * List of my courses
     *
     * @return array
     *
     * @Route(
     *      path = "/my-courses",
     *      name = "beloop_my_courses",
     *      methods = {"GET"}
     * )
     *
     * @Template
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function listAction()
    {
        $user = $this->getUser();
        
        $courses = $this->get('beloop.repository.course')->findByUser($user);

        return [
            'section' => 'my-courses',
            'user' => $user,
            'courses' => $courses,
        ];
    }

    /**
     * List of public courses
     *
     * @return array
     *
     * @Route(
     *      path = "/preview-courses",
     *      name = "beloop_public_courses",
     *      methods = {"GET"}
     * )
     *
     * @Template
     */
    public function previewAction()
    {
        $user = $this->getUser();
        
        $courses = $this->get('beloop.repository.course')->findBy([
            'demo' => true,
            'language' => $user->getLanguage()
        ]);

        return [
            'section' => 'public-courses',
            'user' => $user,
            'courses' => $courses,
        ];
    }

    /**
     * View course information
     *
     * @param CourseInterface $course
     * 
     * @return array
     * 
     * @Route(
     *      path = "/course/{code}",
     *      name = "beloop_view_course",
     *      methods = {"GET"}
     * )
     *
     * @Template
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "beloop.factory.course",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      name = "course",
     *      mapping = {
     *          "code" = "~code~"
     *      },
     *      mappingFallback = true
     * )
     */
    public function viewAction(CourseInterface $course)
    {
        $user = $this->getUser();

        // Extra checks if user is not TEACHER or ADMIN
        if (
            false === $this->get('security.authorization_checker')->isGranted('ROLE_TEACHER') &&
            false === $course->isDemo()
        ) {
            $userEnrolled = $course->getEnrolledUsers()->contains($user);

            if (!$userEnrolled) {
                throw $this->createNotFoundException('The course does not exist');
            }

            if (!$course->isAvailable()) {
                throw $this->createNotFoundException('The course does not exist');
            }
        }

        return [
            'section' => $course->isDemo() ? 'public-courses' : 'my-courses',
            'user' => $user,
            'course' => $course
        ];
    }
}