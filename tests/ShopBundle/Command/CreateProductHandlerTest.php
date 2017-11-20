<?php

namespace Tests\ShopBundle\Command;

use ShopBundle\Command\CreateProduct;
use ShopBundle\Entity\Product;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Tests\IntegrationTestCase;

class CreateProductHandlerTest extends IntegrationTestCase
{
    /** @var MessageBus */
    private $commandBus;

    /** @var TraceableEventDispatcher */
    private $eventDispatcher;

    private $logger;

    /** {@inheritDoc} */
    protected function setUp()
    {
        parent::setUp();
        $this->em = $this->container->get('doctrine')->getManager();
        $this->commandBus = $this->container->get('command_bus');
        $this->eventDispatcher = $this->container->get('debug.event_dispatcher');

        $mailer = $this->container->get('mailer');
        $logger = new \Swift_Plugins_MessageLogger();
        $mailer->registerPlugin($logger);

        $this->logger = $logger;
    }

    /** @test */
    public function it_creates_new_product()
    {
        $command = new CreateProduct('test_name', 'test_description', 11.23);
        $this->commandBus->handle($command);

        /** @var Product $product */
        $product = $this->em->getRepository(Product::class)->findOneBy([]);

        $this->assertEquals('test_description', $product->getDescription());
        $this->assertEquals('test_name', $product->getName());
        $this->assertEquals(11.23, $product->getPrice());

        $this->assertArrayHasKey(
            'shop_bundle.event.product.created.ShopBundle\EventListener\NotifyWhenProductCreated::onProductCreated',
            $this->eventDispatcher->getCalledListeners()
        );

        $this->assertCount(1, $this->logger->getMessages());
        $this->assertArrayHasKey('fake@example.com', $this->logger->getMessages()[0]->getTo());
        $this->assertEquals('Product with id "1" created.', $this->logger->getMessages()[0]->getBody());
    }
}
