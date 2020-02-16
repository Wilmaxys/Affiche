<?php

namespace App\Controller\Admin;

use App\Entity\Customers;
use App\Form\CustomersType;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends AbstractController
{

    private $repository;
    private $em;

    public function __construct(CustomerRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    public function index (): Response
    {
        $customers = $this->repository->findAll();

        return $this->render('admin/customers/index.html.twig', [
            'customers' => $customers,
        ]);
    }
}
