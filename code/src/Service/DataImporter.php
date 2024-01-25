<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class DataImporter
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function bulkInsert(array $data)
    {
        $connection = $this->em->getConnection();
        $sql = 'INSERT INTO tv_series (title, channel, gender) VALUES (?, ?, ?)';
        $stmt = $connection->prepare($sql);

        foreach ($data as $item) {
            $stmt->bindValue(1, $item['title']);
            $stmt->bindValue(2, $item['channel']);
            $stmt->bindValue(3, $item['gender']);
            $stmt->executeStatement();

            $tvSeriesId = $connection->lastInsertId();
            foreach ($item['intervals'] as $interval) {
                $sqlIntervals = 'INSERT INTO tv_series_intervals (fk_tv_series, week_day, show_time) VALUES (?, ?, ?)';

                $stmtIntervals = $connection->prepare($sqlIntervals);
                $stmtIntervals->bindValue(1, $tvSeriesId);
                $stmtIntervals->bindValue(2, $interval['week_day']);
                $stmtIntervals->bindValue(3, $interval['show_time']);

                $stmtIntervals->executeStatement();
            }
        }
    }
}
