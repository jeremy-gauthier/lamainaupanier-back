<?php

namespace App\Controller;

use App\Repository\LabelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class LabelController extends AbstractController
{
    //Find all labels:
    /**
     * @Route("/labels", name="labels_list", methods={"GET"})
     */
    public function index(LabelRepository $labelRepository)
    {
        return $this->json($labelRepository->findAll(), 200, [], ['groups' => 'labels:list']);
    }
}
