<?php

namespace SilverCart\ProductLists\Control\Actions;

use SilverCart\ProductLists\Model\Product\ProductList;
use SilverStripe\Security\Member;

/**
 * Interface for a ProductListAction
 *
 * @package SilverCart
 * @subpackage ProductLists_Control_Actions
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2018 pixeltricks GmbH
 * @since 24.08.2018
 * @license see license file in modules base directory
 */
interface ProductListActionInterface
{
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
    public function canExecute(ProductList $list, Member $member = null);
    
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
    public function canView(ProductList $list, Member $member = null);
    
    /**
     * Handles the given list.
     * 
     * @param ProductList $list List to handle
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.04.2013
     */
    public function handleList(ProductList $list);
}