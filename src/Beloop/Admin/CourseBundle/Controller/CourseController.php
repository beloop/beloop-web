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

use Doctrine\ORM\Tools\Pagination\Paginator;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;

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
     * Dashboard page
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
            'courses' => $courses,
            'section' => 'admin',
            'user' => $user,
            'paginator'        => $paginator,
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
            'totalPages'       => $paginatorAttributes->getTotalPages(),
            'totalElements'    => $paginatorAttributes->getTotalElements(),
        ];
    }
}