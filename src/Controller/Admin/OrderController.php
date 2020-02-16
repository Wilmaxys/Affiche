<?php

namespace App\Controller\Admin;

use App\Entity\Orders;
use App\Form\OrdersType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends AbstractController
{

    private $repository;
    private $em;

    public function __construct(OrderRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    public function index (): Response
    {
        $orders = $this->repository->findAll();

        return $this->render('admin/orders/index.html.twig', [
            'orders' => $orders,
        ]);
    }
}
