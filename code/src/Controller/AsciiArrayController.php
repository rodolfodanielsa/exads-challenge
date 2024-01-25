<?php

namespace App\Controller;

use App\Service\AsciiArrayService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AsciiArrayController extends AbstractController
{
    public function __construct(private AsciiArrayService $asciiArrayService)
    {
    }

    #[Route('/ascii', name: 'app_ascii_array')]
    public function index(): Response
    {
        $detectMissingChar = $this->asciiArrayService->detectMissingChar();

        return new Response($detectMissingChar);
    }
}
