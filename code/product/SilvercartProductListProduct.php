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
class SilvercartProductListProduct extends DataExtension
{
    /**
     * Returns the lists of the current member.
     * 
     * @return SS_List
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 13.07.2017
     */
    public function SilvercartProductLists()
    {
        if (Member::currentUserID()) {
            SilvercartProductList::set_product_context($this->owner);
            $lists = SilvercartProductList::get_by_member(Member::currentUser());
        } else {
            $lists = ArrayList::create();
        }
        return $lists;
    }
    
    /**
     * Returns the link to add this product to a new list.
     * 
     * @param bool $removeFromShoppingCart Remove from shopping cart before adding to list?
     * 
     * @return string
     */
    public function AddToNewListLink($removeFromShoppingCart = false)
    {
        $action = "addToList";
        if ($removeFromShoppingCart) {
            $action = "addToListAndRemoveFromCart";
        }
        return Director::makeRelative("silvercart-product-list/{$action}/{$this->owner->ID}/new");
    }
    
    /**
     * Returns the link to add this product to the default list.
     * 
     * @param bool $removeFromShoppingCart Remove from shopping cart before adding to list?
     * 
     * @return string
     */
    public function AddToDefaultListLink($removeFromShoppingCart = false)
    {
        $action = "addToList";
        if ($removeFromShoppingCart) {
            $action = "addToListAndRemoveFromCart";
        }
        $defaultListID = 'new';
        $defaultList   = SilvercartProductList::default_list();
        if ($defaultList instanceof SilvercartProductList
         && $defaultList->exists())
        {
            $defaultListID = $defaultList->ID;
        }
        return Director::makeRelative("silvercart-product-list/{$action}/{$this->owner->ID}/{$defaultListID}");
    }
}
