<?php

namespace SilverCart\ProductLists\Extensions\Pages;

use SilverStripe\Core\Extension;

/**
 * Extension for MyAccountHolderController.
 *
 * @package SilverCart
 * @subpackage ProductLists_Extensions_Pages
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 23.08.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules base directory
 */
class MyAccountHolderControllerExtension extends Extension
{
    /**
     * Current context list.
     *
     * @var \SilverCart\ProductLists\Model\Product\ProductList
     */
    protected $currentList = null;
    
    /**
     * Returns the current context list.
     * 
     * @return \SilverCart\ProductLists\Model\Product\ProductList
     */
    public function getCurrentList()
    {
        return $this->currentList;
    }

    /**
     * Sets the current context list.
     * 
     * @param \SilverCart\ProductLists\Model\Product\ProductList $currentList List to set.
     * 
     * @return void
     */
    public function setCurrentList($currentList)
    {
        $this->currentList = $currentList;
    }
}