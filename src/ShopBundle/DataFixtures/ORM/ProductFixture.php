<?php

namespace ShopBundle\DataFixtures\ORM;

use Carbon\Carbon;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use ShopBundle\Entity\Product;

class ProductFixture extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 30; $i++) {
            Carbon::setTestNow(Carbon::createFromDate(2017, 1, $i+1));
            $product = Product::createProduct('Product '.$i, 'Description '.$i, $i*2.1);
            $manager->persist($product);
        }

        $manager->flush();
    }
}