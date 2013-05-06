<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilvercartProductList.
 *
 * @package SilvercartProductList
 * @subpackage Product
 */

/**
 * Extension for products
 *
 * @package SilvercartProductList
 * @subpackage Product
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2013 pixeltricks GmbH
 * @since 24.04.2013
 * @license see license file in modules base directory
 */
class SilvercartProductListProduct extends DataObjectDecorator {
    
    /**
     * Returns the lists of the current member.
     * 
     * @return DataObjectSet
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function SilvercartProductLists() {
        if (Member::currentUserID()) {
            SilvercartProductList::set_product_context($this->owner);
            $lists = SilvercartProductList::get_by_member(Member::currentUser());
        } else {
            $lists = new DataObjectSet();
        }
        return $lists;
    }
    
}
