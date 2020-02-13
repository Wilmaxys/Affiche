<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class CategoriesController extends AbstractController
{
   
    private $repository;
    private $em;

    public function __construct(CategoriesRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    public function index(): Response
    {
        $categories = $this->repository->findAll();

        return $this->render('admin/categories/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    public function showOneCategory(Categories $categories,ProductsRepository $proRepo): Response
    {
        $session = new Session();
        $session->set('previousCategoryId', $categories->getId());

        $products = $proRepo->findByCategory($categories);

        return $this->render('admin/products/index.html.twig', [
            'products' => $products,
            'catName' => $categories->getNom()
        ]);
    }

    public function new(Request $request): Response
    {
        $Categories = new Categories();

        $form = $this->createForm(CategoriesType::class, $Categories);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('save')->isClicked()) {
                $this->em->persist($Categories);
                $this->em->Flush();
                $this->addFlash('success', 'Catégorie ajouter avec succès. Bravo!');
            }
            return $this->redirectToRoute('admin.categories.show');
        }

        return $this->render('admin/categories/new.html.twig', [
            'Categories' => $Categories,
            'form' => $form->createView()
        ]);
    }

    public function edit(Categories $Categories, Request $request): Response
    {
        $form = $this->createForm(CategoriesType::class, $Categories);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('save')->isClicked()){
                $this->em->Flush();
                $this->addFlash('success', 'Catégorie modifier avec succès.');
            }

            return $this->redirectToRoute('admin.categories.show');
        }

        return $this->render('admin/categories/edit.html.twig', [
            'Categories' => $Categories,
            'form' => $form->createView(),
        ]);
    }

    public function delete(Categories $Category, Request $request, ProductsRepository $repoPro): Response
    {
        $Categories = $repoPro->findByCategory($Category);

        if ($Categories){
            $this->addFlash('error', 'Vous ne pouvez pas supprimer cette catégorie car des biens y sont associés.');
        }
        else if($this->isCsrfTokenValid('delete'.$Category->getId(), $request->get('_token'))){
            $this->em->remove($Category);
            $this->em->flush();
            $this->addFlash('success', 'Catégorie supprimer avec succès.');
        }

        return $this->redirectToRoute('admin.categories.show');
    }
}
