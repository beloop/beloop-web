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

namespace Beloop\Admin\CourseBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

use Beloop\Admin\CourseBundle\DependencyInjection\CourseExtension;
use Beloop\Bundle\CoreBundle\Abstracts\AbstractBundle;

/**
 * Class AdminCourseBundle
 */
class AdminCourseBundle extends AbstractBundle
{
    /**
     * Returns the bundle's container extension.
     *
     * @return ExtensionInterface The container extension
     */
    public function getContainerExtension()
    {
        return new CourseExtension();
    }
}