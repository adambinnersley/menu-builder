# PHP Menu Builder

Create a HTML menu and breadcrumb menu items from a PHP array

## Installation

Installation is available via [Composer/Packagist](https://packagist.org/packages/adamb/menu-builder):

```sh
composer require adamb/menu-builder
```

## License

This software is distributed under the [MIT](https://github.com/AdamB7586/menu-builder/blob/master/LICENSE) license. Please read LICENSE for information on the
software availability and distribution.

## Basic Usage

### Add Menu Items

Make a new instance of the `Navigation` menu builder
```php
<?php
$navigation = new Menu\Navigation();
```

Add some menu items
```php
// Add links individually
$navigation->addLink('Home', '/', array('link_order' => -1000));
$navigation->addLink('About Me', '/about-me', array('link_order' => 2));

// Add an array of links
$navArray = [
    [
        'title' => 'My Link',
        'uri' => '/my-link-page',
        'link_order' => 3
    ],
    [
        'title' => 'Has Children',
        'uri' => '/child/',
        'link_order' => 4
        'children' => [
            [
                'title' => 'Second Child',
                'uri' => '/child/second',
                'link_order' => 2
            ],
            [
                'title' => 'First Child',
                'uri' => '/child/first',
                'link_order' => 1
            ],
            [
                'title' => 'Last Child',
                'uri' => '/child/last',
                'link_order' => 3
            ],
        ]
    ]
];

$navigation->addLinks($navArray);
```

The addLink method allows the following:
```php
$navigation->addLink($title, $uri [, $options = []]);
```
 - `$title` Is a string that should contain the test to display on the link
 - `$uri` Is a string that should contain the link URI
 - `$options` Is an array that can contain any of the following array elements ['label', 'uri', 'fragment', 'title', 'target', 'rel', 'class', 'id', 'link_order', 'active', 'li_class', 'li_id', 'ul_class', 'ul_id', 'children']

### Set Current URI

Set the active link for the menu
```php
 $navigation->setCurrentURI('/about-me'); // Makes the about me page the current select item in the menu
```

### Render Menu

Output the menu to the screen
```php
echo($navigation->render());
```

### Render Breadcrumb Menu

Output a breadcrumb menu to the screen
```php
echo($navigation->renderBreadcrumb());
```

