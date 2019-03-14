<?php

namespace SilverCart\ProductLists\Control\Actions;

use SilverCart\ProductLists\Config\Config;
use SilverCart\ProductLists\Model\Product\ProductList;
use SilverStripe\Control\Controller;
use SilverStripe\Security\Member;

/**
 * Action to delete a ProductList.
 *
 * @package SilverCart
 * @subpackage ProductLists_Control_Actions
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2018 pixeltricks GmbH
 * @since 24.08.2018
 * @license see license file in modules base directory
 */
class ProductListDeleteAction extends ProductListAction implements ProductListActionInterface
{
    /**
     * font awesome icon of the action
     *
     * @var string
     */
    private static $font_awesome_icon = 'trash';
    
    /**
     * Returns whether the given member can execute this action.
     * 
     * @param ProductList $list   List to check permission for
     * @param Member      $member Member to check permission for
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.04.2013
     */
    public function canExecute(ProductList $list, Member $member = null)
    {
        $canExecute = false;
        if (Config::AllowMultipleLists()) {
            if (is_null($member)) {
                $member = Member::currentUser();
            }
            if ($member instanceof Member &&
                $list->MemberID == $member->ID) {
                $canExecute = true;
            }
        }
        $this->extend('updateCanExecute', $canExecute);
        return $canExecute;
    }
    
    /**
     * Returns whether the given member can view this action.
     * 
     * @param ProductList $list   List to check permission for
     * @param Member      $member Member to check permission for
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.04.2013
     */
    public function canView(ProductList $list, Member $member = null)
    {
        return $this->canExecute($list, $member);
    }
    
    /**
     * Handles the action onto the given list.
     * 
     * @param ProductList $list List to handle action for
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.04.2013
     */
    public function handleList(ProductList $list)
    {
        if ($this->canExecute($list)) {
            $list->delete();
            Controller::curr()->redirect(Controller::curr()->Link());
        }
    }
    
}