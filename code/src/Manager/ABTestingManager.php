<?php

namespace App\Manager;

use Exads\ABTestData;

class ABTestingManager
{
    private ABTestData $aBTestData;

    public function createABTestingByPromoId(int $promoId): void
    {
        $this->aBTestData = new ABTestData($promoId);
    }

    public function getDesignByPercentage(int $randomNumber): array
    {
        $designs = $this->getDesigns();
        $cumulativePercentage = 0;

        foreach ($designs as $design) {
            $cumulativePercentage += $design['splitPercent'];

            if ($randomNumber <= $cumulativePercentage) {
                return $design;
            }
        }

        return [];
    }

    // set as public for testing purposes. Not ideal.
    public function getDesigns(): array
    {
        return $this->aBTestData->getAllDesigns();
    }
}
