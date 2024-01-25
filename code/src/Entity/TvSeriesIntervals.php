<?php

namespace App\Entity;

use App\Repository\TvSeriesIntervalsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TvSeriesIntervalsRepository::class)]
class TvSeriesIntervals
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'tvSeriesInterval')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TvSeries $fk_tv_series = null;

    #[ORM\Column]
    private ?int $week_day = null;

    #[ORM\Column(length: 5)]
    private ?string $show_time = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getFkTvSeries(): ?TvSeries
    {
        return $this->fk_tv_series;
    }

    public function setFkTvSeries(?TvSeries $fk_tv_series): static
    {
        $this->fk_tv_series = $fk_tv_series;

        return $this;
    }

    public function getWeekDay(): ?int
    {
        return $this->week_day;
    }

    public function setWeekDay(int $week_day): static
    {
        $this->week_day = $week_day;

        return $this;
    }

    public function getShowTime(): ?string
    {
        return $this->show_time;
    }

    public function setShowTime(string $show_time): static
    {
        $this->show_time = $show_time;

        return $this;
    }
}
