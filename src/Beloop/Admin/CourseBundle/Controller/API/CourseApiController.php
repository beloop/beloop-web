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

namespace Beloop\Admin\CourseBundle\Controller\API;

use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Form;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;

use Beloop\Admin\CommonBundle\Controller\Abstracts\AbstractApiController;
use Beloop\Component\Course\Entity\Interfaces\CourseInterface;
use Symfony\Component\Form\FormView;

/**
 * Class Controller for Course
 *
 * @Route(
 *      path = "/course",
 * )
 */
class CourseApiController extends AbstractApiController
{
    /**
     * Courses list
     *
     * @return mixed
     *
     * @Route(
     *      path = "/list/{orderByField}/{orderByDirection}",
     *      name = "admin_api_course_list",
     *      methods = {"GET"},
     *      defaults = {
     *          "orderByField" = "code",
     *          "orderByDirection" = "ASC",
     *      }
     * )
     */
    public function getCoursesAction(
        $orderByField,
        $orderByDirection
    ) {
        $response = [];
        $courseDirector = $this->get('beloop.director.course');
        $courses = $courseDirector->findBy(
            [],
            [$orderByField => $orderByDirection]
        );

        foreach ($courses as $course) {
            $response[] = $course->serialize();
        }

        return $this->jsonResponse($response);
    }

    /**
     * Get course by code
     *
     * @return mixed
     *
     * @Route(
     *      path = "/{code}",
     *      name = "admin_api_course_get",
     *      methods = {"GET"}
     * )
     */
    public function getCourseAction(
        $code
    ) {
        $courseDirector = $this->get('beloop.director.course');
        $course = $courseDirector->findOneBy([ 'code' => $code ]);

        return $this->jsonResponse($course->serialize());
    }

    /**
     * Create, Edit and save course
     *
     * @param FormView $form
     * @param CourseInterface $course
     * @param boolean $isValid
     * @return mixed
     * @Route(
     *      path = "/new",
     *      name = "admin_course_new",
     *      methods = {"GET"}
     * )
     *
     * @Route(
     *      path = "/{code}",
     *      name = "admin_api_course_update",
     *      methods = {"PUT"}
     * )
     *
     * @Route(
     *      path = "/",
     *      name = "admin_api_course_save",
     *      methods = {"POST"}
     * )
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
     *      mappingFallback = true,
     *      persist = true
     * )
     *
     * @FormAnnotation(
     *      class = "Beloop\Admin\CourseBundle\Form\Type\CourseType",
     *      name  = "form",
     *      entity = "course",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editAction(
        FormView $form,
        CourseInterface $course,
        $isValid
    ) {
        if ($isValid) {
            $this->flush($course);

            $this->addFlash('success', 'admin.course.saved');

            return $this->redirectToRoute('admin_course_edit', ['id' => $course->getId()]);
        }

        return $this->jsonResponse($course->serialize());
    }
}
