<?php

namespace App\Controller;

use App\Service\PrimeNumberService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrimeNumberController extends AbstractController
{
    public function __construct(private readonly PrimeNumberService $primeNumberService)
    {
    }

    #[Route('/prime/number', name: 'app_prime_number')]
    public function index(): Response
    {
        $response = $this->primeNumberService->detect();

        return new Response($response);
    }
}
