<?php

namespace SilverCart\ProductLists\Extensions\Product;

use SilverCart\Model\Product\Product;
use SilverCart\ProductLists\Model\Product\ProductList;
use SilverCart\ProductLists\Model\Product\ProductListPosition;
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
     * Context product list.
     *
     * @var ProductList
     */
    protected $contextProductList = null;
    /**
     * Context product list position.
     *
     * @var ProductListPosition
     */
    protected $contextProductListPosition = null;
    
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
    public function AddToNewListLink($removeFromShoppingCart = false)
    {
        $action = "addToList";
        if ($removeFromShoppingCart) {
            $action = "addToListAndRemoveFromCart";
        }
        return Director::makeRelative("silvercart-product-list/{$action}/{$this->owner->ID}/new");
    }

    /**
     * Returns the link to add the product to a new list.
     * 
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.08.2018
     */
    public function AddToDefaultListLink($removeFromShoppingCart = false)
    {
        $linkID = 'new';
        $defaultList = ProductList::default_list();
        if ($defaultList instanceof ProductList) {
            $linkID = $defaultList->ID;
        }
        $action = "addToList";
        if ($removeFromShoppingCart) {
            $action = "addToListAndRemoveFromCart";
        }
        return Director::makeRelative("silvercart-product-list/{$action}/{$this->owner->ID}/{$linkID}");
    }
    
    /**
     * Returns the context product list.
     * 
     * @return ProductList|null
     */
    public function getContextProductList(): ?ProductList
    {
        return $this->contextProductList;
    }
    
    /**
     * Returns the context product list position.
     * 
     * @return ProductListPosition|null
     */
    public function getContextProductListPosition(): ?ProductListPosition
    {
        return $this->contextProductListPosition;
    }

    /**
     * Sets the context product list.
     * 
     * @param ProductList $contextProductList Context product list
     * 
     * @return Product
     */
    public function setContextProductList(ProductList $contextProductList = null) : Product
    {
        $this->contextProductList = $contextProductList;
        return $this->owner;
    }

    /**
     * Sets the context product list by ID.
     * 
     * @param int $contextProductListID Context product list ID
     * 
     * @return Product
     */
    public function setContextProductListByID(int $contextProductListID = null) : Product
    {
        $this->setContextProductList(ProductList::get()->byID((int) $contextProductListID));
        return $this->owner;
    }

    /**
     * Sets the context product list position
     * 
     * @param ProductListPosition $contextProductListPosition Context product list position
     * 
     * @return Product
     */
    public function setContextProductListPosition(ProductListPosition $contextProductListPosition = null) : Product
    {
        $this->contextProductListPosition = $contextProductListPosition;
        if ($contextProductListPosition instanceof ProductListPosition) {
            $this->setContextProductList($contextProductListPosition->ProductList());
        } else {
            $this->setContextProductList();
        }
        return $this->owner;
    }

    /**
     * Sets the context product list position by ID.
     * 
     * @param int $contextProductListPositionID Context product list position ID
     * 
     * @return Product
     */
    public function setContextProductListPositionByID(int $contextProductListPositionID = null) : Product
    {
        $this->setContextProductListPosition(ProductListPosition::get()->byID((int) $contextProductListPositionID));
        return $this->owner;
    }
}
