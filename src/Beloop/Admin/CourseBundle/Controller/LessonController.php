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

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mmoreram\ControllerExtraBundle\Annotation\LoadEntity;
use Mmoreram\ControllerExtraBundle\Annotation\CreateForm;

use Beloop\Admin\CommonBundle\Controller\Abstracts\AbstractAdminController;
use Beloop\Component\Course\Entity\Interfaces\LessonInterface;

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
     * Create course
     *
     * @param Form $form
     * @param LessonInterface $lesson
     * @param int $courseId
     *
     * @return array
     *
     * @Route(
     *      path = "/new/{courseId}",
     *      name = "admin_lesson_new",
     *      requirements = {
     *          "courseId" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     *
     * @Template
     *
     * @LoadEntity(
     *      namespace = "beloop.entity.lesson.class",
     *      factory = {
     *          "class" = "beloop.factory.lesson",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      name = "lesson",
     * )
     *
     * @CreateForm(
     *      class = "Beloop\Admin\CourseBundle\Form\Type\LessonType",
     *      name  = "form",
     *      entity = "lesson",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function newAction(
        Form $form,
        LessonInterface $lesson,
        $courseId
    ) {
        $course = $this->get('beloop.director.course')->find($courseId);

        $lesson->setCourse($course);
        $lesson->setPosition($course->getLessons()->count() + 1);

        $form->setData($lesson);

        return [
            'lesson'  => $lesson,
            'form'    => $form->createView(),
        ];
    }

    /**
     * Edit and save course
     *
     * @param FormView $formView
     * @param LessonInterface $lesson
     * @param boolean $isValid
     *
     * @return array
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
     * @LoadEntity(
     *      namespace = "beloop.entity.lesson.class",
     *      factory = {
     *          "class" = "beloop.factory.lesson",
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
     * @CreateForm(
     *      class = "Beloop\Admin\CourseBundle\Form\Type\LessonType",
     *      name  = "formView",
     *      entity = "lesson",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editAction(
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

    /**
     * Update lesson position
     *
     * @param LessonInterface $lesson
     * @param $oldPosition
     * @param $newPosition
     *
     * @Route(
     *      path = "/edit/{id}/position/{oldPosition}/{newPosition}",
     *      name = "admin_lesson_edit_position",
     *      requirements = {
     *          "id" = "\d+",
     *      "oldPosition" = "\d+",
     *      "newPosition" = "\d+"
     *      },
     *      methods = {"POST"},
     *      options = {
     *          "expose" = "true"
     *      }
     * )
     *
     * @LoadEntity(
     *      namespace = "beloop.entity.lesson.class",
     *      factory = {
     *          "load" = "beloop.factory.lesson",
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
     * @return JsonResponse
     */
    public function updatePositionAction(LessonInterface $lesson, $oldPosition, $newPosition) {
        $positionFixer = $this->get('beloop.position_fixer');

        $lesson->setPosition($newPosition);
        $this->flush($lesson);

        $positionFixer->fixEntitiesPosition($lesson->getCourse()->getLessons(), $lesson, $oldPosition, $newPosition);

        // TODO: return complete JSON response
        $response = new JsonResponse();
        $response->setData([]);

        return $response;
    }
}
