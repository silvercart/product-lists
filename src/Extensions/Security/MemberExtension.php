<?php

namespace SilverCart\ProductLists\Extensions\Security;

use SilverCart\ProductLists\Config\Config;
use SilverCart\ProductLists\Model\Product\ProductList;
use SilverStripe\ORM\DataExtension;

/**
 * Extension for Member.
 *
 * @package SilverCart
 * @subpackage ProductLists_Extensions_Security
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2018 pixeltricks GmbH
 * @since 24.08.2018
 * @license see license file in modules base directory
 */
class MemberExtension extends DataExtension
{
    /**
     * Has many relations
     *
     * @var array
     */
    private static $has_many = [
        'ProductLists' => ProductList::class,
    ];
    
    /**
     * Updates the field labels
     * 
     * @param array &$labels Labels to update
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.08.2018
     */
    public function updateFieldLabels(&$labels)
    {
        $labels = array_merge(
                $labels,
                [
                    'ProductLists' => ProductList::singleton()->plural_name(),
                ]
        );
    }
    
    /**
     * Returns whether to allow a customer to have multiple lists or not.
     * 
     * @return bool
     */
    public function AllowMultipleProductLists() : bool
    {
        return Config::AllowMultipleLists();
    }
    
    /**
     * Returns the current customers default list.
     * 
     * @return ProductList|null
     */
    public function getDefaultProductList() : ?ProductList
    {
        $list = $this->owner->ProductLists()->filter('IsDefault', true)->first();
        if (is_null($list)) {
            $list = $this->owner->ProductLists()->first();
        }
        return $list;
    }
}
