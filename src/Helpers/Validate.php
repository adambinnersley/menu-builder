<?php
namespace Menu\Helpers;

class Validate {
    
    /**
     * Validates that a URI is valid
     * @param string $uri This should be the URI you are checking
     * @return boolean If the URI is valid will return true else returns false
     */
    public function validateURI($uri) {
        if(!empty(trim($uri))){
            return filter_var(trim($uri), FILTER_VALIDATE_URL);
        }
        return false;
    }
    
    /**
     * Sanitise a URI 
     * @param string $uri This should be the URI you are sanitising
     * @return string Returns the sanitised URI
     */
    public function sanitizeURI($uri) {
        return strtolower(filter_var(trim($uri), FILTER_SANITIZE_URL));
    }
}
