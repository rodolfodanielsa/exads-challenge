<?php

namespace App\Controller;

use App\Service\ABTestingService;
use Exads\ABTestData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ABTestingController extends AbstractController
{
    public function __construct(private ABTestingService $ABTestingService)
    {
    }

    #[Route('/a/b/testing', name: 'app_a_b_testing')]
    public function index(int $promoId): Response
    {
        $response = $this->ABTestingService->getDesign($promoId);
        return new Response(implode( ' ', $response));
    }
}
