<?php

namespace tests\ShopBundle\Command;

use ShopBundle\Command\CreateProduct;

class CreateProductTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_returns_proper_values()
    {
        $command = new CreateProduct('lorem', 'ipsum', 11.12);

        $this->assertEquals($command->name, 'lorem');
        $this->assertEquals($command->description, 'ipsum');
        $this->assertEquals($command->price, 11.12);
    }
}
