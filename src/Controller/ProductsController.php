<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Products;
use App\Form\OrderType;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ProductsController extends AbstractController
{
    private $repository;

    /**
     * CategoriesController constructor.
     * @param ProductsRepository $repository
     */
    public function __construct(ProductsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show(Products $product, Request $request) : Response
    {
        $session = new Session();
        $createdOrder = new Order();
        $createdOrder->setProduct($product);

        //$form = $this->createForm(OrderType::class, $createdOrder);
        //$form->handleRequest($request);

        //if ($form->isSubmitted() && $form->isValid() && $form->get('save')->isClicked()) {
            $session->set('order', $createdOrder);
            //return $this->redirectToRoute('order.createOrder');
        //}

        return $this->render('products/product.html.twig', [
            //'form' => $form->createView(),
            'product' => $product
        ]);
    }
}
