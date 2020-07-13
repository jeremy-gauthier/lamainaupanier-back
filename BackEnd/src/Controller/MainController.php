<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function home()
    {
        $data = [
            'name' => 'iPhone X',
            'price' => 1000
        ];

        return new JsonResponse($data);
        //test api, a changer plus tard 
    }

    /**
     * @Route("/local-map", name="local_map", methods={"GET"})
     */
    public function local_map()
    {
        return $this->render('main/localmap.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/search", name="search", methods={"GET"})
     */
    public function search()
    {
        return $this->render('main/search.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/contact", name="contact", methods={"GET, POST"})
     */
    public function contact()
    {
        return $this->render('main/contact.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

     /**
     * @Route("/cgv", name="cgv", methods={"GET"})
     */
    public function cgv()
    {
        return $this->render('main/cgv.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

     /**
     * @Route("/about", name="about", methods={"GET"})
     */
    public function about()
    {
        return $this->render('main/about.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
