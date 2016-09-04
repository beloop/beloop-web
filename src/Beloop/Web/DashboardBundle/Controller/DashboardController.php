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

namespace Beloop\Web\DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    /**
     * Dashboard page
     *
     * @return array
     *
     * @Route(
     *      path = "/wall",
     *      name = "beloop_dashboard",
     *      methods = {"GET"}
     * )
     *
     * @Template
     */
    public function dashboardAction()
    {
        $user = $this->getUser();

        if(false === $this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('beloop_public_courses');
        }

        return [
            'section' => 'dashboard',
            'user' => $user,
        ];
    }
}