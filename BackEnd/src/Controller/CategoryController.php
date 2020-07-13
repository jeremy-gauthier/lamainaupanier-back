<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class CategoryController extends AbstractController
{
    //Find all categories with associate product types:
    /**
     * @Route("/categories", name="categories_list", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository)
    {
       return $this->json($categoryRepository->findAll(), 200, [], ['groups' => 'categories:list']);
    }

    //Find one category with associate product types:
    /**
     * @Route("/category/{id}", name="category_show", methods={"GET"})
     */
    public function show(CategoryRepository $categoryRepository, Category $category)
    {
        return $this->json($categoryRepository->find($category), 200, [], ['groups' => 'category:show']);
    }
}
