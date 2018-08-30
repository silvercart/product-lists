<?php

namespace SilverCart\ProductLists\Model\Product;

use SilverCart\Dev\Tools;
use SilverCart\Model\Customer\Customer;
use SilverCart\Model\Product\Product;
use SilverCart\ProductLists\Control\Actions\ProductListAction;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\i18n\i18n;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBBoolean;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\SS_List;
use SilverStripe\Security\Member;

/**
 * Product list to allow a customer to create cart-like lists of products.
 * There are some default actions that can be executed on a product list.
 * Individual actions can be added by project or other modules.
 *
 * @package SilverCart
 * @subpackage ProductLists_Model_Product
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2018 pixeltricks GmbH
 * @since 24.08.2018
 * @license see license file in modules base directory
 */
class ProductList extends DataObject
{
    const SESSION_KEY                 = 'SilverCart.ProductList';
    const ADD_AFTER_LOGIN_SESSION_KEY = 'SilverCart.ProductList.AddAfterLogin';
    /**
     * DB attributes
     *
     * @var array
     */
    private static $db = [
        'Title'     => 'Varchar(128)',
        'IsDefault' => DBBoolean::class,
    ];
    /**
     * Has one relations
     *
     * @var array
     */
    private static $has_one = [
        'Member' => Member::class,
    ];
    /**
     * Has many relations
     *
     * @var array
     */
    private static $has_many = [
        'ProductListPositions' => ProductListPosition::class,
    ];
    /**
     * Defaults for db attributes.
     *
     * @var array
     */
    private static $defaults = [
        'IsDefault' => false,
    ];
    /**
     * Casted attributes
     *
     * @var array
     */
    private static $casting = [
        'CreatedNice'    => DBText::class,
        'LastEditedNice' => DBText::class,
    ];
    /**
     * Table name
     *
     * @var array
     */
    private static $table_name = 'SilvercartProductList';
    /**
     * The default list
     *
     * @var ProductList
     */
    public static $default_list = null;
    /**
     * The product context
     *
     * @var Product
     */
    public static $product_context = null;
    /**
     * A list of product to add to the list after login.
     *
     * @var array
     */
    private static $add_after_login_list = [];
    
