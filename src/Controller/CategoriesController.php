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
    private $repositoryCat;
    private $repositoryProducts;

    /**
     * CategoriesController constructor.
     * @param CategoriesRepository $repositoryCat
     * @param ProductsRepository $repositoryProducts
     */
    public function __construct(CategoriesRepository $repositoryCat, ProductsRepository $repositoryProducts)
    {
        $this->repositoryCat = $repositoryCat;
        $this->repositoryProducts = $repositoryProducts;
    }

    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $categories = $paginator->paginate(
            $this->repositoryCat->findAllOrdered(),
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('categories/index.html.twig',
            ['categories' => $categories]
        );
    }

    public function openCategory(Categories $category, PaginatorInterface $paginator, Request $request) : Response
    {
        $products = $this->repositoryProducts->findByCategory($category);

        $products = $paginator->paginate(
            $this->repositoryProducts->findAllOrdered($category),
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('categories/openCategory.html.twig',
            ['products' => $products,
             'title' => $category->getNom()]
        );
    }
}
