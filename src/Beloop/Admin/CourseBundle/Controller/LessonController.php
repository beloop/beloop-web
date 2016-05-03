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

namespace Beloop\Admin\CourseBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormView;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;

use Beloop\Admin\CommonBundle\Controller\Abstracts\AbstractAdminController;
use Beloop\Component\Course\Entity\Interfaces\LessonInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Controller for Lesson
 *
 * @Route(
 *      path = "/lesson",
 * )
 */
class LessonController extends AbstractAdminController
{
    /**
     * Create, Edit and save course
     *
     * @param Request $request
     * @param FormView $formView
     * @param LessonInterface $lesson
     * @param boolean $isValid
     *
     * @return array
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_lesson_new",
     *      methods = {"GET"}
     * )
     *
     * @Route(
     *      path = "/edit/{id}",
     *      name = "admin_lesson_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     *
     * @Route(
     *      path = "/update/{id}",
     *      name = "admin_lesson_update",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"POST"}
     * )
     *
     * @Route(
     *      path = "/new/update",
     *      name = "admin_lesson_save",
     *      methods = {"POST"}
     * )
     *
     * @Template
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "beloop.factory.lesson",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      name = "lesson",
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      persist = true
     * )
     *
     * @FormAnnotation(
     *      class = "Beloop\Admin\CourseBundle\Form\Type\LessonType",
     *      name  = "formView",
     *      entity = "lesson",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editAction(
        Request $request,
        FormView $formView,
        LessonInterface $lesson,
        $isValid
    ) {
        if ($isValid) {
            $this->flush($lesson);

            $this->addFlash('success', 'admin.lesson.saved');

            return $this->redirectToRoute('admin_course_edit', ['id' => $lesson->getCourse()->getId()]);
        }

        return [
            'lesson'  => $lesson,
            'form'    => $formView,
        ];
    }
}