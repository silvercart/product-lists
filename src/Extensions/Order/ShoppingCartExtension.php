<?php

namespace SilverCart\ProductLists\Extensions\Order;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Member;

/**
 * Extension for SilverCart ShoppingCart.
 * 
 * @package SilverCart
 * @subpackage ProductChains\Extensions\Model\Order
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 09.12.2020
 * @copyright 2020 pixeltricks GmbH
 * @license see license file in modules root directory
 * 
 * @property \SilverCart\Model\Order\ShoppingCart $owner Owner
 */
class ShoppingCartExtension extends DataExtension
{
    /**
     * Returns whether the current member's cart can be added to the wishlist.
     * 
     * @return bool
     */
    public function canAddToList(Member $member = null) : bool
    {
        $can = false;
        foreach ($this->owner->ShoppingCartPositions() as $position) {
            if ($position->Product()->canAddToList($member)) {
                $can = true;
                break;
            }
        }
        return $can;
    }
}