    /**
     * Returns the created date in a nice format.
     * 
     * @return string
     */
    public function getCreatedNice()
    {
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
    public function getLastEditedNice()
    {
        $maxLastEdited = $this->ProductListPositions()->sort('LastEdited')->last();
        $lastEdited    = $this->LastEdited;
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
     * @since 24.08.2018
     */
    public function singular_name()
    {
        return Tools::singular_name_for($this);
    }

    /**
     * Returns the translated plural name of the object. If no translation exists
     * the class name will be returned.
     *
     * @return string the objects plural name
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.08.2018
     */
    public function plural_name()
    {
        return Tools::plural_name_for($this);
    }
    
    /**
     * Returns the field labels
     * 
     * @param bool $includerelations Include relations or not?
     * 
     * @return array
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.08.2018
     */
    public function fieldLabels($includerelations = true)
    {
        $labels = array_merge(
                parent::fieldLabels($includerelations),
                [
                    'Title'                => _t(ProductList::class . '.TITLE', 'Title'),
                    'IsDefault'            => _t(ProductList::class . '.ISDEFAULT', 'Is default'),
                    'DateFormat'           => _t(ProductList::class . '.TITLE_DEFAULT_DATEFORMAT', 'd.m.Y H:i'),
                    'Duplication'          => _t(ProductList::class . '.DUPLICATION', 'copy'),
                    'AccountRequired'      => _t(ProductList::class . '.AccountRequired', 'To add products to a list, you have to login or register an account. Click here to login or create an account.'),
                    'AccountRequiredInfo'  => _t(ProductList::class . '.AccountRequiredInfo', 'To add products to a list, you have to login or register an account. After you are logged in, the product you picked will be automatically added to your list.'),
                    'Member'               => Member::singleton()->singular_name(),
                    'ProductListPositions' => ProductListPosition::singleton()->plural_name(),
                ]
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
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        if ($this->isChanged('IsDefault')) {
            if ($this->IsDefault) {
                $defaultList = self::default_list();
                if ($defaultList instanceof ProductList
                    && $defaultList->ID != $this->ID
                ) {
                    $defaultList->IsDefault = false;
                    $defaultList->write();
                }
            }
        } elseif (!(self::default_list() instanceof ProductList)) {
            $this->IsDefault = true;
        }
        if (empty($this->Title)) {
            $this->Title = _t(ProductList::class . '.TITLE_DEFAULT',
                    "List from {date} o'clock",
                    [
                        'date' => date($this->fieldLabel('DateFormat')),
                    ]
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
    public function onBeforeDelete()
    {
        parent::onBeforeDelete();
        foreach ($this->ProductListPositions() as $position) {
            $position->delete();
        }
    }

    /**
     * Create a duplicate of this list.
     * 
     * @param boolean          $doWrite   Perform a write() operation before returning the object. If this is 
     *                                    true, it will create the duplicate in the database.
     * @param array|null|false $relations List of relations to duplicate.
     * 
     * @return DataObject A duplicate of this list
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 29.04.2013
     */
    public function duplicate($doWrite = true, $relations = null)
    {
        $member = $this->Member();
        $existingDuplications = ProductList::get()->where(sprintf(
                        '"SilvercartProductList"."Title" LIKE \'%s (%s %%)\'',
                        $this->Title,
                        $this->fieldLabel('Duplication')
        ));
        $duplicationCount = 1;
        if ($existingDuplications instanceof SS_List) {
            $duplicationCount = $existingDuplications->count() + 1;
        }
        
        $clone = ProductList::create();
        $clone->MemberID = $member->ID;
        $clone->Title    = $this->Title . ' (' . $this->fieldLabel('Duplication') . ' ' . $duplicationCount . ')';
        if ($doWrite) {
            $clone->write();
            
            foreach ($this->ProductListPositions() as $position) {
                $clonedPositon = ProductListPosition::create();
                $clonedPositon->ProductID     = $position->ProductID;
                $clonedPositon->ProductListID = $clone->ID;
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
    public function convertToCart()
    {
        $customer = Member::currentUser();
        if (!$customer instanceof Member) {
            $customer = Customer::createAnonymousCustomer();
        }
        foreach ($this->ProductListPositions() as $position) {
            $cart = $customer->getCart();
            $position->Product()->addToCart($cart->ID);
            $this->ProductListPositions()->remove($position);
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
    public function Link($action = 'detail')
    {
        return Tools::PageByIdentifierCode('SilvercartProductListPage')->Link($action) . '/' . $this->ID;
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
    public function AddProductLink($productID)
    {
        return Director::makeRelative("silvercart-product-list/addToList/{$productID}/{$this->ID}");
    }
    
    /**
     * Returns the list as an array of product numbers.
     * 
     * @return array
     */
    public function getProductNumbersAsArray()
    {
        $listAsArray = [];
        foreach ($this->ProductListPositions() as $position) {
            $listAsArray[] = $position->Product()->ProductNumberShop;
        }
        return $listAsArray;
    }

    /**
     * Adds the given product to the list.
     * 
     * @param Product $product Product to add
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 30.04.2013
     */
    public function addProduct($product)
    {
        $existingPosition = $this->ProductListPositions()->find('ProductID', $product->ID);
        if (!($existingPosition instanceof ProductListPosition)) {
            $position = ProductListPosition::create();
            $position->ProductID     = $product->ID;
            $position->ProductListID = $this->ID;
            $position->write();
            $this->extend('onAfterAddToList', $product);
            $product->extend('onAfterAddToList', $position);
        }
    }
    
    /**
     * Returns the current product context
     * 
     * @return Product
     */
    public function getProduct()
    {
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
    public function setAsCurrentList()
    {
        $controller = Controller::curr();
        if ($controller->hasMethod('setCurrentList')) {
            $controller->setCurrentList($this);
        }
    }
    
    /**
     * Returns whether the list is the current context list.
     * 
     * @return bool
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.08.2018
     */
    public function isCurrentList()
    {
        $isCurrent = false;
        $ctrl = Controller::curr();
        if ($ctrl->hasMethod('getCurrentList')) {
            $current = $ctrl->getCurrentList();
            if ($current instanceof ProductList
                && $current->ID == $this->ID
            ) {
                $isCurrent = true;
            }
        }
        return $isCurrent;
    }
    
    /**
     * Returns the actions for the current list
     * 
     * @return ArrayList
     */
    public function getListActions()
    {
        $registered_actions = ProductListAction::get_registered_actions();
        $actions            = ArrayList::create();
        foreach ($registered_actions as $action) {
            $actionObject = new $action();
            if ($actionObject->canView($this)
                && $actionObject->isVisible()
            ) {
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
    public static function get_by_member($member)
    {
        return $member->ProductLists();
    }

    /**
     * Sets the current product context.
     * 
     * @param Product $product Product to set as context
     * 
     * @return void
     */
    public static function set_product_context(Product $product)
    {
        self::$product_context = $product;
    }

    /**
     * Adds the given product to the given list.
     * If no list is given, the default list will be used as fallback.
     * 
     * @param Product     $product Product to add to $list
     * @param ProductList $list    List to add product to
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 30.04.2013
     */
    public static function addProductTo($product, $list = null)
    {
        if (is_null($list)) {
            $list = self::default_list();
        }
        $list->addProduct($product);
    }
    
    /**
     * Returns the default list
     * 
     * @return ProductList
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 30.04.2013
     */
    public static function default_list()
    {
        if (is_null(self::$default_list)) {
            self::$default_list = false;
            $customer           = Customer::currentRegisteredCustomer();
            if ($customer instanceof Member) {
                $default_list = $customer->ProductLists()->find('IsDefault', true);
                if ($default_list instanceof ProductList) {
                    self::$default_list = $default_list;
                }
            }
        }
        return self::$default_list;
    }
    
    /**
     * Adds a product ID to the list of products to add after login.
     * 
     * @param int $productID Product ID
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 27.08.2018
     */
    public static function add_after_login($productID)
    {
        self::$add_after_login_list[] = $productID;
        array_unique(self::$add_after_login_list);
        self::save_add_after_login_list();
    }
    
    /**
     * Returns the list of products to add after login.
     * 
     * @return array
     */
    public static function get_add_after_login_list()
    {
        if (empty(self::$add_after_login_list)) {
            self::$add_after_login_list = Tools::Session()->get(self::ADD_AFTER_LOGIN_SESSION_KEY);
        }
        return (array) self::$add_after_login_list;
    }
    
    /**
     * Adds in session stored products to the default list or a new list.
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 27.08.2018
     */
    public static function add_products_from_session()
    {
        $customer   = Customer::currentRegisteredCustomer();
        $productIDs = self::get_add_after_login_list();
        if (empty($productIDs)
            || !($customer instanceof Member)
        ) {
            return;
        }
        
        $list = self::default_list();
        if (!$list instanceof ProductList) {
            $list = ProductList::create();
            $list->MemberID = $customer->ID;
            $list->write();
        }
        
        if ($list instanceof ProductList) {
            foreach ($productIDs as $productID) {
                $product = Product::get()->byID($productID);
                if ($product instanceof Product
                    && $product->canView($customer)
                ) {
                    $list->addProduct($product);
                }
            }
        }
        self::reset_add_after_login_list();
    }
    
    /**
     * Saves the list of products to add after login in session.
     * 
     * @return void
     */
    public static function save_add_after_login_list()
    {
        Tools::Session()->set(self::ADD_AFTER_LOGIN_SESSION_KEY, self::$add_after_login_list);
        Tools::saveSession();
    }
    
    /**
     * Clears the list of products to add after login data out of session.
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 27.08.2018
     */
    public static function reset_add_after_login_list() {
        Tools::Session()->set(self::ADD_AFTER_LOGIN_SESSION_KEY, null);
        Tools::saveSession();
    }
}