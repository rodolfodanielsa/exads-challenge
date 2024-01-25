<?php

namespace App\Controller;

use App\Service\DataImporter;
use App\Service\TvSeriesService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TvSeriesController extends AbstractController
{
    public function __construct(
        private readonly DataImporter    $dataImporter,
        private readonly TvSeriesService $tvSeriesService,
    ) {
    }

    public function import(array $data): Response
    {
        $this->dataImporter->bulkInsert($data);
        return new Response('success');
    }

    #[Route('/tv/series', name: 'app_tv_series')]
    public function index(?DateTime $date = null, ?string $title = null): Response
    {
        $response = $this->tvSeriesService->nextToAir($date, $title);

        return new Response($response);
    }
}
