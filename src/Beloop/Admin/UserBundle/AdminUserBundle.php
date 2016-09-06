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

namespace Beloop\Admin\UserBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

use Beloop\Admin\UserBundle\DependencyInjection\UserExtension;
use Beloop\Bundle\CoreBundle\Abstracts\AbstractBundle;

/**
 * Class AdminUserBundle
 */
class AdminUserBundle extends AbstractBundle
{
    /**
     * Returns the bundle's container extension.
     *
     * @return ExtensionInterface The container extension
     */
    public function getContainerExtension()
    {
        return new UserExtension();
    }
}
