<?php

namespace Menu;

use Menu\Builder\Menu;
use Menu\Builder\Breadcrumb;
use Menu\Helpers\Sorting;
use Menu\Helpers\Levels;
use InvalidArgumentException;

class Navigation {
    
    /**
     * This should be the array of navigation items
     * @var array 
     */
    protected $navigation = [];
    
    /**
     * The elements to assign to the navigation element
     * @var array 
     */
    protected $elements = ['ul_class' => 'nav navbar-nav', 'ul_id' => ''];
    
    /**
     * The class that should be assigned on active link elements
     * @var string 
     */
    protected $activeClass = 'active';
    
    /**
     * The URI of the current page
     * @var string 
     */
    protected $currentURI;
    
    /**
     * The array of current link levels
     * @var array 
     */
    protected $currentArray = [];
    
    /**
     * The level to start the navigation element on
     * @var int 
     */
    public $startLevel = 0;
    
    /**
     * The maximum number of levels to display in the navigation
     * @var int 
     */
    public $maxLevels = 4;
    
    protected $allowedElements = ['label', 'uri', 'fragment', 'title', 'target', 'rel', 'class', 'id', 'order', 'active', 'li_class', 'li_id', 'ul_class', 'ul_id', 'children'];

    /**
     * Constructor
     * @param array|false $navArray This should be the array of navigation items
     * @param string $currentUri This should be the current URI
     */
    public function __construct($navArray = false, $currentUri = '') {
        if (is_array($navArray)) {
            $this->addLinks($navArray);
        }
        if(!empty(trim($currentUri))){
            $this->setCurrentURI($currentUri);
        }
    }
    
    /**
     * Set the main navigation UL class
     * @param string|false $class This should be a string containing the class you want to set on the main UL element
     * @return $this
     */
    public function setNavigationClass($class) {
        if(is_string($class) && !empty(trim($class))){
            $this->elements['ul_class'] = $class;
        }
        if((is_string($class) && empty(trim($class))) || $class === false){
            $this->elements['ul_class'] = '';
        }
        return $this;
    }
    
    /**
     * Returns the navigation class
     * @return string|false If the navigation class is set will return a string else will return false
     */
    public function getNavigationClass() {
        if(is_string($this->elements['ul_class'])){
            return $this->elements['ul_class'];
        }
    }
    
    /**
     * Set the main navigation ID element
     * @param string $id This should be a string containing the id you want to set on the main UL element
     * @return $this
     */
    public function setNavigationID($id) {
        if(is_string($id) && !empty(trim($id))){
            $this->elements['ul_id'] = $id;
        }
        if((is_string($id) && empty(trim($id))) || $id === false){
            $this->elements['ul_id'] = '';
        }
        return $this;
    }
    
    /**
     * Returns the navigation ID
     * @return string|false If the navigation id is set will return a string else will return false
     */
    public function getNavigationID() {
        if(is_string($this->elements['ul_id'])){
            return $this->elements['ul_id'];
        }
    }
    
    /**
     * Sets the active class for links elements
     * @param string $class This should be the class(es) you want to assign to active elements
     * @return $this
     */
    public function setActiveClass($class){
        if(is_string($class) && !empty(trim($class))){
            $this->activeClass = $class;
        }
        return $this;
    }
    
    /**
     * Returns the class to assign to active elements 
     * @return string
     */
    public function getActiveClass(){
        return $this->activeClass;
    }
    
    /**
     * Sets the current active URI
     * @param string $uri This should be the string URI of the active link
     * @return $this
     */
    public function setCurrentURI($uri) {
        if(is_string($uri) && !empty(trim($uri))){
            $this->currentURI = $uri;
            $this->currentArray = Levels::getCurrent($this->navigation, $this->currentURI);
        }
        else{
            throw new InvalidArgumentException(
                '$uri must be a valid string when seting the current URI'
            );
        }
        return $this;
    }
    
