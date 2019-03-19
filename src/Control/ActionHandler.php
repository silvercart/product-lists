<?php

namespace SilverCart\ProductLists\Control;

use SilverCart\Dev\Tools;
use SilverCart\Model\Customer\Customer;
use SilverCart\Model\Pages\MyAccountHolder;
use SilverCart\Model\Order\ShoppingCart;
use SilverCart\Model\Product\Product;
use SilverCart\ProductLists\Model\Product\ProductList;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Security\Member;

/**
 * Central handler for form actions.
 *
 * @package SilverCart
 * @subpackage ProductLists_Control
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2018 pixeltricks GmbH
 * @since 24.08.2018
 * @license see license file in modules base directory
 */
class ActionHandler extends Controller
{
    /**
     * Allowed actions
     *
     * @var array
     */
    private static $allowed_actions = [
        'addToList',
        'addToListAndRemoveFromCart',
        'addToCartAndRemoveFromList',
        'getLists',
    ];
    
    /**
     * Action to add a product to a list.
     * 
     * @param HTTPRequest $request Request to check for product data
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 12.03.2013
     */
    public function addToList(HTTPRequest $request)
    {
        $customer = Customer::currentUser();
        if ($customer instanceof Member
         && $customer->isRegisteredCustomer()
        ) {
            $params    = $request->allParams();
            $productID = $params['ID'];
            $list      = $this->getListByRequest($request, $customer);
            if ($list instanceof ProductList) {
                $product = Product::get()->byID($productID);
                if ($product instanceof Product
                 && $product->canView($customer)
                ) {
                    $list->addProduct($product);
                }
            }
            $this->redirectBack();
        } else {
            MyAccountHolder::reset_info_messages();
            $params    = $request->allParams();
            $productID = $params['ID'];
            $list      = ProductList::singleton();
            ProductList::add_after_login($productID);
            MyAccountHolder::add_info_message($list->fieldLabel('AccountRequiredInfo'));
            $this->redirect(Tools::PageByIdentifierCode('SilvercartMyAccountHolder')->Link());
        }
    }
    
    /*
     * Action to remove a product from cart and add it to a list.
     * 
     * @param HTTPRequest $request Request to check for product data
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 08.10.2018
     */
    public function addToListAndRemoveFromCart(HTTPRequest $request)
    {
        $customer = Customer::currentUser();
        if ($customer instanceof Member
         && $customer->isRegisteredCustomer()
        ) {
            ShoppingCart::removeProduct(['productID' => $request->param('ID')]);
        }
        $this->addToList($request);
    }
    
    /*
     * Action to remove a product from cart and add it to a list.
     * 
     * @param HTTPRequest $request Request to check for product data
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 04.01.2019
     */
    public function addToCartAndRemoveFromList(HTTPRequest $request)
    {
        $customer = Customer::currentUser();
        if ($customer instanceof Member
         && $customer->isRegisteredCustomer()
        ) {
            ShoppingCart::addProduct([
                'productID'       => $request->param('ID'),
                'productQuantity' => 1,
            ]);
            $list = $this->getListByRequest($request, $customer);
            if ($list instanceof ProductList) {
                $product = Product::get()->byID($request->param('ID'));
                if ($product instanceof Product
                 && $product->canView($customer)
                ) {
                    $list->removeProduct($product);
                }
            }
        }
        $this->redirectBack();
    }
    
    /**
     * Returns the current customers lists as a JSON string.
     * 
     * @return string
     */
    public function getLists()
    {
        $customer = Customer::currentUser();
        if ($customer instanceof Member
            && $customer->isRegisteredCustomer()
        ) {
            $map = array_merge(
                    [
                        'new' => ProductList::singleton()->fieldLabel('CreateNewList'),
                    ],
                    $customer->ProductLists()->map()->toArray()
            );
        } else {
            $map = [
                'new' => ProductList::singleton()->fieldLabel('AccountRequired'),
            ];
        }
        $json = json_encode($map);
        return $json;
    }
    
    /**
     * Returns the product list by the given request params.
     * 
     * @param HTTPRequest $request  Request
     * @param Member      $customer Customer context
     * 
     * @return SilvercartProductList
     */
    protected function getListByRequest(HTTPRequest $request, Member $customer = null) : ProductList
    {
        $list = null;
        if (is_null($customer)) {
            $customer = Customer::currentUser();
        }
        if ($customer instanceof Member
         && $customer->isRegisteredCustomer()
        ) {
            $params = $request->allParams();
            $listID = $params['OtherID'];
            if ($listID == 'new') {
                $list = ProductList::create();
                $list->MemberID = $customer->ID;
                $list->write();
            } else {
                $list = $customer->ProductLists()->byID($listID);
            }
        }
        return $list;
    }
}