<?php

namespace Tests\ShopBundle\Controller;


use ShopBundle\DataFixtures\ORM\ProductFixture;
use Symfony\Component\HttpFoundation\Response;
use Tests\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $fixtures = new ProductFixture();
        $fixtures->load($this->em);
    }

    /** @test */
    public function it_paginages_data()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertContains('Product 1', $crawler->html());
        $this->assertContains('Product 2', $crawler->html());

        $this->assertNotContains('Product 10', $crawler->html());
        $this->assertNotContains('Product 29', $crawler->html());

        $link = $crawler
            ->filter('a:contains("2")') // find all links with the text "Greet"
            ->eq(0)->link();

        $crawler = $this->client->click($link);

        $this->assertContains('Product 10', $crawler->html());
        $this->assertContains('Product 11', $crawler->html());

        $this->assertNotContains('Product 3', $crawler->html());
        $this->assertNotContains('Product 29', $crawler->html());

        $link = $crawler
            ->filter('a:contains("3")') // find all links with the text "Greet"
            ->eq(0)->link();

        $crawler = $this->client->click($link);

        $this->assertContains('Product 28', $crawler->html());
        $this->assertContains('Product 29', $crawler->html());

        $this->assertNotContains('Product 3', $crawler->html());
        $this->assertNotContains('Product 11', $crawler->html());
    }

    /** @test */
    public function it_should_allow_admins_to_create_product()
    {
        $this->logIn();
        $this->client->request('GET', 'admin/new-product');


        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    /** @test */
    public function it_should_not_allow_anon_user_to_create_product()
    {
        $this->client->request('GET', 'admin/new-product');

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $this->client->getResponse()->getStatusCode());
    }
}