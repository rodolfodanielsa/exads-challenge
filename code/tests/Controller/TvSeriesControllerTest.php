<?php

namespace App\Tests\Controller;

use App\Controller\TvSeriesController;
use App\Repository\TvSeriesRepository;
use App\Service\DataImporter;
use App\Service\TvSeriesService;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PhpUnit\ClockMock;

class TvSeriesControllerTest extends TestCase
{
    public function testTvSeriesShouldReturnTheFirstShowWithSameWeekDayDefaultDateIfNoDateInput(): void
    {
        ClockMock::register(TvSeriesService::class);
        $currentDateTime = new \DateTimeImmutable('2024-01-22 12:00:00');
        ClockMock::withClockMock($currentDateTime->getTimestamp());

        $dataImporter = $this->createMock(DataImporter::class);
        $tvSeriesRepo = $this->createMock(TvSeriesRepository::class);
        $result = new \ArrayObject([
            [
                'title' => 'Naruto',
                'week_day' => 1,
                'show_time' => '22:00',
            ],
            [
                'title' => 'Suits',
                'week_day' => 2,
                'show_time' => '22:00',
            ]
        ]);
        $tvSeriesRepo->method('findTvSeriesByInterval')
            ->willReturn($result);

        $tvSeriesService = new TvSeriesService($tvSeriesRepo);
        $controller = new TvSeriesController($dataImporter, $tvSeriesService);

        $response = $controller->index();
        $this->assertEquals(
            'Next show(s) to be aired:'
            . "\n" . '- Naruto, on Monday, January 22, 2024 22:00',
            $response->getContent()
        );
        ClockMock::withClockMock(false);
    }

    public function testTvSeriesShouldReturnTheFirstShowAiringAtSameTimeWithSameWeekDayAsInputDate(): void
    {
        ClockMock::register(TvSeriesService::class);
        $currentDateTime = new \DateTimeImmutable('2024-01-22 12:00:00');
        ClockMock::withClockMock($currentDateTime->getTimestamp());

        $dataImporter = $this->createMock(DataImporter::class);
        $tvSeriesRepo = $this->createMock(TvSeriesRepository::class);
        $result = new \ArrayObject([
            [
                'title' => 'Naruto',
                'week_day' => 1,
                'show_time' => '22:00',
            ],
            [
                'title' => 'Sherlock Holmes',
                'week_day' => 1,
                'show_time' => '22:00',
            ],
            [
                'title' => 'Suits',
                'week_day' => 2,
                'show_time' => '22:00',
            ]
        ]);
        $tvSeriesRepo->method('findTvSeriesByInterval')
            ->willReturn($result);

        $tvSeriesService = new TvSeriesService($tvSeriesRepo);
        $controller = new TvSeriesController($dataImporter, $tvSeriesService);

        $response = $controller->index();
        $this->assertEquals(
            'Next show(s) to be aired:'
            . "\n" . '- Naruto, on Monday, January 22, 2024 22:00'
            . "\n" . '- Sherlock Holmes, on Monday, January 22, 2024 22:00',
            $response->getContent()
        );
        ClockMock::withClockMock(false);
    }

    public function testTvSeriesShouldReturnTheSameDateAsInputDate(): void
    {
        ClockMock::register(TvSeriesService::class);
        $currentDateTime = new \DateTimeImmutable('2024-01-22 12:00:00');
        ClockMock::withClockMock($currentDateTime->getTimestamp());

        $dataImporter = $this->createMock(DataImporter::class);
        $tvSeriesRepo = $this->createMock(TvSeriesRepository::class);
        $result = new \ArrayObject([
            [
                'title' => 'Suits',
                'week_day' => 2,
                'show_time' => '22:00',
            ],
            [
                'title' => 'CSI',
                'week_day' => 3,
                'show_time' => '21:00',
            ]
        ]);
        $tvSeriesRepo->method('findTvSeriesByInterval')
            ->willReturn($result);

        $tvSeriesService = new TvSeriesService($tvSeriesRepo);
        $controller = new TvSeriesController($dataImporter, $tvSeriesService);

        $response = $controller->index(new \DateTime('2024-12-31 10:00'));
        $this->assertEquals(
            'Next show(s) to be aired:'
            . "\n" . '- Suits, on Tuesday, December 31, 2024 22:00',
            $response->getContent()
        );
        ClockMock::withClockMock(false);
    }

