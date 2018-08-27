<?php

namespace SilverCart\ProductLists\Extensions\Product;

use SilverCart\ProductLists\Model\Product\ProductList;
use SilverStripe\Control\Director;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Member;

/**
 * Extension for products
 *
 * @package SilverCart
 * @subpackage SilverCart_ProductLists_Extensions_Product
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2018 pixeltricks GmbH
 * @since 24.08.2018
 * @license see license file in modules base directory
 */
class ProductExtension extends DataExtension
{    
    /**
     * Returns the lists of the current member.
     * 
     * @return \SilverStripe\ORM\SS_List
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 13.07.2017
     */
    public function ProductLists() {
        if (Member::currentUserID()) {
            ProductList::set_product_context($this->owner);
            $lists = ProductList::get_by_member(Member::currentUser());
        } else {
            $lists = ArrayList::create();
        }
        return $lists;
    }

    /**
     * Returns the link to add the product to a new list.
     * 
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.08.2018
     */
    public function AddToNewListLink()
    {
        return Director::makeRelative("silvercart-product-list/addToList/{$this->owner->ID}/new");
    }

    /**
     * Returns the link to add the product to a new list.
     * 
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.08.2018
     */
    public function AddToDefaultListLink()
    {
        $linkID = 'new';
        $defaultList = ProductList::default_list();
        if ($defaultList instanceof ProductList) {
            $linkID = $defaultList->ID;
        }
        return Director::makeRelative("silvercart-product-list/addToList/{$this->owner->ID}/$linkID");
    }
}
