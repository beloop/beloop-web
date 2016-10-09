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

use Beloop\Admin\CommonBundle\Controller\Abstracts\AbstractApiController;

/**
 * Class Controller for Admin
 *
 * @Route(
 *      path = "/translations",
 * )
 */
class TranslationController extends AbstractApiController
{
    /**
     * Admin controller
     *
     * @param $locale
     * @return array
     * @Route(
     *     path = "/{locale}.json",
     *     name = "admin_translations"
     * )
     */
    public function indexAction($locale) {
        $translator = $this->get('translator');
        $translations = $translator->getCatalogue($locale)->all('messages');

        return $this->jsonResponse($translations);
    }
}