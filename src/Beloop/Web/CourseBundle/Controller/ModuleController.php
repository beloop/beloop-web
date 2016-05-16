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
     * View squarespace page module
     *
     * @param ModuleInterface $page
     * @return array
     *
     * @Route(
     *      path = "/course/{code}/sq-page/{id}",
     *      name = "beloop_view_module_squarespace_page",
     *      methods = {"GET"}
     * )
     *
     * @Template
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "beloop.factory.squarespace_page",
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
    public function viewSquarespacePageAction(ModuleInterface $page)
    {
        $user = $this->getUser();

        $userEnrolled = $page->getCourse()->getEnrolledUsers()->contains($user);

        if (!$userEnrolled) {
            throw $this->createNotFoundException('The course does not exist');
        }

        return [
            'section' => 'my-courses',
            'user' => $user,
            'course' => $page->getCourse(),
            'page' => $page,
        ];
    }
}