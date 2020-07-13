<?php

namespace App\Controller;

use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class PaymentController extends AbstractController
{
    //Find all payment methods:
    /**
     * @Route("/payments", name="payments_list", methods={"GET"})
     */
    public function index(PaymentRepository $paymentRepository)
    {
        return $this->json($paymentRepository->findAll(), 200, [], ['groups' => 'payments:list']);
    }
}
