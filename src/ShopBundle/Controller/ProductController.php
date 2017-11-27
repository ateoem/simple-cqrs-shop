<?php

namespace ShopBundle\Controller;

use ShopBundle\Command\CreateProduct;
use ShopBundle\Entity\Product;
use ShopBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /** @Route("/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1}) */
    public function indexAction($page)
    {
        $query = $this->getDoctrine()->getRepository(Product::class)->getPaginationQuery();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, $page, 10);

        return $this->render('ShopBundle:Product:index.html.twig', array('pagination' => $pagination));
    }

    /** @Route("/admin/new-product") */
    public function newProductAction(Request $request)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return new Response('Not authorized', 401);
        }

        $form = $this->createForm(ProductType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $command = new CreateProduct($data['name'], $data['description'], $data['price']);
            $this->get('command_bus')->handle($command);
            return new RedirectResponse('/');
        }

        return $this->render('ShopBundle:Product:new.html.twig', array('form' => $form->createView()));
    }
}
