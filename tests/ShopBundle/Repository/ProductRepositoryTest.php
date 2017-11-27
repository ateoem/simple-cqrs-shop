<?php
/**
 * Created by PhpStorm.
 * User: atom
 * Date: 20.11.17
 * Time: 09:19
 */

namespace Tests\ShopBundle\Repository;


use ShopBundle\DataFixtures\ORM\ProductFixture;
use ShopBundle\Entity\Product;
use ShopBundle\Repository\ProductRepository;
use Tests\IntegrationTestCase;

class ProductRepositoryTest extends IntegrationTestCase
{
    /** @var ProductRepository */
    private $repository;

    /** {@inheritDoc} */
    protected function setUp()
    {
        parent::setUp();
        $fixtures = new ProductFixture();
        $fixtures->load($this->em);

        $this->repository = $this->em->getRepository(Product::class);
    }

    /** @test */
    public function it_should_return_query_results()
    {
        $query = $this->repository->getPaginationQuery();
        $results = $query->getResult();

        $this->assertCount(30, $results);
        $this->assertGreaterThan($results[0]->getCreatedAt(), $results[29]->getCreatedAt());
    }
}