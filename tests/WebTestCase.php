<?php

namespace Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

abstract class WebTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    use PurgeTrait;

    /** @var Client */
    protected $client;

    /** @var EntityManagerInterface */
    protected $em;

    /** {@inheritDoc} */
    protected function setUp()
    {
        $this->client = self::createClient();

        $this->em = $this->client->getContainer()->get('doctrine')->getManager();
        $this->purge();
    }

    protected function logIn()
    {
        $session = $this->client->getContainer()->get('session');
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('admin', '12345', $firewallContext, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}