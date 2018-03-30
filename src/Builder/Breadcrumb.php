<?php
namespace Menu\Builder;

use Menu\Builder\Link;

class Breadcrumb {
    
    /**
     * This should be the complete navigation array
     * @var array
     */
    public $navArray = [];
    
    /**
     * This is the breadcrumb items
     * @var array
     */
    public $links = [];
    
    /**
     *This is the separator for any breadcrumb items that aren't in the list format 
     * @var string 
     */
    public $separator = ' &gt; ';
    
    /**
     * The type of element that the breadcrumb is normally UL or OL
     * @var string 
     */
    public $breadcrumbElement = 'ul';
    
    /**
     *This should be the class to set on active elements
     * @var string 
     */
    protected $activeClass = 'active';
    
    /**
     * Sets the separator for any breadcrumb items that aren't list elements
     * @param string $separator This should be the element you want as the separator for breadcrumb items;
     * @return $this
     */
    public function setBreadcrumbSeparator($separator) {
        if($separator) {
            $this->separator = $separator;
        }
        return $this;
    }
    
    /**
     * The breadcrumb separator will be returned
     * @return string The separator will be returned
     */
    public function getBreadcrumbSeparator() {
        return $this->separator;
    }
    
    /**
     * Sets the main element to give to list style breadcrumb menus
     * @param string $element The main element you want to give to the breadcrumb
     * @return $this
     */
    public function setBreadcrumbElement($element) {
        if(!empty(trim($element)) && is_string($element)) {
            $this->breadcrumbElement = trim($element);
        }
        return $this;
    }
    
    /**
     * Returns the breadcrumb element type
     * @return string false Returns the element to surround the breadcrumb items with (default is UL)
     */
    public function getBreadcrumbElement() {
        if(!empty($this->breadcrumbElement)) {
            return $this->breadcrumbElement;
        }
        return false;
    }
    
    /**
     * Sets the link to include in the breadcrumb element
     * @param array $links This should be the breadcrumb links
     * @return $this
     */
    public function setBreacrumbLinks($links) {
        if(is_array($links) && !empty($links)) {
            $this->links = $links;
        }
        return $this;
    }
    
    /**
     * Returns the breadcrumb links
     * @return array
     */
    public function getBreacrumbLinks() {
        return $this->links;
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
     * Checks to see if breadcrumb element is a list style
     * @return boolean Will return true if element is either UL or OL else will return false
     */
    protected function isBreadcrumbList() {
        if(strtolower($this->breadcrumbElement) === 'ul' || strtolower($this->breadcrumbElement) === 'ol') {return true;}
        return false;
    }
    
    /**
     * Creates a bread-crumb navigation from the $this->current array
     * 
     * @return string Returns the bread-crumb information as a string with all of the links included
     */
    public function createBreadcrumb($class = 'breadcrumb', $itemClass = 'breadcrumb-item', $list = true) {
        $breadcrumb = (($list === true && $this->getBreadcrumbElement() !== false) ? '<'.$this->getBreadcrumbElement().(!empty(trim($class)) ? ' class="'.$class.'"' : '').'>' : '');
        if($this->navArray[0]['uri'] !== $this->links[0]['uri']){$breadcrumb.= (($list === true && $this->isBreadcrumbList() !== false) ? '<li'.(!empty(trim($itemClass)) ? Link::htmlClass($itemClass, '') : '').'>' : '').Link::formatLink($this->navArray[0], '', false, true).($list === true && $this->isBreadcrumbList() ? '</li>' : '');}
        $numlinks = (count($this->links) - 1);
        for($i = 0; $i <= $numlinks; $i++) {
            $breadcrumb.= ($list === true ? '<'.($this->isBreadcrumbList() ? 'li' : 'span').(!empty(trim($itemClass)) ? Link::htmlClass($itemClass, ($i === $numlinks ? $this->getActiveClass() : '')) : '').'>' : $this->getBreadcrumbSeparator())
            .($i === $numlinks ? Link::label($this->links[$i]) : Link::formatLink($this->links[$i], '', false, true))
            .($list === true ? '</'.($this->isBreadcrumbList() ? 'li' : 'span').'>' : '');
        }
        return $breadcrumb.(($list === true && $this->getBreadcrumbElement() !== false) ? '</'.$this->getBreadcrumbElement().'>' : '');
    }
    
}
