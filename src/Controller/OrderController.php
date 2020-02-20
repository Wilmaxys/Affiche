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

    public function createOrder(Request $request, ProductsRepository $productsRepository, \Swift_Mailer $mailer): Response
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
                //var_dump('OK');

                //if ($form->get('save')->isClicked()) {
                    $product = $productsRepository->find($order->getProduct()->getId());

                    $order->setProduct($product);
                    $order->setCustomer($customer);

                    $this->em->persist($customer);
                    $this->em->persist($order);
                    $this->em->Flush();

                    //$this->addFlash('success', 'Commande effectuée avec succès.');
                    
                    $message = (new \Swift_Message('Hello Email'))
                        ->setFrom('no-reply_affiche@noz.fr')
                        ->setTo($customer->getMail())
                        ->setBcc('vredois@noz.fr')
                        ->setBody(
                            $this->renderView(
                                'emails/confirm.html.twig',
                                ['customer' => $customer]
                            ),
                            'text/html'
                        );
                    $mailerResult = $mailer->send($message);
                    //die(var_dump($mailerResult, $mailer));
                //}
                /*else {
                    $session->set('order', null);
                }*/

                return $this->redirectToRoute('order.success');
            }/* else {
                var_dump($form->isSubmitted());
                if ($form->isSubmitted()) {
                    var_dump($form);
                    die();
                }
            }*/

            $response = $this->render('order/createOrder.html.twig',[
                'form' => $form->createView(),
                'order' => $order
            ]);
        }

        return $response;
    }

    public function success()
    {
        $session = new Session();
        $order = $session->get('order');

        if ($order != null) {
            $session->remove('order');
            //die(var_dump($session));

            return $this->render('order/success.html.twig', [
                'order' => $order
            ]);
        }

        return $this->redirectToRoute('categories.show');
    }
}
