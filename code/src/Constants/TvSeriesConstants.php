<?php

namespace App\Constants;

class TvSeriesConstants
{
    public const TV_SERIES_DATA = [
        'Naruto' => [
            'title' => 'Naruto',
            'channel' => 'AniToon',
            'gender' => 'Animation',
            'intervals' => [
                [
                    'week_day' => 1,
                    'show_time' => '20:00',
                ],
            ]
        ],
        'Suits' => [
            'title' => 'Suits',
            'channel' => 'Fox',
            'gender' => 'Drama',
            'intervals' => [
                [
                    'week_day' => 2,
                    'show_time' => '20:30',
                ],
                [
                    'week_day' => 4,
                    'show_time' => '20:30',
                ],
            ]
        ],
        'Loki' => [
            'title' => 'Loki',
            'channel' => 'DisneyPlus',
            'gender' => 'Action',
            'intervals' => [
                [
                    'week_day' => 4,
                    'show_time' => '22:30',
                ],
            ]
        ],
        'Sherlock Holmes' => [
            'title' => 'Sherlock Holmes',
            'channel' => 'Star',
            'gender' => 'Investigation',
            'intervals' => [
                [
                    'week_day' => 5,
                    'show_time' => '22:00',
                ],
            ]
        ],

    ];
}
