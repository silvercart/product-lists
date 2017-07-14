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
class SilvercartProductListActionHandler extends Controller {
    
    /**
     * Allowed actions
     *
     * @var array
     */
    private static $allowed_actions = array(
        'addToList',
        'getLists',
    );
    
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
    public function addToList(SS_HTTPRequest $request) {
        $customer = SilvercartCustomer::currentUser();
        if ($customer instanceof Member &&
            $customer->isRegisteredCustomer()) {
            
            $params     = $request->allParams();
            $productID  = $params['ID'];
            $listID     = $params['OtherID'];

            if ($listID == 'new') {
                $list = new SilvercartProductList();
                $list->MemberID = $customer->ID;
                $list->write();
            } else {
                $list = $customer->SilvercartProductLists()->byID($listID);
            }

            if ($list instanceof SilvercartProductList) {
                $product = SilvercartProduct::get()->byID($productID);
                if ($product instanceof SilvercartProduct &&
                    $product->canView($customer)) {

                    $list->addProduct($product);
                }
            }
            $this->redirectBack();
        } else {
            $this->redirect(SilvercartTools::PageByIdentifierCode('SilvercartMyAccountHolder')->Link());
        }
    }
    
    /**
     * Returns the current customers lists as a JSON string.
     * 
     * @return string
     */
    public function getLists() {
        $customer = SilvercartCustomer::currentUser();
        if ($customer instanceof Member &&
            $customer->isRegisteredCustomer()) {
            $map = array(
                    'new' => _t('SilvercartProductList.CreateNewList'),
            ) + $customer->SilvercartProductLists()->map()->toArray();
        } else {
            $map = array(
                'new' => _t('SilvercartProductList.AccountRequired'),
            );
        }
        $json = json_encode($map);
        return $json;
    }
    
}