<?php

namespace SilverCart\ProductLists\Extensions\Order;

use SilverStripe\ORM\DataExtension;

/**
 * Extension for SilverCart OrderPosition.
 * 
 * @package SilverCart
 * @subpackage ProductLists\Extensions\Order
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 15.09.2020
 * @copyright 2020 pixeltricks GmbH
 * @license see license file in modules root directory
 * 
 * @property \SilverCart\Model\Order\OrderPosition $owner Owner
 */
class OrderPositionExtension extends DataExtension
{
    /**
     * On before write.
     * 
     * @return void
     */
    public function onBeforeWrite() : void
    {
        if ($this->owner->exists()) {
            return;
        }
        $customer = $this->owner->Order()->Member();
        if ($customer->ProductLists()->exists()) {
            foreach ($customer->ProductLists() as $list) {
                /* @var $list \SilverCart\ProductLists\Model\Product\ProductList */
                $positions = $list->ProductListPositions()->filter('ProductID', $this->owner->ProductID);
                /* @var $positions \SilverStripe\ORM\DataList */
                if ($positions->exists()) {
                    $positions->removeAll();
                }
            }
        }
    }
}