<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilvercartProductList.
 *
 * @package SilvercartProductList
 * @subpackage Customer
 */

/**
 * Extension for products
 *
 * @package SilvercartProductList
 * @subpackage Customer
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2013 pixeltricks GmbH
 * @since 24.04.2013
 * @license see license file in modules base directory
 */
class SilvercartProductListCustomer extends DataExtension {
    
    /**
     * Has many relations
     *
     * @var array
     */
    private static $has_many = array(
        'SilvercartProductLists' => 'SilvercartProductList',
    );

    /**
     * Indicator whether updateCMSFields is already called
     *
     * @var bool
     */
    protected $updateCMSFieldsIsCalled = false;
    
    /**
     * Updates the field labels
     * 
     * @param array &$labels Labels to update
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function updateFieldLabels(&$labels) {
        $labels = array_merge(
                $labels,
                array(
                    'SilvercartProductLists' => _t('SilvercartProductList.PLURALNAME'),
                )
        );
    }

    /**
     * Updates the CMS fields
     * 
     * @param FieldList &$fields CMS fields to update
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.12.2012
     */
    public function updateCMSFields(FieldList $fields) {
        if (!$this->updateCMSFieldsIsCalled) {
            $this->updateCMSFieldsIsCalled = true;
        }
        
    }
    
}
