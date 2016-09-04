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

namespace Beloop\Admin\CommonBundle\Controller\Abstracts;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class AbstractAdminController
 */
class AbstractAdminController extends Controller
{
    /**
     * Save an entity. To ensure the method is simple, the entity will be
     * persisted always
     *
     * @param mixed $entity Entity
     *
     * @return $this self Object
     */
    protected function flush($entity)
    {
        /**
         * @var ObjectManager $objectManager
         */
        $objectManager = $this->getManagerForClass($entity);

        $objectManager->persist($entity);
        $objectManager->flush($entity);

        return $this;
    }

    /**
     * Private controller helpers
     *
     * These helpers MUST be private. Should not expose this magic to the whole
     * controller set, but help internal methods
     */

    /**
     * Get entity manager from an entity
     *
     * @param Mixed $entity Entity
     *
     * @return ObjectManager specific manager
     */
    private function getManagerForClass($entity)
    {
        return $this
            ->get('beloop.provider.manager')
            ->getManagerByEntityNamespace(get_class($entity));
    }
}