<?php
namespace Menu\Builder;

use Menu\Helpers\URI;

class Link {
    
    public static $dropdownLinkExtras = false;
    
    public static $caretElement = false;
    
    public static $linkDefaults = [];
    
    
    /**
     * Returns the HTML title element
     * @param array $link This should be an array containing all of the set link values
     * @return string
     */
    public static function title($link) {
        return ' title="'.trim(isset($link['title']) && !empty(trim($link['title'])) ? $link['title'] : $link['label']).'"';
    }
    
    /**
     * Returns the link target tag element
     * @param array $link This should be an array containing all of the set link values
     * @return string|false If target element is set will return string else returns false
     */
    public static function target($link) {
        if(isset($link['target']) && is_string($link['target'])) {
            return ' target="'.$link['target'].'"';
        }
        return false;
    }
    
    /**
     * Returns the link rel element
     * @param array $link This should be an array containing all of the set link values
     * @return string|false If rel element is set will return string else returns false
     */
    public static function rel($link) {
        if(isset($link['rel']) && is_string($link['rel'])) {
            return ' rel="'.$link['rel'].'"';
        }
        return false;
    }
    
    /**
     * Returns the link label element
     * @param array $link This should be an array containing all of the set link values
     * @return string Returns a valid string from the link label 
     */
    public static function label($link) {
        if(isset($link['label']) && !empty(trim($link['label']))) {
            return trim($link['label']);
        }
        return trim($link['title']);
    }

    /**
     * Returns the link href element
     * @param array $link This should be an array containing all of the set link values
     * @return string|false Returns the HTML href element if the uri or fragment information is set
     */
    public static function href($link) {
        if(isset($link['uri']) || isset($link['fragment'])) {
            return ' href="'.URI::getHref($link).'"';
        }
        return false;
    }

    /**
     * Returns the HTML class element 
     * @param string $class Should be a string containing the classes to add
     * @param string $activeClass If the link is active the active class will be set else will be empty
     * @return string|false If element is set and is valid will return the HTML element else return false
     */
    public static function htmlClass($class, $activeClass) {
        if((isset($class) && is_string($class) && !empty(trim($class))) || (is_string($activeClass) && !empty(trim($activeClass)))) {
            return ' class="'.trim(trim($class).' '.$activeClass).'"';
        }
        return false;
    }

    /**
     * Returns the HTML id element
     * @param string $id Should be a string containing the HTML id
     * @return string|false If element is set and is valid will return the HTML element else return false
     */
    public static function htmlID($id) {
        if(isset($id) && is_string($id) && !empty(trim($id))) {
            return ' id="'.trim($id).'"';
        }
        return false;
    }
    
    /**
     * Inserts a given font ion in a span class
     * @param string $class This should be the font class(es) to apply to the element
     * @return string|boolean If the font icon is set will return a string else will return false
     */
    public static function fontIcon($class){
        if(is_string($class) && !empty(trim($class))){
            return '<span class="'.trim($class).'"></span> ';
        }
        return false;
    }

    /**
     * Returns a formatted link with all of the attributes 
     * @param array $link This should be an array containing all of the set link values
     * @param string $activeClass If the link is active should have the active class string set else should be empty
     * @param boolean If the element has any child elements set to true else set to false
     * @return string The HTML link element will be returned
     */
    public static function formatLink($link, $activeClass, $hasChild = false, $breadcrumbLink = false) {
        return "<a".self::href($link).self::title($link).self::htmlClass(($breadcrumbLink ? '' : self::$linkDefaults['a_default'].' ').$link['class'], $activeClass).self::target($link).self::rel($link).self::htmlID($link['id']).($hasChild ? self::$dropdownLinkExtras : '').">".($breadcrumbLink ? '' : self::fontIcon($link['font-icon'])).self::label($link).($hasChild ? self::$caretElement : '')."</a>";
    }
}
