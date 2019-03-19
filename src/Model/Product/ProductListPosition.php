<?php

namespace SilverCart\ProductLists\Model\Product;

use SilverCart\Dev\Tools;
use SilverCart\Model\Product\Product;
use SilverCart\ProductLists\Model\Product\ProductList;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataObject;

/**
 * A position of a product list.
 * Belongs to a product list and a product.
 *
 * @package SilverCart
 * @subpackage ProductLists_Model_Product
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2018 pixeltricks GmbH
 * @since 24.08.2018
 * @license see license file in modules base directory
 */
class ProductListPosition extends DataObject
{
    /**
     * Has one relations
     *
     * @var array
     */
    private static $has_one = [
        'ProductList' => ProductList::class,
        'Product'     => Product::class,
    ];
    /**
     * Table name
     *
     * @var array
     */
    private static $table_name = 'SilvercartProductListPosition';
    
    /**
     * Returns the translated singular name of the object. If no translation exists
     * the class name will be returned.
     *
     * @return string The objects singular name
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function singular_name()
    {
        return Tools::singular_name_for($this);
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
    public function plural_name()
    {
        return Tools::plural_name_for($this);
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
    public function fieldLabels($includerelations = true)
    {
        $labels = array_merge(
                parent::fieldLabels($includerelations),
                [
                    'ProductList' => ProductList::singleton()->singular_name(),
                ]
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
    public function summaryFields()
    {
        $summaryFields = [
            'Product.ProductNumberShop'   => $this->Product()->fieldLabel('ProductNumberShop'),
            'Product.Title'               => $this->Product()->fieldLabel('Title'),
        ];
        
        $this->extend('updateSummaryFields', $summaryFields);
        
        return $summaryFields;
    }

    /**
     * Returns the link to remove this position from the list.
     * 
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.08.2018
     */
    public function RemoveLink()
    {
        return Tools::PageByIdentifierCode('SilvercartProductListPage')->Link('removeitem') . '/' . $this->ProductListID . '/' . $this->ID;
    }

    /**
     * Returns the link to add this position to the cart.
     * 
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.08.2018
     */
    public function AddToCartLink()
    {
        return Director::makeRelative('sc-action/addToCart') . '/' . $this->ProductID . '/1';
    }

    /**
     * Returns the link to add this position to the cart.
     * 
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.08.2018
     */
    public function AddToCartAndRemoveFromListLink()
    {
        return Director::makeRelative("silvercart-product-list/addToCartAndRemoveFromList/{$this->ProductID}/{$this->ProductListID}");
    }
}