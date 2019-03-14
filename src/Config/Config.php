<?php

namespace SilverCart\ProductLists\Config;

/**
 * General configuration object for this module.
 * 
 * @package SilverCart
 * @subpackage ProductLists\Config
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 14.03.2019
 * @copyright 2019 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class Config
{
    use \SilverStripe\Core\Config\Configurable;
    
    /**
     * Determines whether to allow a customer to have multiple lists or not.
     *
     * @var bool
     */
    private static $allow_multiple_lists = true;
    
    /**
     * Returns whether to allow a customer to have multiple lists or not.
     * 
     * @return bool
     */
    public static function getAllowMultipleLists() : bool
    {
        return self::config()->allow_multiple_lists;
    }
    
    /**
     * Returns whether to allow a customer to have multiple lists or not.
     * Alias for self::getAllowMultipleLists().
     * 
     * @return bool
     * 
     * @see self::getAllowMultipleLists()
     */
    public static function AllowMultipleLists() : bool
    {
        return self::getAllowMultipleLists();
    }
}
