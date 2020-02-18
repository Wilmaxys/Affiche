<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\Products;
use App\Form\CustomerType;
use App\Repository\OrderRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class OrderController extends AbstractController
{

    private $repository;
    private $em;

    public function __construct(OrderRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    public function createOrder(Request $request, ProductsRepository $productsRepository): Response
    {
        $response = $this->redirectToRoute('categories.show');

        $session = new Session();
        $order = $session->get('order');

        if ($order != null)
        {
            $customer = new Customer();

            $form = $this->createForm(CustomerType::class, $customer);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if ($form->get('save')->isClicked()) {
                    $product = $productsRepository->find($order->getProduct()->getId());

                    $order->setProduct($product);
                    $order->setCustomer($customer);

                    $this->em->persist($customer);
                    $this->em->persist($order);
                    $this->em->Flush();

                    $this->addFlash('success', 'Commande effectuée avec succès.');
                }
                else {
                    $session->set('order', null);
                }

                return $this->redirectToRoute('categories.show');
            }

            $response = $this->render('order/createOrder.html.twig',[
                'form' => $form->createView(),
                'order' => $order
            ]);
        }

        return $response;

    }
}
