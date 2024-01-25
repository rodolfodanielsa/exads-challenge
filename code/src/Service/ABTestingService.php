<?php

namespace App\Service;

use App\Manager\ABTestingManager;

class ABTestingService
{
    private const MIN = 1;
    private const MAX = 100;

    public function __construct(private readonly ABTestingManager $aBTestingManager)
    {
    }

    public function getDesign(int $promoId): array
    {
        $this->aBTestingManager->createABTestingByPromoId($promoId);
        $randomGeneratedNumber = $this->getRandomGeneratedNumber();

        return $this->aBTestingManager->getDesignByPercentage($randomGeneratedNumber);
    }

    // set as public for testing purposes. Not ideal.
    public function getRandomGeneratedNumber(): int
    {
        return random_int(self::MIN, self::MAX);
    }
}
