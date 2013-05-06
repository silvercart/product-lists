<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilvercartProductList.
 *
 * @package SilvercartProductList
 * @subpackage Pages
 */

/**
 * Extension for SilvercartMyAccountHolder_Controller.
 *
 * @package SilvercartProductList
 * @subpackage Pages
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2013 pixeltricks GmbH
 * @since 24.04.2013
 * @license see license file in modules base directory
 */
class SilvercartProductListMyAccountHolder_Controller extends DataObjectDecorator {
    
    /**
     * Current context list.
     *
     * @var SilvercartProductList
     */
    protected $currentList = null;
    
    /**
     * Returns the current context list.
     * 
     * @return SilvercartProductList
     */
    public function getCurrentList() {
        return $this->currentList;
    }

    /**
     * Sets the current context list.
     * 
     * @param SilvercartProductList $currentList List to set.
     * 
     * @return void
     */
    public function setCurrentList($currentList) {
        $this->currentList = $currentList;
    }
    
}