<?php

return [

    'states' => [
        'Berlin',
        'Bavaria',
        'Bremen',
        'Lower Saxony',
        'Baden-Wuerttemberg',
        'Rhineland-Palatinate',
        'Saxony',
        'Thueringen',
        'Hessen',
        'North Rhine-Westphalia',
        'Saxony-Anhalt',
        'Brandenburg',
        'Mecklenburg-Vorpommern',
        'Hamburg',
        'Schleswig-Holstein',
        'Saarland'
    ],

    'months' => [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',

    ],
    'MILAGE' => ['less than 500km' => 'less than 500km',
        '500km - 3.000km' => '500km - 3.000km',
        '3.000 - 10.000km' => '3.000 - 10.000km',
        'more than 10.000km' => 'more than 10.000km'
    ],
    'SERVICE' => ['This Year' => 'This Year',
        'Last Year' => 'Last Year',
        'More than 2 Years ago' => 'More than 2 Years ago',
        'Never' => 'Never'
    ],
    'CONDITION' => [
        'Very Good' => 'Very Good',
        'Good' => 'Good',
        'OK' => 'OK',
        'Poor' => 'Poor'
    ],

    'colors' => [
        1 => '#000000',
        2 => '#FFFFFF',
        3 => '#ff0000',
        4 => '#ffff00',
        5 => '#008000',
        6 => '#0000ff',
        7 => '#ffa500',
        8 => '#800080',
        9 => '#808080'
    ],

    'SHIFTING' => [
        'mechanical' => 'mechanical',
        'electronic' => 'electronic'
    ],
    'CATEGORY' => [
        0 => 'gravel',
        1 => 'race',
        2 => 'triathlon',
        3 => 'endurance',
        4 => 'cyclocross',
        5 => 'touring',
        6 => 'track',
        7 => 'general-road'
    ],
    'FrameMaterial' => [
        'carbon' => 'carbon',
        'titanium' => 'titanium',
        'steel' => 'steel',
        'aluminum' => 'aluminum',
        'magnesium' => 'magnesium'
    ],
    'BrakeType' => [
        0 => 'hydraulic',
        1 => 'mechanicalDisc',
        2 => 'rim',
        3 => 'hydraulicRim',
        4 => 'coaster'
    ],

    'service_fee' => [
        0 => ['name' => 'basic', 'price' => 30],
        1 => ['name' => 'plus', 'price' => 100],
        2 => ['name' => 'premium', 'price' => 250],
    ]
];
