<?php

namespace App\Controller;

use App\Repository\MeasureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class MeasureController extends AbstractController
{
    //Find all Measure 's units:
    /**
     * @Route("/measures", name="measures_list", methods={"GET"})
     */
    public function index(MeasureRepository $measureRepository)
    {
        return $this->json($measureRepository->findAll(), 200, [], ['groups' => 'measures:list']);
    }
}

