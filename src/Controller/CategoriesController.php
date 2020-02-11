<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends AbstractController
{
    private $repository;
    private $repositoryProducts;

    /**
     * CategoriesController constructor.
     * @param CategoriesRepository $repository
     * @param ProductsRepository $repositoryProducts
     */
    public function __construct(CategoriesRepository $repository, ProductsRepository $repositoryProducts)
    {
        $this->repository = $repository;
        $this->repositoryProducts = $repositoryProducts;
    }

    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        die(var_dump($this->repository));
        $categories = $paginator->paginate(
            $this->repository->findPoney(),
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('categories/index.html.twig',
            ['categories' => $categories]
        );
    }

    public function openCategory(Categories $category) : Response
    {
        $products = $this->repositoryProducts->findByCategory($category);

        return $this->render('categories/openCategory.html.twig',
            ['products' => $products]
        );
    }
}
