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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormView;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;

use Beloop\Admin\CommonBundle\Controller\Abstracts\AbstractAdminController;
use Beloop\Component\Course\Entity\Interfaces\CourseInterface;

/**
 * Class Controller for Course
 *
 * @Route(
 *      path = "/course",
 * )
 */
class CourseController extends AbstractAdminController
{
    /**
     * Courses list
     *
     * @return array
     *
     * @Route(
     *      path = "/list/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_course_list",
     *      methods = {"GET"},
     *      requirements = {
     *          "page" = "\d*",
     *          "limit" = "\d*",
     *      },
     *      defaults = {
     *          "page" = "1",
     *          "limit" = "50",
     *          "orderByField" = "startDate",
     *          "orderByDirection" = "DESC",
     *      }
     * )
     *
     * @Template
     *
     * @PaginatorAnnotation(
     *      attributes = "paginatorAttributes",
     *      class = "beloop.entity.course.class",
     *      page = "~page~",
     *      limit = "~limit~",
     *      orderBy = {
     *          {"x", "~orderByField~", "~orderByDirection~"}
     *      }
     * )
     */
    public function listAction(
        Paginator $paginator,
        PaginatorAttributes $paginatorAttributes,
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    ) {
        $courseDirector = $this->get('beloop.director.course');

        $courses = $courseDirector->findBy(
            [],
            [$orderByField => $orderByDirection],
            $limit,
            ($page - 1) * $limit
        );

        return [
            'user'             => $this->getUser(),
            'courses'          => $courses,
            'paginator'        => $paginator,
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
            'totalPages'       => $paginatorAttributes->getTotalPages(),
            'totalElements'    => $paginatorAttributes->getTotalElements(),
        ];
    }

    /**
     * Create, Edit and save course
     *
     * @param FormView        $formView
     * @param CourseInterface $course
     * @param boolean         $isValid
     *
     * @return array
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_course_new",
     *      methods = {"GET"}
     * )
     *
     * @Route(
     *      path = "/edit/{id}",
     *      name = "admin_course_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     *
     * @Route(
     *      path = "/update/{id}",
     *      name = "admin_course_update",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"POST"}
     * )
     *
     * @Route(
     *      path = "/new/update",
     *      name = "admin_course_save",
     *      methods = {"POST"}
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
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      persist = true
     * )
     *
     * @FormAnnotation(
     *      class = "Beloop\Admin\CourseBundle\Form\Type\CourseType",
     *      name  = "formView",
     *      entity = "course",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editAction(
        FormView $formView,
        CourseInterface $course,
        $isValid
    ) {
        if ($isValid) {
            $this->flush($course);

            $this->addFlash('success', 'admin.course.saved');

            return $this->redirectToRoute('admin_course_edit', ['id' => $course->getId()]);
        }

        return [
            'user'    => $this->getUser(),
            'course'  => $course,
            'form'    => $formView,
        ];
    }

    /**
     * Duplicate an existing course
     *
     * @param CourseInterface $course
     *
     * @return array
     *
     * @Route(
     *      path = "/duplicate/{id}",
     *      name = "admin_course_duplicate",
     *      requirements = {
     *          "id" = "\d+",
     *      },
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
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      persist = true
     * )
     */
    public function duplicateAction(
        CourseInterface $course
    ) {
        $newCourse = clone $course;
        $this->flush($newCourse);

        $this->addFlash('success', 'admin.course.duplicated');

        return $this->redirectToRoute('admin_course_edit', ['id' => $newCourse->getId()]);
    }

    /**
     * Enroll users on course
     *
     * @param CourseInterface $course
     *
     * @param Request $request
     * @return array
     * @Route(
     *      path = "/enroll/{id}",
     *      name = "admin_course_enroll_users",
     *      methods = {"POST"},
     *      options = {
     *          "expose" = "true"
     *      }
     * )
     *
     * @Template("AdminCourseBundle:Users:list.html.twig")
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "beloop.factory.course",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      name = "course",
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true,
     *      persist = true
     * )
     */
    public function enrollUsers(
        CourseInterface $course,
        Request $request
    ) {
        $csv = $request->request->get('csv');

        $this->get('beloop.user_enrollment')->enrolFromCSV($course, $csv);

        return [
            'user'   => $this->getUser(),
            'course' => $course,
            'users'  => $course->getEnrolledUsers()
        ];
    }
}