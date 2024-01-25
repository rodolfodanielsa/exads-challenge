<?php

namespace App\Tests\Controller;

use App\Controller\ABTestingController;
use App\Manager\ABTestingManager;
use App\Service\ABTestingService;
use PHPUnit\Framework\TestCase;

class ABTestingControllerTest extends TestCase
{
    public function testShouldReturnEmptyIfNoDesignsAreReturned(): void
    {
        $manager = $this->createPartialMock(
            ABTestingManager::class,
            ['getDesigns']
        );

        $manager->method('getDesigns')
            ->willReturn([]);

        $service = new ABTestingService($manager);
        $controller = new ABTestingController($service);

        $promoId = 1;

        $response = $controller->index($promoId);
        $this->assertEquals(json_encode([], JSON_THROW_ON_ERROR), $response->getContent());
    }

    public function testShouldReturnDesign1ForPromoId1AndPercentageIs63(): void
    {
        $manager = $this->createPartialMock(
            ABTestingManager::class,
            ['getDesigns']
        );

        $manager->method('getDesigns')
            ->willReturn([
                [ 'designId' => 1, 'designName' => 'Design 1', 'splitPercent' => 65 ],
                [ 'designId' => 2, 'designName' => 'Design 2', 'splitPercent' => 15 ],
                [ 'designId' => 3, 'designName' => 'Design 3', 'splitPercent' => 20 ],
            ]);

        $service = $this->getMockBuilder(ABTestingService::class)
            ->setConstructorArgs([$manager])
            ->onlyMethods(['getRandomGeneratedNumber'])
            ->getMock();

        $service->method('getRandomGeneratedNumber')->willReturn(63);
        $controller = new ABTestingController($service);

        $promoId = 1;

        $response = $controller->index($promoId);
        $this->assertEquals(
            json_encode(['designId' => 1, 'designName' => 'Design 1', 'splitPercent' => 65], JSON_THROW_ON_ERROR),
            $response->getContent()
        );
    }

    public function testShouldReturnDesign3ForPromoId1AndPercentageIs85(): void
    {
        $manager = $this->createPartialMock(
            ABTestingManager::class,
            ['getDesigns']
        );

        $manager->method('getDesigns')
            ->willReturn([
                [ 'designId' => 1, 'designName' => 'Design 1', 'splitPercent' => 65 ],
                [ 'designId' => 2, 'designName' => 'Design 2', 'splitPercent' => 15 ],
                [ 'designId' => 3, 'designName' => 'Design 3', 'splitPercent' => 20 ],
            ]);

        $service = $this->getMockBuilder(ABTestingService::class)
            ->setConstructorArgs([$manager])
            ->onlyMethods(['getRandomGeneratedNumber'])
            ->getMock();

        $service->method('getRandomGeneratedNumber')->willReturn(85);
        $controller = new ABTestingController($service);

        $promoId = 1;
        $response = $controller->index($promoId);

        $this->assertEquals(
            json_encode(['designId' => 3, 'designName' => 'Design 3', 'splitPercent' => 20], JSON_THROW_ON_ERROR),
            $response->getContent()
        );
    }
}
