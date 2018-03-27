<?php

namespace Menu\Builder;

use Menu\Builder\Link;

class Menu {
    
    /**
     * Creates a menu level
     * @param array $array This should be an array of the menu items 
     * @param int $level
     * @param array $elements This should be an array containing any attributes to add to the main UL element
     * @return string Returns the HTML menu string
     */
    protected static function createMenuLevel($array, $level, $elements = [], $currentItems = [], $activeClass = 'active', $startLevel = 0, $numLevels = 2){
        $menu = ($level >= $startLevel ? '<ul'.Link::htmlClass($elements['ul_class'], '').Link::htmlID($elements['ul_id']).'>' : '');
        foreach($array as $item){
            $active = ($currentItems[$level]['uri'] === $item['uri'] ? trim($activeClass) : '');
            $menu.= ($level >= $startLevel || $currentItems[$level]['uri'] === $item['uri'] ? ($level < $startLevel && $currentItems[$level]['uri'] === $item['uri'] ? (is_array($item['children']) ? self::createMenuLevel($item['children'], ($level + 1), $elements, $currentItems, $activeClass, $startLevel, $numLevels) : '') : (((isset($item['active']) && boolval($item['active']) === true) || !isset($item['active'])) ? '<li'.Link::htmlClass($item['li_class'], $active).Link::htmlID($item['li_id']).'>'.Link::formatLink($item, $active).(is_array($item['children']) && $level < ($startLevel + $numLevels) ? self::createMenuLevel($item['children'], ($level + 1), $item, $currentItems, $activeClass, $startLevel, $numLevels) : '').'</li>' : '')) : '');
        }
        $menu.= ($level >= $startLevel ? '</ul>' : '');
        return $menu;
    }

    /**
     * Build the navigation menu item
     * @param array $array This should be an array of the menu items
     * @param array $elements This should be an array containing any attributes to add to the main UL element
     * @return string Returns the HTML menu string
     */
    public static function build($array, $elements = [], $currentItems = [], $activeClass = 'active', $startLevel = 0, $numLevels = 2) {
        return self::createMenuLevel($array, 0, $elements, $currentItems, $activeClass, $startLevel, $numLevels);
    }
}
