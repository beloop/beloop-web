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

namespace Beloop\Admin\CourseBundle\Controller\API;

use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Beloop\Admin\CommonBundle\Controller\Abstracts\AbstractApiController;
use Beloop\Component\Course\Entity\Interfaces\CourseInterface;

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
     * @return array
     *
     * @Route(
     *      path = "/list/{orderByField}/{orderByDirection}",
     *      name = "admin_api_course_list",
     *      methods = {"GET"},
     *      defaults = {
     *          "orderByField" = "startDate",
     *          "orderByDirection" = "DESC",
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
}