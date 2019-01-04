<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilvercartProductList.
 *
 * @package SilvercartProductList
 * @subpackage Controller
 */

/**
 * Central handler for form actions.
 *
 * @package SilvercartProductList
 * @subpackage Controller
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2013 pixeltricks GmbH
 * @since 01.03.2013
 * @license see license file in modules base directory
 */
class SilvercartProductListActionHandler extends Controller
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
     * Action to add a product to cart.
     * 
     * @param SS_HTTPRequest $request Request to check for product data
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 12.03.2013
     */
    public function addToList(SS_HTTPRequest $request)
    {
        $customer = SilvercartCustomer::currentUser();
        if ($customer instanceof Member
         && $customer->isRegisteredCustomer()
        ) {
            $list = $this->getListByRequest($request, $customer);
            if ($list instanceof SilvercartProductList) {
                $product = SilvercartProduct::get()->byID($request->param('ID'));
                if ($product instanceof SilvercartProduct
                 && $product->canView($customer)
                ) {
                    $list->addProduct($product);
                }
            }
            $this->redirectBack();
        } else {
            $this->redirect(SilvercartTools::PageByIdentifierCode('SilvercartMyAccountHolder')->Link());
        }
    }
    
    /*
     * Action to remove a product from cart and add it to a list.
     * 
     * @param SS_HTTPRequest $request Request to check for product data
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 08.10.2018
     */
    public function addToListAndRemoveFromCart(SS_HTTPRequest $request)
    {
        $customer = SilvercartCustomer::currentUser();
        if ($customer instanceof Member
         && $customer->isRegisteredCustomer()
        ) {
            SilvercartShoppingCart::removeProduct(['productID' => $request->param('ID')]);
        }
        $this->addToList($request);
    }
    
    /*
     * Action to remove a product from cart and add it to a list.
     * 
     * @param SS_HTTPRequest $request Request to check for product data
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 04.01.2019
     */
    public function addToCartAndRemoveFromList(SS_HTTPRequest $request)
    {
        $customer = SilvercartCustomer::currentUser();
        if ($customer instanceof Member
         && $customer->isRegisteredCustomer()
        ) {
            SilvercartShoppingCart::addProduct([
                'productID'       => $request->param('ID'),
                'productQuantity' => 1,
            ]);
            $list = $this->getListByRequest($request, $customer);
            if ($list instanceof SilvercartProductList) {
                $product = SilvercartProduct::get()->byID($request->param('ID'));
                if ($product instanceof SilvercartProduct
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
        $customer = SilvercartCustomer::currentUser();
        if ($customer instanceof Member
         && $customer->isRegisteredCustomer()
        ) {
            $map = array_merge(
                    [
                        'new' => _t('SilvercartProductList.CreateNewList'),
                    ],
                    $customer->SilvercartProductLists()->map()->toArray()
            );
        } else {
            $map = [
                'new' => _t('SilvercartProductList.AccountRequired'),
            ];
        }
        $json = json_encode($map);
        return $json;
    }
    
    /**
     * Returns the product list by the given request params.
     * 
     * @param SS_HTTPRequest $request  Request
     * @param Member         $customer Customer context
     * 
     * @return SilvercartProductList
     */
    protected function getListByRequest(SS_HTTPRequest $request, Member $customer = null)
    {
        $list = null;
        if (is_null($customer)) {
            $customer = SilvercartCustomer::currentUser();
        }
        if ($customer instanceof Member
         && $customer->isRegisteredCustomer()
        ) {
            $params = $request->allParams();
            $listID = $params['OtherID'];

            if ($listID == 'new') {
                $list = SilvercartProductList::create();
                $list->MemberID = $customer->ID;
                $list->write();
            } else {
                $list = $customer->SilvercartProductLists()->byID($listID);
            }
        }
        return $list;
    }
}