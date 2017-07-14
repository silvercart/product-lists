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
        $params     = $request->allParams();
        $productID  = $params['ID'];
        $listID     = $params['OtherID'];

        if ($listID == 'new') {
            $list = new SilvercartProductList();
            $list->MemberID = Member::currentUserID();
            $list->write();
        } else {
            $list = SilvercartCustomer::currentUser()->SilvercartProductLists()->byID($listID);
        }
        
        if ($list instanceof SilvercartProductList) {
            $product = SilvercartProduct::get()->byID($productID);
            if ($product instanceof SilvercartProduct &&
                $product->canView(SilvercartCustomer::currentUser())) {
                
                $list->addProduct($product);
            }
        }
        $this->redirectBack();
    }
    
    public function getLists() {
        $customer = SilvercartCustomer::currentUser();
        $map = array(
                'new' => _t('SilvercartProductList.CreateNewList'),
        ) + $customer->SilvercartProductLists()->map()->toArray();
        $json = json_encode($map);
        return $json;
    }
    
}