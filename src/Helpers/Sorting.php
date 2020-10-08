<?php
namespace Menu\Helpers;

class Sorting
{
    
    /**
     * Comparison for the uasort method
     * @param array $a This should be the information of the first link
     * @param array $b This should be the information of the second link
     * @return int
     */
    protected static function sortByOrder($a, $b)
    {
        if (!isset($a['link_order']) && isset($b['link_order'])) {
            $a['link_order'] = ($b['link_order'] + 1);
        }
        if (!isset($b['link_order']) && isset($a['link_order'])) {
            $b['link_order'] = ($a['link_order'] + 1);
        }
        if (isset($a['link_order']) && isset($b['link_order']) && is_numeric($a['link_order']) && is_numeric($b['link_order'])) {
            return intval($a['link_order']) - intval($b['link_order']);
        }
        return 0;
    }
    
    /**
     * Sort child elements from the menu array
     * @param array $array This should be a menu item array
     * @return array
     */
    protected static function sortChildElements($array)
    {
        foreach ($array as $i => $item) {
            if (isset($item['children']) && is_array($item['children'])) {
                uasort($array[$i]['children'], 'self::sortByOrder');
                $array[$i]['children'] = array_values(self::sortChildElements($array[$i]['children']));
            }
        }
        return $array;
    }

    /**
     * Sort the menu item based on the order field if it exists
     * @param array $array This should be an array of menu items
     * @return array Re-ordered array will be returned
     */
    public static function sort($array)
    {
        if (is_array($array)) {
            $array = self::sortChildElements($array);
            uasort($array, 'self::sortByOrder');
        }
        return array_values($array);
    }
}
