<?php

namespace Tests\ShopBundle\Entity;

use ShopBundle\Entity\Product;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_should_create_proper_object()
    {
        $product = Product::createProduct('test', 'testtest', 12.23);

        $this->assertEquals('test', $product->getName());
        $this->assertEquals('testtest', $product->getDescription());
        $this->assertEquals(12.23, $product->getPrice());
    }
}