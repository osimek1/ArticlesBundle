<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // Dependencies
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
			new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
			new Symfony\Bundle\MonologBundle\MonologBundle(),
            //new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            //
            //new Symfony\Bundle\TwigBundle\TwigBundle(),
            //new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            //new JMS\SerializerBundle\JMSSerializerBundle($this),
            //new FOS\RestBundle\FOSRestBundle(),      
            new Osimek1\ArticlesBundle\Osimek1ArticlesBundle(),
        );

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        // We don't need that Environment stuff, just one config
        $loader->load(__DIR__.'/config.yml');
    }
}