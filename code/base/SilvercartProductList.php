<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilvercartProductList.
 *
 * @package SilvercartProductList
 * @subpackage Base
 */

/**
 * Product list to allow a customer to create cart-like lists of products.
 * There are some default actions that can be executed on a product list.
 * Individual actions can be added by project or other modules.
 *
 * @package SilvercartProductList
 * @subpackage Base
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2013 pixeltricks GmbH
 * @since 01.03.2013
 * @license see license file in modules base directory
 */
class SilvercartProductList extends DataObject {
    
    /**
     * DB attributes
     *
     * @var array
     */
    private static $db = array(
        'Title'     => 'Varchar(128)',
        'IsDefault' => 'Boolean(0)',
    );
    
    /**
     * Has one relations
     *
     * @var array
     */
    private static $has_one = array(
        'Member' => 'Member',
    );
    
    /**
     * Has many relations
     *
     * @var array
     */
    private static $has_many = array(
        'SilvercartProductListPositions' => 'SilvercartProductListPosition',
    );
    
    /**
     * Casted attributes
     *
     * @var array
     */
    private static $casting = array(
        'CreatedNice'       => 'Text',
        'LastEditedNice'    => 'Text',
    );
    
    /**
     * The default list
     *
     * @var SilvercartProductList
     */
    public static $default_list = null;
    
    /**
     * The product context
     *
     * @var SilvercartProduct
     */
    public static $product_context = null;
    
    /**
     * Returns the created date in a nice format.
     * 
     * @return string
     */
    public function getCreatedNice() {
        $i18nLocale     = i18n::get_locale();
        $locale2Restore = setlocale(LC_ALL, 0);
        $created        = $this->Created;
        setlocale(LC_ALL, $i18nLocale . '.utf8', $i18nLocale);
        $createdNice    = strftime('%A, %e. %b %Y %H:%M Uhr', strtotime($created));
        setlocale(LC_ALL, $locale2Restore);
        return $createdNice;
    }
    
    /**
     * Returns the created date in a nice format.
     * 
     * @return string
     */
    public function getLastEditedNice() {
        //$maxLastEdited  = $this->SilvercartProductListPositions()->pop()->LastEdited;
        $maxLastEdited  = $this->SilvercartProductListPositions()->sort('LastEdited')->last();
        $lastEdited     = $this->LastEdited;
        if (strtotime($maxLastEdited) > strtotime($lastEdited)) {
            $lastEdited = $maxLastEdited;
        }
        $i18nLocale     = i18n::get_locale();
        $locale2Restore = setlocale(LC_ALL, 0);
        setlocale(LC_ALL, $i18nLocale . '.utf8', $i18nLocale);
        $lastEditedNice = strftime('%A, %e. %b %Y %H:%M Uhr', strtotime($lastEdited));
        setlocale(LC_ALL, $locale2Restore);
        return $lastEditedNice;
    }

    /**
     * Returns the translated singular name of the object. If no translation exists
     * the class name will be returned.
     *
     * @return string The objects singular name
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function singular_name() {
        return SilvercartTools::singular_name_for($this);
    }

    /**
     * Returns the translated plural name of the object. If no translation exists
     * the class name will be returned.
     *
     * @return string the objects plural name
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function plural_name() {
        return SilvercartTools::plural_name_for($this);
    }
    
    /**
     * Returns the field labels
     * 
     * @param bool $includerelations Include relations or not?
     * 
     * @return array
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function fieldLabels($includerelations = true) {
        $labels = array_merge(
                parent::fieldLabels($includerelations),
                array(
                    'Title'                             => _t('SilvercartProductList.TITLE'),
                    'IsDefault'                         => _t('SilvercartProductList.ISDEFAULT'),
                    'Member'                            => _t('Member.SINGULARNAME'),
                    'SilvercartProductListPositions'    => _t('SilvercartProductListPosition.PLURALNAME'),
                )
        );
        
        $this->extend('updateFieldLabels', $labels);
        
        return $labels;
    }

    /**
     * Switches the default list status if necessary
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function onBeforeWrite() {
        parent::onBeforeWrite();
        if ($this->isChanged('IsDefault')) {
            if ($this->IsDefault) {
                $defaultList = self::default_list();
                if ($defaultList instanceof SilvercartProductList &&
                    $defaultList->ID != $this->ID) {
                    $defaultList->IsDefault = false;
                    $defaultList->write();
                }
            }
        } elseif (!(self::default_list() instanceof SilvercartProductList)) {
            $this->IsDefault = true;
        }
        if (empty($this->Title)) {
            $this->Title = sprintf(
                    _t('SilvercartProductList.TITLE_DEFAULT'),
                    date(_t('SilvercartProductList.TITLE_DEFAULT_DATEFORMAT'))
            );
        }
    }
    
    /**
     * Deletes all positions.
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function onBeforeDelete() {
        parent::onBeforeDelete();
        foreach ($this->SilvercartProductListPositions() as $position) {
            $position->delete();
        }
    }

    /**
     * Create a duplicate of this list.
     * 
	 * @param boolean $doWrite Perform a write() operation before returning the object.  If this is 
     *                         true, it will create the duplicate in the database.
     * 
     * @return DataObject A duplicate of this list
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 29.04.2013
     */
    public function duplicate($doWrite = true) {
        $member = $this->Member();
        $existingDuplications = SilvercartProductList::get()->where(sprintf(
                        '"SilvercartProductList"."Title" like \'%s (%s %%)\'',
                        $this->Title,
                        _t('SilvercartProductList.DUPLICATION')
        ));
        $duplicationCount = 1;
        if ($existingDuplications instanceof SS_List) {
            $duplicationCount = $existingDuplications->Count() + 1;
        }
        
        $clone = new SilvercartProductList();
        $clone->MemberID    = $member->ID;
        $clone->Title       = $this->Title . ' (' . _t('SilvercartProductList.DUPLICATION') . ' ' . $duplicationCount . ')';
        if ($doWrite) {
            $clone->write();
            
            foreach ($this->SilvercartProductListPositions() as $position) {
                $clonedPositon = new SilvercartProductListPosition();
                $clonedPositon->SilvercartProductID     = $position->SilvercartProductID;
                $clonedPositon->SilvercartProductListID = $clone->ID;
                $clonedPositon->write();
            }
        }
        
        return $clone;
    }
    
