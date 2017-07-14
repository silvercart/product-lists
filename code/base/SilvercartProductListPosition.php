<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilvercartProductList.
 *
 * @package SilvercartProductList
 * @subpackage Base
 */

/**
 * A position of a product list.
 * Belongs to a product list and a product.
 *
 * @package SilvercartProductList
 * @subpackage Base
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2013 pixeltricks GmbH
 * @since 01.03.2013
 * @license see license file in modules base directory
 */
class SilvercartProductListPosition extends DataObject {
    
    /**
     * Has one relations
     *
     * @var array
     */
    private static $has_one = array(
        'SilvercartProductList' => 'SilvercartProductList',
        'SilvercartProduct'     => 'SilvercartProduct',
    );
    
    /**
     * Returns the translated singular name of the object. If no translation exists
     * the class name will be returned.
     *
     * @return string The objects singular name
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function singular_name() {
        return SilvercartTools::singular_name_for($this);
    }

    /**
     * Returns the translated plural name of the object. If no translation exists
     * the class name will be returned.
     *
     * @return string the objects plural name
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function plural_name() {
        return SilvercartTools::plural_name_for($this);
    }
    
    /**
     * Returns the field labels
     * 
     * @param bool $includerelations Include relations or not?
     * 
     * @return array
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function fieldLabels($includerelations = true) {
        $labels = array_merge(
                parent::fieldLabels($includerelations),
                array(
                    'SilvercartProductList' => _t('SilvercartProductList.SINGULARNAME'),
                )
        );
        
        $this->extend('updateFieldLabels', $labels);
        
        return $labels;
    }
    
    /**
     * Returns the summary fields
     * 
     * @return array
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 30.04.2013
     */
    public function summaryFields() {
        $summaryFields = array(
            'SilvercartProduct.ProductNumberShop'   => $this->SilvercartProduct()->fieldLabel('ProductNumberShop'),
            'SilvercartProduct.Title'               => $this->SilvercartProduct()->fieldLabel('Title'),
        );
        
        $this->extend('updateSummaryFields', $summaryFields);
        
        return $summaryFields;
    }
    
}