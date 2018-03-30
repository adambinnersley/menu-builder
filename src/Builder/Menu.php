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
        $menu = ($level >= $startLevel ? '<ul'.Link::htmlClass($elements['ul_default'].' '.$elements['ul_class'], '').Link::htmlID($elements['ul_id']).'>' : '');
        foreach($array as $item){
            $active = ($currentItems[$level]['uri'] === $item['uri'] ? trim($activeClass) : '');
            $has_child_elements = (is_array($item['children']) && $level < ($startLevel + $numLevels) ? true : false);
            $menu.= ($level >= $startLevel || $currentItems[$level]['uri'] === $item['uri'] ? ($level < $startLevel && $currentItems[$level]['uri'] === $item['uri'] ? (is_array($item['children']) ? self::createMenuLevel($item['children'], ($level + 1), $elements, $currentItems, $activeClass, $startLevel, $numLevels) : '') : (((isset($item['active']) && boolval($item['active']) === true) || !isset($item['active'])) ? '<li'.Link::htmlClass($elements['li_default'].' '.$item['li_class'], $active).Link::htmlID($item['li_id']).'>'.Link::formatLink($item, $active, $has_child_elements).($has_child_elements ? self::wrapChildren($item, self::createMenuLevel($item['children'], ($level + 1), $item, $currentItems, $activeClass, $startLevel, $numLevels)) : '').'</li>' : '')) : '');
        }
        $menu.= ($level >= $startLevel ? '</ul>' : '');
        return $menu;
    }
    
    /**
     * Wrap any child elements in a given element
     * @param array $item This should be the menu item
     * @param string $children This should be a string of any child elements
     * @return string Will return the child elements in the wrapped element if required 
     */
    protected static function wrapChildren($item, $children){
        if((is_string($item['child_wrap']) || is_array($item['child_wrap'])) && !empty($item['child_wrap'])){
            return (is_array($item['child_wrap']) ? '<'.$item['child_wrap'][0].' class="'.$item['child_wrap'][1].'">' : '<'.$item['child_wrap'].'>').$children.(is_array($item['child_wrap']) ? '</'.$item['child_wrap'][0].'>' : '</'.$item['child_wrap'].'>');
        }
        return $children;
    }

    /**
     * Build the navigation menu item
     * @param array $array This should be an array of the menu items
     * @param array $elements This should be an array containing any attributes to add to the main UL element
     * @return string Returns the HTML menu string
     */
    public static function build($array, $elements = [], $currentItems = [], $activeClass = 'active', $startLevel = 0, $numLevels = 2, $caret = false, $linkDDExtras = false) {
        if(is_array($elements) && !empty($elements)){Link::$linkDefaults = $elements;}
        if($caret !== false && is_string($caret)){Link::$caretElement = $caret;}
        if($linkDDExtras !== false && is_string($linkDDExtras)){Link::$dropdownLinkExtras = $linkDDExtras;}
        return self::createMenuLevel($array, 0, $elements, $currentItems, $activeClass, $startLevel, $numLevels);
    }
}
