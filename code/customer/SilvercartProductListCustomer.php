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
class SilvercartProductListCustomer extends DataObjectDecorator {
    
    /**
     * Indicator whether updateCMSFields is already called
     *
     * @var bool
     */
    protected $updateCMSFieldsIsCalled = false;
    
    /**
     * Extra static attributes
     * 
     * @return array
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function extraStatics() {
        return array(
            'has_many' => array(
                'SilvercartProductLists' => 'SilvercartProductList',
            ),
        );
    }
    
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
     * @param FieldSet &$fields CMS fields to update
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.12.2012
     */
    public function updateCMSFields(FieldSet &$fields) {
        if (!$this->updateCMSFieldsIsCalled) {
            $this->updateCMSFieldsIsCalled = true;
        }
        
    }
    
}
