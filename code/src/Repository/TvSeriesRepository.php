<?php

namespace App\Repository;

use App\Entity\TvSeries;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TvSeries>
 *
 * @method TvSeries|null find($id, $lockMode = null, $lockVersion = null)
 * @method TvSeries|null findOneBy(array $criteria, array $orderBy = null)
 * @method TvSeries[]    findAll()
 * @method TvSeries[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TvSeriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TvSeries::class);
    }

    public function findTvSeriesByInterval(int $weekDay, string $showTime): \Traversable
    {
        $connection = $this->getEntityManager()->getConnection();

        $query = 'SELECT title, week_day, show_time
FROM tv_series tvs
    INNER JOIN tv_series_intervals tvsi ON tvs.id = tvsi.fk_tv_series
WHERE CONCAT(week_day, " ", show_time) >= CONCAT(:week_day, " ", :show_time) 
    ORDER BY week_day, show_time ASC';

        $parameters = [
            'week_day' => $weekDay,
            'show_time' => $showTime,
        ];

        return $connection->executeQuery($query, $parameters)->iterateAssociative();
    }

    public function getFirstTvSeriesToAirByDayOfTheWeek(): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $query = 'SELECT title, week_day, show_time
FROM tv_series tvs
    INNER JOIN tv_series_intervals tvsi ON tvs.id = tvsi.fk_tv_series
    ORDER BY week_day, show_time ASC';

        return $connection->executeQuery($query, [])->fetchAssociative();
    }

    public function findTvSeriesByIntervalAndTitle(int $weekDay, string $showTime, string $title): ?\Traversable
    {
        $connection = $this->getEntityManager()->getConnection();

        $query = 'SELECT title, week_day, show_time
FROM tv_series tvs
    INNER JOIN tv_series_intervals tvsi ON tvs.id = tvsi.fk_tv_series
WHERE CONCAT(week_day, " ", show_time) >= CONCAT(:week_day, " ", :show_time) AND title = :title 
    ORDER BY week_day, show_time ASC';

        $parameters = [
            'week_day' => $weekDay,
            'show_time' => $showTime,
            'title' => $title,
        ];

        return $connection->executeQuery($query, $parameters)->iterateAssociative();
    }

    public function findTvSeriesByTitle(string $title): bool
    {
        $connection = $this->getEntityManager()->getConnection();

        $query = 'SELECT title, week_day, show_time
FROM tv_series tvs
    INNER JOIN tv_series_intervals tvsi ON tvs.id = tvsi.fk_tv_series
WHERE title = :title
GROUP BY title';

        $parameters = [
            'title' => $title,
        ];

        return $connection->executeQuery($query, $parameters)->fetchOne() ?? false;
    }
}
