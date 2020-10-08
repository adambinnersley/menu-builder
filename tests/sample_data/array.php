<?php

$nav_array = [
    [
        'title' => 'Second',
        'uri' => '/help',
        'link_order' => 2,
        'active' => 1
    ],
    [
        'title' => 'Google',
        'uri' => 'https://www.google.co.uk',
        'fragment' => 'help',
        'target' => '_blank',
        'rel' => 'nofollow noopener',
        'class' => null,
        'id' => 'unique-link',
    ],
    [
        'title' => 'Last',
        'uri' => '/last-link',
        'child_wrap' => ['div', 'children'],
        'children' => [
            [
                'title' => 'Hippo',
                'uri' => '/child/hippo',
                'link_order' => 2,
                'children' => [
                    [
                        'title' => 'Animal',
                        'uri' => '/child/child/animals',
                        'link_order' => 2
                    ],
                    [
                        'title' => 'Car',
                        'uri' => '/child/child/cars',
                        'link_order' => 1
                    ],
                    [
                        'title' => 'Place',
                        'uri' => '/child/child/places',
                        'link_order' => 5
                    ]
                ]
            ],
            [
                'title' => 'Turkey',
                'uri' => '/child/turkey',
                'link_order' => 1
            ],
            [
                'title' => 'Dog',
                'uri' => '/child/dog',
                'link_order' => 5
            ]
        ]
    ],
    [
        'title' => 'Home',
        'uri' => '/my-link',
        'link_order' => -1000,
        'li_class' => 'first',
        'li_id' => 'my-id',
        'font-icon' => 'fa fa-home'
    ],
    [
        'title' => 'Hello',
        'uri' => '/hello',
        'link_order' => 3,
        'ul_class' => 'sub-menu',
        'children' => [
            [
                'title' => 'Child Second',
                'uri' => '/child/help',
                'link_order' => 2,
                'children' => [
                    [
                        'title' => 'Child-child Second',
                        'uri' => '/child/child/help'
                    ],
                    [
                        'title' => 'First Child-child',
                        'uri' => '/child/child/google',
                        'link_order' => 1
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
                'link_order' => 1
            ],
            [
                'title' => 'Last Child',
                'uri' => '/child/last-link',
                'link_order' => 5
            ]
        ]
    ],
    [
        'title' => 'No Link',
        'link_order' => 1000
    ]
    
];
