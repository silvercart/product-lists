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
    public static $allowed_actions = array(
        'addToList',
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
            $list = Member::currentUser()->SilvercartProductLists()->find('ID', $listID);
        }
        
        if ($list instanceof SilvercartProductList) {
            $product = DataObject::get_by_id('SilvercartProduct', $productID);
            if ($product instanceof SilvercartProduct &&
                $product->canView(Member::currentUser())) {
                
                $list->addProduct($product);
            }
        }
        Director::redirectBack();
    }
    
}