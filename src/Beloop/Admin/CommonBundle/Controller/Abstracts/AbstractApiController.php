<?php

/*
 * This file is part of the Beloop package.
 *
 * Copyright (c) 2017 AHDO Studio B.V.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Arkaitz Garro <arkaitz.garro@gmail.com>
 */

namespace Beloop\Admin\CommonBundle\Controller\Abstracts;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AbstractApiController
 */
class AbstractApiController extends Controller
{
    /**
     * Save an entity. To ensure the method is simple, the entity will be
     * persisted always
     *
     * @param mixed $response Entity or Collection
     *
     * @return JsonResponse
     */
    protected function jsonResponse($data)
    {
        $response = new JsonResponse();
        $response->setData($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}