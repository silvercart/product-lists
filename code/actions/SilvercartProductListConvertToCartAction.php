<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilvercartProductList.
 *
 * @package SilvercartProductList
 * @subpackage Actions
 */

/**
 * Action to convert a SilvercartProductList into a shopping cart.
 *
 * @package SilvercartProductList
 * @subpackage Actions
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2013 pixeltricks GmbH
 * @since 01.03.2013
 * @license see license file in modules base directory
 */
class SilvercartProductListConvertToCartAction extends SilvercartProductListAction implements SilvercartProductListActionInterface
{
    /**
     * font awesome icon of the action
     *
     * @var string
     */
    private static $font_awesome_icon = 'shopping-cart';
    
    /**
     * Returns whether the given member can execute this action.
     * 
     * @param SilvercartProductList $list   List to check permission for
     * @param Member                $member Member to check permission for
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.04.2013
     */
    public function canExecute(SilvercartProductList $list, Member $member = null) {
        if (is_null($member)) {
            $member = SilvercartCustomer::currentUser();
        }
        $canExecute = false;
        if ($member->isRegisteredCustomer()) {
            $canExecute = true;
        }
        return $canExecute;
    }
    
    /**
     * Returns whether the given member can view this action.
     * 
     * @param SilvercartProductList $list   List to check permission for
     * @param Member                $member Member to check permission for
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.04.2013
     */
    public function canView(SilvercartProductList $list, Member $member = null) {
        return $this->canExecute($list, $member);
    }
    
    /**
     * Handles the action onto the given list.
     * 
     * @param SilvercartProductList $list List to handle action for
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.04.2013
     */
    public function handleList(SilvercartProductList $list) {
        if ($this->canExecute($list)) {
            $list->convertToCart();
            Controller::curr()->redirect(Controller::curr()->Link());
        }
    }
    
}