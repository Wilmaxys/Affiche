<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ProductsController extends AbstractController
{

    private $repository;
    private $em;

    public function __construct(ProductsRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    public function index(): Response
    {
        $session = new Session();
        $session->set('previousCategoryId', null);

        $products = $this->repository->findAll();

        return $this->render('admin/products/index.html.twig', [
            'products' => $products
        ]);
    }

    public function new(Request $request): Response
    {
        $session = new Session();

        $Products = new Products();

        $form = $this->createForm(ProductsType::class, $Products);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('save')->isClicked()) {
                $this->em->persist($Products);
                $this->em->Flush();
                $this->addFlash('success', 'Produit ajouter avec succès.');
            }

            if ($session->get('previousCategoryId')){
                return $this->redirectToRoute('admin.categories.showOneCategory', ['id' => $session->get('previousCategoryId')]);
            }
            else{
                return $this->redirectToRoute('admin.products.show');
            }
        }

        return $this->render('admin/products/new.html.twig', [
            'Products' => $Products,
            'form' => $form->createView()
        ]);
    }

    public function edit(Products $Products, Request $request): Response
    {
        $session = new Session();

        $form = $this->createForm(ProductsType::class, $Products);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('save')->isClicked()) {
                $this->em->Flush();
                $this->addFlash('success', 'Produit modifier avec succès.');
            }

            if ($session->get('previousCategoryId')){
                return $this->redirectToRoute('admin.categories.showOneCategory', ['id' => $session->get('previousCategoryId')]);
            }
            else{
                return $this->redirectToRoute('admin.products.show');
            }
        }

        return $this->render('admin/products/edit.html.twig', [
            'Products' => $Products,
            'form' => $form->createView(),
        ]);
    }

    public function delete(Products $Products, Request $request): Response
    {
        $session = new Session();

        if ($this->isCsrfTokenValid('delete'.$Products->getId(), $request->get('_token'))) {
            $this->em->remove($Products);
            $this->em->flush();
            $this->addFlash('success', 'Produit supprimer avec succès.');

        }

        if ($session->get('previousCategoryId')){
            return $this->redirectToRoute('admin.categories.showOneCategory', ['id' => $session->get('previousCategoryId')]);
        }
        else{
            return $this->redirectToRoute('admin.products.show');
        }
    }
}
