<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            /**
             * Symfony dependencies
             */
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),

            /**
             * Third-party dependencies
             */
            new EightPoints\Bundle\GuzzleBundle\GuzzleBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Mmoreram\ControllerExtraBundle\ControllerExtraBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),

            /**
             * Beloop core bundles
             */
            new Beloop\Bundle\AnalyticsBundle\BeloopAnalyticsBundle(),
            new Beloop\Bundle\CoreBundle\BeloopCoreBundle(),
            new Beloop\Bundle\CourseBundle\BeloopCourseBundle(),
            new Beloop\Bundle\InstagramBundle\BeloopInstagramBundle(),
            new Beloop\Bundle\LanguageBundle\BeloopLanguageBundle(),
            new Beloop\Bundle\UserBundle\BeloopUserBundle(),
            new Beloop\Bundle\SquarespaceBundle\BeloopSquarespaceBundle(),
            new Beloop\Bundle\TypeformBundle\BeloopTypeformBundle(),

            /**
             * Beloop admin bundles
             */
            new Beloop\Admin\CommonBundle\AdminCommonBundle(),
            new Beloop\Admin\CourseBundle\AdminCourseBundle(),
            new Beloop\Admin\UserBundle\AdminUserBundle(),

            /**
             * Beloop web bundles
             */
            new Beloop\Web\CommonBundle\CommonBundle(),
            new Beloop\Web\CourseBundle\CourseBundle(),
            new Beloop\Web\DashboardBundle\DashboardBundle(),
            new Beloop\Web\InstagramBundle\WebInstagramBundle(),
            new Beloop\Web\TypeformResultsBundle\TypeformResultsBundle(),
            new Beloop\Web\UserBundle\WebUserBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
