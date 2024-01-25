<?php

namespace App\Service;

use Symfony\Component\Routing\Annotation\Route;

class PrimeNumberService
{
    private const INITIAL_RANGE = 1;
    private const END_RANGE = 100;
    private const NUMBER_OF_MULTIPLES_TO_BE_PRIME = 2;

    #[Route('/prime/number', name: 'app_prime_number')]
    public function detect(): string
    {
        $response = '';
        for ($checkNumber = self::INITIAL_RANGE; $checkNumber <= self::END_RANGE; $checkNumber++) {
            $response .= $checkNumber;

            $multiples = $this->getMultiples($checkNumber);
            $response .= $this->getIsPrimeOrMultiplesText($checkNumber, $multiples);

            $response .= "\n";
        }

        return $response;
    }

    private function getMultiples(int $checkNumber): array
    {
        $multiples = [];

        for ($j = 1; $j <= $checkNumber; $j++) {
            if ($checkNumber % $j === 0) {
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
