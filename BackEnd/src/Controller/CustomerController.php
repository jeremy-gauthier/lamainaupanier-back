<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api")
 */
class CustomerController extends AbstractController
{
    //Show all customer infos:
    /**
     * @Route("/customer/{id}", name="customer_show", methods={"GET"})
     */
    public function show(Customer $customer,CustomerRepository $customerRepository)
    {
        return $this->json($customerRepository->find($customer), 200, [], ['groups' => 'customer:show']);
    }

    //Show all customer commands:
    /**
     * @Route("/customer/{id}/commands", name="customer_commands", methods={"GET"})
     */
    public function commands(Customer $customer,CustomerRepository $customerRepository)
    {
        return $this->json($customerRepository->find($customer), 200, [], ['groups' => 'customer:commands']);
    }

    //Find all customer subscriptions:
    /**
     * @Route("/customer/{id}/subscriptions", name="customer_sub", methods={"GET"})
     */
    public function subscriptions(Customer $customer,CustomerRepository $customerRepository)
    {
            return $this->json($customerRepository->find($customer), 200, [], ['groups' => 'customer:sub']);
    }


// à voir si besoin de rajouter des routes à l'api, les routes en dessous sont un peu optionnelles pour l'instant


    /**
     * @Route("/customer/{id}/basket", name="customer_basket", methods={"GET"})
     */
    public function customer_basket()
    {
        return $this->render('customer_basket/index.html.twig', [
            'controller_name' => 'CustomerController',
        ]);
    }

    /**
     * @Route("/customer/{id}/profile", name="customer_profile", methods={"GET, POST"})
     */
    public function customer_profile()
    {
        return $this->render('customer_profile/index.html.twig', [
            'controller_name' => 'CustomerController',
        ]);
    }

    /**
     * @Route("/customer/{id}/newsletters", name="customer_newsletters", methods={"GET"})
     */
    public function customer_newsletters()
    {
        return $this->render('customer_newsletters/index.html.twig', [
            'controller_name' => 'CustomerController',
        ]);
    }
}
