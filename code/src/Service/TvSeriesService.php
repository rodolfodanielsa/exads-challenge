<?php

namespace App\Service;

use App\Repository\TvSeriesRepository;
use DateTime;

class TvSeriesService
{
    private const WEEK_NUMBER_OF_DAYS = 7;

    public function __construct(private readonly TvSeriesRepository $tvSeriesRepository)
    {
    }

    public function nextToAir(?DateTime $inputDate, ?string $title): string
    {
        if (!$inputDate) {
            $inputDate = \DateTime::createFromFormat('U', time());
        }

        $weekDay = $inputDate->format('w');
        $showTime = $inputDate->format('H:i');

        $tvSeriesIterable = $this->getTvSeriesByCriteria($weekDay, $showTime, $title);

        if ($tvSeriesIterable === NULL) {
            return "Tv Series " . $title . " does not exist";
        }

        $nextShowsToAir = $this->getNextShowsToAir($tvSeriesIterable);

        if (empty($nextShowsToAir)) {
            $nextShowsToAir[] = $this->tvSeriesRepository->getFirstTvSeriesToAirByDayOfTheWeek();
        }

        return $this->generateResponse($nextShowsToAir, $inputDate);

    }

    private function getNextShowsToAir(\Traversable $resultIterative): array
    {
        $nextDayToAir = null;
        $nextShowsToAir = [];
        foreach ($resultIterative as $result) {
            $weekDayShowTime = $result['week_day'] . $result['show_time'];
            if (!$nextDayToAir) {
                $nextDayToAir = $weekDayShowTime;
            }

            if ($weekDayShowTime !== $nextDayToAir) {
                break;
            }

            $nextShowsToAir[] = $result;
        }

        return $nextShowsToAir;
    }

    private function generateResponse(array $nextShowsToAir, DateTime $inputDate): string
    {
        return $this->buildResponse($nextShowsToAir, $inputDate);
    }

    private function getFormattedShowTimestamp(DateTime $inputDate, mixed $show): int|false
    {
        $showDateTime = clone $inputDate;

        $inputDateWeekDay = $showDateTime->format('w');

        $showWeekDay = $show['week_day'] - $inputDateWeekDay;

        if ($showWeekDay < 0) {
            $showWeekDay += self::WEEK_NUMBER_OF_DAYS;
        }

        return strtotime("+{$showWeekDay} days" . ' ' . $show['show_time'], $showDateTime->getTimestamp());
    }

    private function buildResponse(array $nextShowsToAir, DateTime $inputDate): string
    {
        $response = "Next show(s) to be aired:";

        foreach ($nextShowsToAir as $show) {
            $formattedShowTimestamp = $this->getFormattedShowTimestamp($inputDate, $show);
            $result = date('l, F j, Y H:i', $formattedShowTimestamp);
            $response .=  "\n" .'- ' . $show['title'] . ', on ' . $result;
        }

        return $response;
    }

    private function getTvSeriesByCriteria(string $weekDay, string $showTime, ?string $title): ?\Traversable
    {
        if ($title) {
            $titleExists = $this->tvSeriesRepository->findTvSeriesByTitle($title);

            if (!$titleExists) {
                return null;
            }

            return $this->tvSeriesRepository->findTvSeriesByIntervalAndTitle($weekDay, $showTime, $title);
        }

        return $this->tvSeriesRepository->findTvSeriesByInterval($weekDay, $showTime);
    }
}
