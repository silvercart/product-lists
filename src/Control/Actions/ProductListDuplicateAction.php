<?php

namespace SilverCart\ProductLists\Control\Actions;

use SilverCart\ProductLists\Model\Product\ProductList;
use SilverStripe\Control\Controller;
use SilverStripe\Security\Member;

/**
 * Action to duplicate a ProductList.
 *
 * @package SilverCart
 * @subpackage ProductLists_Control_Actions
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2018 pixeltricks GmbH
 * @since 24.08.2018
 * @license see license file in modules base directory
 */
class ProductListDuplicateAction extends ProductListAction implements ProductListActionInterface
{
    /**
     * font awesome icon of the action
     *
     * @var string
     */
    private static $font_awesome_icon = 'clone';
    
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
        if (is_null($member)) {
            $member = Member::currentUser();
        }
        $canExecute = false;
        if ($member instanceof Member &&
            $list->MemberID == $member->ID) {
            $canExecute = true;
        }
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
            $list->duplicate();
            Controller::curr()->redirect(Controller::curr()->Link());
        }
    }
    
}