    public function testTvSeriesShouldReturnTheSameDateAsInputDateInThePast(): void
    {
        ClockMock::register(TvSeriesService::class);
        $currentDateTime = new \DateTimeImmutable('2024-01-22 12:00:00');
        ClockMock::withClockMock($currentDateTime->getTimestamp());

        $dataImporter = $this->createMock(DataImporter::class);
        $tvSeriesRepo = $this->createMock(TvSeriesRepository::class);
        $result = new \ArrayObject([
            [
                'title' => 'Naruto',
                'week_day' => 1,
                'show_time' => '20:00',
            ],
            [
                'title' => 'CSI',
                'week_day' => 3,
                'show_time' => '21:00',
            ]
        ]);
        $tvSeriesRepo->method('findTvSeriesByInterval')
            ->willReturn($result);

        $tvSeriesService = new TvSeriesService($tvSeriesRepo);
        $controller = new TvSeriesController($dataImporter, $tvSeriesService);

        $response = $controller->index(new \DateTime('2023-12-25 10:00'));
        $this->assertEquals(
            'Next show(s) to be aired:'
            . "\n" . '- Naruto, on Monday, December 25, 2023 20:00',
            $response->getContent()
        );
        ClockMock::withClockMock(false);
    }

    public function testTvSeriesShouldReturnTheFirstShowToAirInTheWeekDueToInputDateNotReturningResults(): void
    {
        ClockMock::register(TvSeriesService::class);
        $currentDateTime = new \DateTimeImmutable('2024-01-22 12:00:00');
        ClockMock::withClockMock($currentDateTime->getTimestamp());

        $dataImporter = $this->createMock(DataImporter::class);
        $tvSeriesRepo = $this->createMock(TvSeriesRepository::class);
        $result = new \ArrayObject([
            [
                'title' => 'Naruto',
                'week_day' => 1,
                'show_time' => '22:00',
            ],
            [
                'title' => 'CSI',
                'week_day' => 3,
                'show_time' => '21:00',
            ]
        ]);
        $tvSeriesRepo->method('findTvSeriesByInterval')
            ->willReturn($result);

        $tvSeriesService = new TvSeriesService($tvSeriesRepo);
        $controller = new TvSeriesController($dataImporter, $tvSeriesService);

        $response = $controller->index(new \DateTime('2024-01-27 10:00'));
        $this->assertEquals(
            'Next show(s) to be aired:'
            . "\n" . '- Naruto, on Monday, January 29, 2024 22:00',
            $response->getContent()
        );
        ClockMock::withClockMock(false);
    }

    public function testTvSeriesShouldReturnTheFirstShowWithSameWeekDayDefaultDateIfNoDateInputWithGivenTitle(): void
    {
        ClockMock::register(TvSeriesService::class);
        $currentDateTime = new \DateTimeImmutable('2024-01-22 12:00:00');
        ClockMock::withClockMock($currentDateTime->getTimestamp());

        $dataImporter = $this->createMock(DataImporter::class);
        $tvSeriesRepo = $this->createMock(TvSeriesRepository::class);
        $result = new \ArrayObject([
            [
                'title' => 'CSI',
                'week_day' => 3,
                'show_time' => '21:00',
            ]
        ]);
        $tvSeriesRepo->method('findTvSeriesByTitle')
            ->willReturn(true);
        $tvSeriesRepo->method('findTvSeriesByIntervalAndTitle')
            ->willReturn($result);

        $tvSeriesService = new TvSeriesService($tvSeriesRepo);
        $controller = new TvSeriesController($dataImporter, $tvSeriesService);

        $response = $controller->index(null, 'CSI');
        $this->assertEquals(
            'Next show(s) to be aired:'
            . "\n" . '- CSI, on Wednesday, January 24, 2024 21:00',
            $response->getContent()
        );
        ClockMock::withClockMock(false);
    }

    public function testTvSeriesShouldReturnNotExistingMessageWhenTitleDoesNotExist(): void
    {
        $dataImporter = $this->createMock(DataImporter::class);
        $tvSeriesRepo = $this->createMock(TvSeriesRepository::class);

        $tvSeriesRepo->method('findTvSeriesByTitle')
            ->willReturn(false);

        $tvSeriesService = new TvSeriesService($tvSeriesRepo);
        $controller = new TvSeriesController($dataImporter, $tvSeriesService);

        $response = $controller->index(null, 'CSI');
        $this->assertEquals('Tv Series CSI does not exist',
            $response->getContent()
        );
    }
}
