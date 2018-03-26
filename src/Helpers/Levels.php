<?php
namespace Menu\Helpers;

use RecursiveIteratorIterator;
use RecursiveArrayIterator;

class Levels {
    protected static $navItem;
    
    protected static $currentItems = [];

    /**
     * Creates the current menu items which are selected from the navigation item hierarchy
     */
    public static function getCurrent($navigation, $current) {
        self::iterateItems($navigation);
        foreach(self::$navItem as $item) {
            if($item === $current) {
                self::getCurrentItem(intval(floor(self::$navItem->getDepth() / 2)));
            }
        }
        ksort(self::$currentItems);
        return self::$currentItems;
    }
    
    /**
     * Gets the current level items from the menu array
     * @param int $depth This should be the depth of the menu item you are setting
     */
    protected static function getCurrentItem($depth){
        self::$currentItems[$depth] = iterator_to_array(self::$navItem->getSubIterator((($depth * 2) + 1)));
        unset(self::$currentItems[$depth]['children']);
        if($depth >= 1){
            self::getCurrentItem(($depth - 1));
        }
    }
    
    /**
     * Returns the iterated array object
     * @param object $navigation
     */
    protected static function iterateItems($navigation) {
        self::$navItem = new RecursiveIteratorIterator(new RecursiveArrayIterator($navigation));
    }
}
