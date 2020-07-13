<?php

namespace App\Controller;

use App\Entity\Producer;
use App\Repository\ProducerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api")
 */
class ProducerController extends AbstractController
{
    //Find all producers:
    /**
     * @Route("/producers", name="producer_list", methods={"GET"})
     */
    public function index(ProducerRepository $producerRepository)
    {
        return $this->json($producerRepository->findAll(), 200, [], ['groups' => 'producer:infos']);
    }  

    //Find one producer:
    /**
    * @Route("/producer/{id}", name="producer_show", methods={"GET"})
    */
    public function show(Producer $producer)
    {
        return $this->json($producer, 200, [], ['groups' => 'producer:infos']);
    }

    //Find all producer commands:
    /** 
     * @Route("/producer/{id}/commands", name="producer_commands", methods={"GET"})
     */
    public function producerCommands(Producer $producer)
    {
        return $this->json($producer, 200, [], ['groups' => 'producer:commands']);     
    }


// à voir si besoin de rajouter des routes à l'api, les routes en dessous sont un peu optionnelles pour l'instant

    /**
     * @Route("/producer/{id}/profile", name="producer_profile", methods={"GET, POST"})
     */
    public function producer_profile()
    {
        return $this->render('producer/producer_profile.html.twig', [
            'controller_name' => 'ProducerController',
        ]);
    }

    /**
     * @Route("/producer/{id}/clients", name="producer_allClients", methods={"GET"})
     */
    public function producer_allClients()
    {
        return $this->render('producer/producer_allClients.html.twig', [
            'controller_name' => 'ProducerController',
        ]);
    }

    /**
     * @Route("/producer/{id}/newsletter", name="producer_newsletter", methods={"GET"})
     */
    public function producer_newsletter()
    {
        return $this->render('producer/producer_newsletter.html.twig', [
            'controller_name' => 'ProducerController',
        ]);
    }

    /**
     * @Route("/producer/{id}/orders", name="producer_allOrders", methods={"GET"})
     */
    public function producer_allOrders()
    {
        return $this->render('producer/producer_allOrders.html.twig', [
            'controller_name' => 'ProducerController',
        ]);
    }

    /**
     * @Route("/producer/{id}/products", name="product_list", methods={"GET"})
     */
    public function product_list()
    {
        return $this->render('producer/product_list.html.twig', [
            'controller_name' => 'ProducerController',
        ]);
    }

    // /**
    //  * @Route("/producer/{id}/product/{id}", name="product_show", methods={"GET"})
    //  */
    // public function product_show()
    // {
    //     return $this->render('producer/product_show.html.twig', [
    //         'controller_name' => 'ProducerController',
    //     ]);
    // }
    
}

