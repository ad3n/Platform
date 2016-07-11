<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Ihsan\AppBundle\AppBundle(),

            //Asset Management
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Mopa\Bundle\BootstrapBundle\MopaBootstrapBundle(),

            //User Management
            new FOS\UserBundle\FOSUserBundle(),

            //Cache and Session Management
            new Snc\RedisBundle\SncRedisBundle(),
            new FOS\HttpCacheBundle\FOSHttpCacheBundle(),

            //Api Management
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new Bazinga\Bundle\HateoasBundle\BazingaHateoasBundle(),
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),

            //Data Initialization
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),

            //MongoDB Document Management
            new Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle(),

            //Elastic Search
            new FOS\ElasticaBundle\FOSElasticaBundle(),

            //Messaging
            new OldSound\RabbitMqBundle\OldSoundRabbitMqBundle(),

            //CRUD Management
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new SymfonyId\AdminBundle\SymfonyIdAdminBundle(),
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
