<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PrimeNumberService
{
    private const ONE_IS_NOT_PRIME = 1;
    private const INITIAL_RANGE = 1;
    private const END_RANGE = 100;
    private const NUMBER_OF_MULTIPLES_TO_BE_PRIME = 2;

    #[Route('/prime/number', name: 'app_prime_number')]
    public function detect(): string
    {
        $response = '';
        for ($i = self::INITIAL_RANGE; $i <= self::END_RANGE; $i++) {
            $response .= $i;

            $multiples = $this->getMultiples($i);
            $response .= $this->getIsPrimeOrMultiplesText($i, $multiples);

            $response .= "\n";
        }

        return $response;
    }

    private function getMultiples(mixed $i): array
    {
        $multiples = [];

        for ($j = 1; $j <= $i; $j++) {
            if ($i % $j === 0) {
                $multiples[] = $j;
            }
        }

        return $multiples;
    }

    private function getIsPrimeOrMultiplesText(int $i, array $multiples): string
    {
        if (count($multiples) === self::NUMBER_OF_MULTIPLES_TO_BE_PRIME) {
            return ' [PRIME]';
        }

        return ' (' . implode(', ', $multiples) . ')';
    }
}