    /**
     * This will be the string of the set active URI
     * @return string
     */
    public function getCurrentURI() {
        return $this->currentURI;
    }
    
    /**
     * Sets the start level for the navigation menu
     * @param int $level The level to start the navigation menu
     * @return $this
     */
    public function setStartLevel($level){
        if(is_int($level)) {
            $this->startLevel = $level;
        }
        return $this;
    }
    
    /**
     * Returns the starting level
     * @return int
     */
    public function getStartLevel(){
        return $this->startLevel;
    }
    
    /**
     * Sets the maximum number of levels to display in the navigation 
     * @param int $levels The number of levels to display
     * @return $this
     */
    public function setMaxLevels($levels){
        if(is_int($levels)) {
            $this->maxLevels = ($levels - 1);
        }
        return $this;
    }
    
    /**
     * Returns the maximum number of levels
     * @return int
     */
    public function getMaxLevels() {
        return ($this->maxLevels + 1);
    }
    
    /**
     * Add link(s) to the existing navigation array
     * @param string $label This should be the link text
     * @param string $uri This should be the link URI 
     * @param array $additionalInfo This should be the link array information
     * @return $this
     */
    public function addLink($label, $uri, $additionalInfo = []) {
        if(is_string($label) && !empty(trim($label)) && is_string($uri) && is_array($additionalInfo)){
            $linkInfo[0] = array_intersect_key($additionalInfo, array_flip($this->allowedElements));
            $linkInfo[0]['uri'] = $uri;
            $linkInfo[0]['label'] = $label;
        }
        else{
            throw new InvalidArgumentException(
               'Link must contain a valid string for $label and $uri, additional information must be sent as an array'
            );
        }
        return $this->addLinks($linkInfo);
    }
    
    /**
     * Add link(s) to the existing navigation array
     * @param array $array This should be the link array information
     * @return $this
     */
    public function addLinks($array) {
        if (is_array($array)) {
            $navArray = array_merge($this->navigation, $array);
            $this->navigation = Sorting::sort($navArray);
            if(!empty(trim($this->getCurrentURI()))){$this->setCurrentURI($this->getCurrentURI());}
        }
        return $this;
    }
    
    /**
     * Checks to see if a link exists within the current navigation array
     * @param string $link The link you are checking to see if the exists in the array
     * @return boolean If the link exists returns true else returns false
     */
    public function hasLink($link) {
        $found = false;
        array_walk_recursive($this->navigation, function($value, $key) use (&$found, $link) {
            if ($value == $link && $key === 'uri') {
                $found = true;
            }
        });
        return $found;
    }
    
    /**
     * Checks to see if an array of links exist within the current navigation array
     * @param array $array an array containing the links
     * @return boolean If all of the links exist within the current navigation array return true else returns false
     */
    public function hasLinks($array) {
        if(is_array($array)) {
            foreach($array as $link) {
                if($this->hasLink($link) === false) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }
    
    /**
     * Returns the navigation array
     * @return array Returns the current array containing all of the navigation elements
     */
    public function toArray() {
        return $this->navigation;
    }

    /**
     * Returns the HTML navigation string
     * @return string THe formatted menu item will be returned
     */
    public function render() {
        return Menu::build($this->navigation, $this->elements, $this->currentArray, $this->getActiveClass(), $this->getStartLevel(), $this->getMaxLevels());
    }
    
    /**
     * Renders a breadcrumb menu
     * @param string $class The class to assign to the element
     * @param string $itemClass The class to assign to each item
     * @param boolean $list If the menu is a list set to true else set to false
     * @return string
     */
    public function renderBreadcrumb($class = 'breadcrumb', $itemClass = 'breadcrumb-item', $list = true) {
        $breadcrumb = new Breadcrumb();
        $breadcrumb->navArray = $this->navigation;
        return $breadcrumb->setBreacrumbLinks($this->currentArray)->createBreadcrumb($class, $itemClass, $list);
    }
}
