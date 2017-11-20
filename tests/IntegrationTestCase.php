<?php

namespace Tests;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class IntegrationTestCase extends KernelTestCase
{
    /** @var ContainerInterface */
    protected $container;

    /** @var EntityManagerInterface */
    protected $em;

    /** {@inheritDoc} */
    protected function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
        $this->em = $this->container->get('doctrine')->getManager();

        $purger = new ORMPurger($this->em);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $purger->purge();
    }
}