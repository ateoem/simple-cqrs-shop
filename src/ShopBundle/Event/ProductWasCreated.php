<?php

namespace ShopBundle\Event;

use ShopBundle\Entity\Product;
use Symfony\Component\EventDispatcher\Event;

class ProductWasCreated extends Event
{
    const NAME = 'shop_bundle.event.product.created';

    /** @var Product */
    protected $product;

    /**
     * @param $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}