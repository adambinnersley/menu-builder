<?php

namespace Menu\Helpers;

use InvalidArgumentException;

class URI {
    protected static $uri;
    protected static $anchor;
    
    /**
     * Sets the link URI
     * @param string $uri This should be the link string
     * @throws InvalidArgumentException
     */
    protected static function setURI($uri){
        if(!is_string($uri)){
            throw new InvalidArgumentException(
                '$uri must be a string or null'
            );
        }
        self::$uri = filter_var($uri, FILTER_SANITIZE_URL);
    }
    
    /**
     * Returns the URI for the link
     * @return string Returns the URI for the link
     */
    protected static function getURI(){
        return self::$uri;
    }
    
    /**
     * Sets the anchor point for the link
     * @param mixed $anchor If the anchor point exists set to the string here
     */
    protected static function setAnchorPoint($anchor){
        if(is_string($anchor) && !empty(trim($anchor))){
            self::$anchor = '#'.trim($anchor, '#');
        }
        else{
            self::$anchor = false;
        }
    }
    
    /**
     * Returns the anchor point for the link if it exists
     * @return string|false Returns the anchor point if it exists else will return false
     */
    protected static function getAnchorPoint(){
        return self::$anchor;
    }

    /**
     * Returns the correctly formatted link string 
     * @param array $link This should be the link information
     * @return mixed Will return the link string if it exists else will return false
     */
    public static function getHref($link) {
        self::setURI($link['uri']);
        if(isset($link['fragment'])){self::setAnchorPoint($link['fragment']);}
        return self::getURI().self::getAnchorPoint();
    }
}
