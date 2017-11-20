<?php

namespace ShopBundle\Command;

class CreateProduct
{
    public $name;
    public $description;
    public $price;

    /**
     * @param $name
     * @param $description
     * @param $price
     */
    public function __construct($name, $description, $price)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }
}