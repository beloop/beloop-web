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

namespace Beloop\Admin\CommonBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Beloop\Admin\CommonBundle\Controller\Abstracts\AbstractAdminController;

/**
 * Class Controller for Admin
 *
 * @Route(
 *      path = "/",
 * )
 */
class AdminController extends AbstractAdminController
{
    /**
     * Admin controller
     *
     * @return array
     *
     * @Route(
     *     path = "",
     *     name = "admin_index"
     * )
     *
     * @Template("AdminCommonBundle:Main:index.html.twig")
     */
    public function indexAction() {
        return [
            'user' => $this->getUser(),
        ];
    }
}