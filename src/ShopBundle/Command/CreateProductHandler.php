<?php

namespace ShopBundle\Command;

use Doctrine\ORM\EntityManager;
use ShopBundle\Entity\Product;
use ShopBundle\Event\ProductWasCreated;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateProductHandler
{
    /** @var EventDispatcherInterface*/
    private $eventDispatcher;

    /** @var EntityManager */
    private $em;

    /** @param EventDispatcherInterface $eventDispatcher */
    public function __construct(EventDispatcherInterface $eventDispatcher, EntityManager $em)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->em = $em;
    }

    public function handle(CreateProduct $command)
    {
        $product = Product::createProduct($command->name, $command->description, $command->price);

        $this->em->persist($product);
        $this->em->flush();

        $event = new ProductWasCreated($product);
        $this->eventDispatcher->dispatch(ProductWasCreated::NAME, $event);
    }
}
