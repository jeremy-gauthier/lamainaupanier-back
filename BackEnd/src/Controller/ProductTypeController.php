<?php

namespace App\Controller;

use App\Entity\ProductType;
use App\Repository\ProductTypeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 */
class ProductTypeController extends AbstractController
{
    //Find all product_types with associate category:
    /**
     * @Route("/product_types", name="product_type_list", methods={"GET"})
     */
    public function index(ProductTypeRepository $productTypeRepository)
    {
       return $this->json($productTypeRepository->findAll(), 200, [], ['groups' => 'producttypes:list']);
    }

    //Find one product_types with associate category:
    /**
     * @Route("/product_type/{id}", name="product_type_show", methods={"GET"})
     */
    public function show(ProductTypeRepository $productTypeRepository, ProductType $productType)
    {
        return $this->json($productTypeRepository->find($productType), 200, [], ['groups' => 'producttype:show']);
    }
}
