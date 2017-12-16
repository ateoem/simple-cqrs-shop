<?php

namespace ShopBundle\Notifier;

use ShopBundle\Entity\Product;

interface ProductNotifier
{
    /** @param Product $product */
    public function notify(Product $product);
}
