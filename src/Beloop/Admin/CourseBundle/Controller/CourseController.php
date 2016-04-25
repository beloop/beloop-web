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
     *      path = "/list",
     *      name = "admin_course_list",
     *      methods = {"GET"}
     * )
     *
     * @Template
     */
    public function listAction()
    {
        $user = $this->getUser();

        $courseDirector = $this->get('beloop.director.course');

        $courses = $courseDirector->findBy(
            [],
            ['startDate' => 'DESC']
        );

        return [
            'courses' => $courses,
            'section' => 'admin',
            'user' => $user,
        ];
    }
}