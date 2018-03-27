<?php

$nav_array = [
    [
        'title' => 'Second',
        'uri' => '/help',
        'order' => 2,
        'active' => 1
    ],
    [
        'title' => 'Google',
        'uri' => 'https://www.google.co.uk',
        'fragment' => 'help',
        'target' => '_blank',
        'rel' => 'nofollow noopener',
        'class' => NULL,
        'id' => 'unique-link',
    ],
    [
        'title' => 'Last',
        'uri' => '/last-link',
        'children' => [
            [
                'title' => 'Hippo',
                'uri' => '/child/hippo',
                'order' => 2,
                'children' => [
                    [
                        'title' => 'Animal',
                        'uri' => '/child/child/animals',
                        'order' => 2
                    ],
                    [
                        'title' => 'Car',
                        'uri' => '/child/child/cars',
                        'order' => 1
                    ],
                    [
                        'title' => 'Place',
                        'uri' => '/child/child/places',
                        'order' => 5
                    ]
                ]
            ],
            [
                'title' => 'Turkey',
                'uri' => '/child/turkey',
                'order' => 1
            ],
            [
                'title' => 'Dog',
                'uri' => '/child/dog',
                'order' => 5
            ]
        ]
    ],
    [
        'title' => 'Home',
        'uri' => '/my-link',
        'order' => -1000,
        'liclass' => 'first',
        'liid' => 'ny-id',
    ],
    [
        'title' => 'Hello',
        'uri' => '/hello',
        'order' => 3,
        'ul_class' => 'sub-menu',
        'children' => [
            [
                'title' => 'Child Second',
                'uri' => '/child/help',
                'order' => 2,
                'children' => [
                    [
                        'title' => 'Child-child Second',
                        'uri' => '/child/child/help'
                    ],
                    [
                        'title' => 'First Child-child',
                        'uri' => '/child/child/google',
                        'order' => 1
                    ],
                    [
                        'title' => 'Last Child-child',
                        'uri' => '/child/child/last-link'
                    ]
                ]
            ],
            [
                'title' => 'First child',
                'uri' => '/child/google',
                'order' => 1
            ],
            [
                'title' => 'Last Child',
                'uri' => '/child/last-link',
                'order' => 5
            ]
        ]
    ]
];