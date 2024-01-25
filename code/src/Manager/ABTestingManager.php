<?php

namespace App\Manager;

use Exads\ABTestData;
use Exception;

class ABTestingManager
{
    private ?ABTestData $aBTestData;

    public function createABTestingByPromoId(int $promoId): void
    {
        try {
            $this->aBTestData = new ABTestData($promoId);
        } catch (Exception $e) {
            $this->aBTestData = null;
        }
    }

    public function getDesignByPercentage(int $randomNumber): array
    {
        if ($this->aBTestData === NULL) {
            return [];
        }

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
