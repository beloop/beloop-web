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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormView;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;

use Beloop\Component\Course\Entity\Interfaces\CourseInterface;

/**
 * Class Controller for Course
 *
 * @Route(
 *      path = "/course",
 * )
 */
class CourseController extends Controller
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
        $user = $this->getUser();

        $courseDirector = $this->get('beloop.director.course');

        $courses = $courseDirector->findBy(
            [],
            [$orderByField => $orderByDirection],
            $limit,
            ($page - 1) * $limit
        );

        return [
            'courses'          => $courses,
            'user'             => $user,
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
     * Create or edit course
     *
     * @param FormView $formView
     * @param CourseInterface $course
     *
     * @return array
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
     *      path = "/new",
     *      name = "admin_course_new",
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
     *
     * @FormAnnotation(
     *      class = "beloop_course_form_type_course",
     *      name  = "formView",
     *      entity = "course",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editComponentAction(
        FormView $formView,
        CourseInterface $course
    ) {
        return [
            'course'  => $course,
            'form'    => $formView,
        ];
    }
}