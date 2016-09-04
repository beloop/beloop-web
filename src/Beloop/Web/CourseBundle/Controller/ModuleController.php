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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;

use Beloop\Component\Course\Entity\Interfaces\CourseInterface;
use Beloop\Component\Course\Entity\Interfaces\ModuleInterface;

/**
 * Class ModuleController
 */
class ModuleController extends Controller
{
    /**
     * View regular page module
     *
     * @param ModuleInterface $page
     * @return array
     *
     * @Route(
     *      path = "/course/{code}/page/{id}",
     *      name = "beloop_view_module_regular_page",
     *      methods = {"GET"}
     * )
     *
     * @Template
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "beloop.factory.page",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      name = "page",
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true
     * )
     */
    public function viewPageAction(ModuleInterface $page)
    {

    }

    /**
     * Render module aside menu
     *
     * @param CourseInterface $course
     * @param $actualModule
     * 
     * @return array
     *
     * @Route(
     *      path = "/course/{code}/render-aside/{actualModule}",
     *      name = "beloop_render_course_aside_menu",
     *      methods = {"GET"}
     * )
     *
     * @Template("CourseBundle:Module:partials/side_menu.html.twig")
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
    public function asideAction(CourseInterface $course, $actualModule)
    {
        return [
            'user'         => $this->getUser(),
            'course'       => $course,
            'actualModule' => $actualModule
        ];
    }

    /**
     * Render module nav menu
     *
     * @param CourseInterface $course
     * @param $actualModule
     *
     * @return array
     *
     * @Route(
     *      path = "/course/{code}/render-nav/{actualModule}",
     *      name = "beloop_render_course_nav_menu",
     *      methods = {"GET"}
     * )
     *
     * @Template("CourseBundle:Module:partials/nav_menu.html.twig")
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
    public function navAction(CourseInterface $course, $actualModule)
    {
        return [
            'user'         => $this->getUser(),
            'course'       => $course,
            'actualModule' => $actualModule
        ];
    }
}