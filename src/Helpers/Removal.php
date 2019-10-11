<?php

namespace Menu\Helpers;

class Removal {
    
    /**
     * Remove an key and value from all levels of a multidimensional array 
     * @param array $array This should be the array
     * @param string $key This should be the key value that you want to remove
     */
    public static function removeArrayKey(&$array, $key) {
        foreach($array as $i => &$arrayElement) {
            if(is_array($arrayElement)) {
                self::removeArrayKey($arrayElement, $key);
            }
            elseif($i == $key) {
                unset($array[$i]);
            }
        }
        return $array;
    }
}