    /**
     * Converts the list into a cart.
     * Adds each position into the cart and removes the position out of the list.
     * 
     * @return DataObject A duplicate of this list
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 06.05.2013
     */
    public function convertToCart() {
        $customer = Member::currentUser();
        if (!$customer instanceof Member) {
            $customer = SilvercartCustomer::createAnonymousCustomer();
        }
        foreach ($this->SilvercartProductListPositions() as $position) {
            $cart = $customer->getCart();
            $position->SilvercartProduct()->addToCart($cart->ID);
            $this->SilvercartProductListPositions()->remove($position);
        }
    }

    /**
     * Returns the linkt to the list.
     * If $action is given, the alternative action will be used instead.
     * 
     * @param string $action Alternative action to use
     * 
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 30.04.2013
     */
    public function Link($action = 'detail') {
        return SilvercartTools::PageByIdentifierCode('SilvercartProductListPage')->Link($action) . '/' . $this->ID;
    }

    /**
     * Returns the link to add a product to the list.
     * 
     * @param int $productID ID of the product to add
     * 
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.08.2018
     */
    public function AddProductLink($productID, $removeFromShoppingCart = false)
    {
        $action = "addToList";
        if ($removeFromShoppingCart) {
            $action = "addToListAndRemoveFromCart";
        }
        return Director::makeRelative("silvercart-product-list/{$action}/{$productID}/{$this->ID}");
    }
    
    /**
     * Returns the list as an array of product numbers.
     * 
     * @return array
     */
    public function getProductNumbersAsArray() {
        $listAsArray = array();
        foreach ($this->SilvercartProductListPositions() as $position) {
            $listAsArray[] = $position->SilvercartProduct()->ProductNumberShop;
        }
        return $listAsArray;
    }

    /**
     * Adds the given product to the list.
     * 
     * @param SilvercartProduct $product Product to add
     * 
     * @return $this
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 30.04.2013
     */
    public function addProduct(SilvercartProduct $product)
    {
        $existingPosition = $this->SilvercartProductListPositions()->find('SilvercartProductID', $product->ID);
        if (!($existingPosition instanceof SilvercartProductListPosition)) {
            $position = SilvercartProductListPosition::create();
            $position->SilvercartProductID      = $product->ID;
            $position->SilvercartProductListID  = $this->ID;
            $position->write();
        }
        return $this;
    }
    
    /**
     * Removes the given product from the list.
     * 
     * @param SilvercartProduct $product Product
     * 
     * @return $this
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 04.01.2019
     */
    public function removeProduct(SilvercartProduct $product)
    {
        $existingPosition = $this->SilvercartProductListPositions()->find('SilvercartProductID', $product->ID);
        if ($existingPosition instanceof SilvercartProductListPosition) {
            $this->SilvercartProductListPositions()->remove($existingPosition);
        }
        return $this;
    }
    
    /**
     * Returns the current product context
     * 
     * @return SilvercartProduct
     */
    public function getProduct() {
        return self::$product_context;
    }
    
    /**
     * Sets the list as the current context list.
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 30.04.2013
     */
    public function setAsCurrentList() {
        $controller = Controller::curr();
        if ($controller->hasMethod('setCurrentList')) {
            $controller->setCurrentList($this);
        }
    }
    
    /**
     * Returns the actions for the current list
     * 
     * @return ArrayList
     */
    public function getListActions() {
        $registered_actions = SilvercartProductListAction::get_registered_actions();
        $actions            = new ArrayList();
        foreach ($registered_actions as $action) {
            $actionObject = new $action();
            if ($actionObject->canView($this) &&
                $actionObject->isVisible()) {
                $actions->push($actionObject);
            }
        }
        return $actions;
    }

    /**
     * Returns the lists of the given member.
     * 
     * @param Member $member Member to get lists for
     * 
     * @return DataList
     */
    public static function get_by_member($member) {
        return $member->SilvercartProductLists();
    }

    /**
     * Sets the current product context.
     * 
     * @param SilvercartProduct $product Product to set as context
     * 
     * @return void
     */
    public static function set_product_context(SilvercartProduct $product) {
        self::$product_context = $product;
    }

    /**
     * Adds the given product to the given list.
     * If no list is given, the default list will be used as fallback.
     * 
     * @param SilvercartProduct     $product Product to add to $list
     * @param SilvercartProductList $list    List to add product to
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 30.04.2013
     */
    public static function addProductTo($product, $list = null) {
        if (is_null($list)) {
            $list = self::default_list();
        }
        $list->addProduct($product);
    }
    
    /**
     * Returns the default list
     * 
     * @return SilvercartProductList
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 30.04.2013
     */
    public static function default_list() {
        if (is_null(self::$default_list)) {
            self::$default_list = false;
            $customer           = SilvercartCustomer::currentRegisteredCustomer();
            if ($customer instanceof Member) {
                $default_list = $customer->SilvercartProductLists()->find('IsDefault', true);
                if ($default_list instanceof SilvercartProductList) {
                    self::$default_list = $default_list;
                }
            } else {
                self::$default_list = self::create_from_session();
            }
        }
        return self::$default_list;
    }
    
}