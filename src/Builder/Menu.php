<?php

namespace Menu\Builder;

use Menu\Builder\Link;

class Menu
{
    
    /**
     * Creates a menu level
     * @param array $array This should be an array of the menu items
     * @param int $level
     * @param array $elements This should be an array containing any attributes to add to the main UL element
     * @return string Returns the HTML menu string
     */
    protected static function createMenuLevel($array, $level, $elements = [], $currentItems = [], $activeClass = 'active', $startLevel = 0, $numLevels = 2)
    {
        $menu = ($level >= $startLevel ? self::openTag($elements, '', 'ul') : '');
        foreach ($array as $item) {
            $active = (isset($currentItems[$level]['uri']) && $currentItems[$level]['uri'] === $item['uri'] ? trim($activeClass) : '');
            $has_child_elements = (isset($item['children']) && is_array($item['children']) && !empty($item['children']) && $level < ($startLevel + $numLevels) ? true : false);
            $menu.= ($level >= $startLevel || (isset($currentItems[$level]['uri']) && $currentItems[$level]['uri'] === $item['uri']) ? ($level < $startLevel && isset($currentItems[$level]['uri']) && $currentItems[$level]['uri'] === $item['uri'] ? (isset($item['children']) && is_array($item['children']) ? self::createMenuLevel($item['children'], ($level + 1), $elements, $currentItems, $activeClass, $startLevel, $numLevels) : '') : (((isset($item['active']) && boolval($item['active']) === true) || !isset($item['active'])) ? self::openTag($item, $active).Link::formatLink($item, $active, $has_child_elements).($has_child_elements ? self::wrapChildren($item, self::createMenuLevel($item['children'], ($level + 1), $item, $currentItems, $activeClass, $startLevel, $numLevels)) : '').'</li>' : '')) : '');
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
    protected static function wrapChildren($item, $children)
    {
        if (isset($item['child_wrap']) && (is_string($item['child_wrap']) || (is_array($item['child_wrap'])) && !empty($item['child_wrap']))) {
            return (is_array($item['child_wrap']) ? '<'.$item['child_wrap'][0].' class="'.$item['child_wrap'][1].'">' : '<'.$item['child_wrap'].'>').$children.(is_array($item['child_wrap']) ? '</'.$item['child_wrap'][0].'>' : '</'.$item['child_wrap'].'>');
        }
        return $children;
    }
    
    /**
     * Creates an open element for a tag and does checks
     * @param array $element This should be an array containing the elements information array
     * @param string $activeClass The active class if it should be set
     * @param string $item The element i.e. ul or li
     * @return string This will return a formatted string for the element open tag
     */
    protected static function openTag($element, $activeClass = '', $item = 'li')
    {
        return '<'.$item
            .Link::htmlClass((isset($element[$item.'_default']) ? $element[$item.'_default'].' ' : '').(isset($element[$item.'_class']) ? $element[$item.'_class'] : ''), $activeClass)
            .(isset($element[$item.'_id']) ? Link::htmlID($element[$item.'_id']) : '')
        .'>';
    }

    /**
     * Build the navigation menu item
     * @param array $array This should be an array of the menu items
     * @param array $elements This should be an array containing any attributes to add to the main UL element
     * @return string Returns the HTML menu string
     */
    public static function build($array, $elements = [], $currentItems = [], $activeClass = 'active', $startLevel = 0, $numLevels = 2, $caret = false, $linkDDExtras = false)
    {
        if (is_array($elements) && !empty($elements)) {
            Link::$linkDefaults = $elements;
        }
        if ($caret !== false && is_string($caret)) {
            Link::$caretElement = $caret;
        }
        if ($linkDDExtras !== false && is_string($linkDDExtras)) {
            Link::$dropdownLinkExtras = $linkDDExtras;
        }
        return self::createMenuLevel($array, 0, $elements, $currentItems, $activeClass, $startLevel, $numLevels);
    }
}
