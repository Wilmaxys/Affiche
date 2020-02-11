<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

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

    public function show(Products $product) : Response {
        return $this->render('products/product.html.twig',
            ['product' => $product]
        );
    }
}
