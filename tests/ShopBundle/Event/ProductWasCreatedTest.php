<?php

namespace Tests\ShopBundle\Event;

use ShopBundle\Entity\Product;
use ShopBundle\Event\ProductWasCreated;

class ProductWasCreatedTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_should_return_proper_product()
    {
        $product = Product::createProduct('test', 'test', 11.2);
        $productEvent = new ProductWasCreated($product);
        $this->assertEquals($product, $productEvent->getProduct());
    }
}