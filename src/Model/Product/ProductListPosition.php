<?php

namespace SilverCart\ProductLists\Model\Product;

use Moo\HasOneSelector\Form\Field as HasOneSelector;
use SilverCart\Dev\Tools;
use SilverCart\Model\Product\Product;
use SilverCart\ProductLists\Model\Pages\ProductListPage;
use SilverCart\ProductLists\Model\Product\ProductList;
use SilverStripe\Control\Director;
use SilverStripe\Forms\FieldList;
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
    use \SilverCart\ORM\ExtensibleDataObject;
    
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
     * @return string
     */
    public function singular_name() : string
    {
        return Tools::singular_name_for($this);
    }

    /**
     * Returns the translated plural name of the object. If no translation exists
     * the class name will be returned.
     *
     * @return string
     */
    public function plural_name() : string
    {
        return Tools::plural_name_for($this);
    }
    
    /**
     * Returns the field labels
     * 
     * @param bool $includerelations Include relations or not?
     * 
     * @return array
     */
    public function fieldLabels($includerelations = true) : array
    {
        return $this->defaultFieldLabels($includerelations, []);
    }
    
    /**
     * customizes the backends fields, mainly for ModelAdmin
     *
     * @return FieldList the fields for the backend
     */
    public function getCMSFields() : FieldList
    {
        $this->beforeUpdateCMSFields(function(FieldList $fields) {
            if (class_exists(HasOneSelector::class)) {
                $fields->removeByName('ProductID');
                $productField = HasOneSelector::create('Product', $this->fieldLabel('Product'), $this, Product::class)->setLeftTitle($this->fieldLabel('Product'));
                $productField->removeAddable();
                $fields->insertAfter('ProductListID', $productField);
            }
        });
        return parent::getCMSFields();
    }
    
    /**
     * Returns the summary fields
     * 
     * @return array
     */
    public function summaryFields() : array
    {
        $summaryFields = [
            'Created.Date'                => $this->fieldLabel('Created'),
            'Product.ProductNumberShop'   => $this->Product()->fieldLabel('ProductNumberShop'),
            'Product.Title'               => $this->Product()->fieldLabel('Title'),
            'Product.Price'               => $this->Product()->fieldLabel('Price'),
        ];
        
        $this->extend('updateSummaryFields', $summaryFields);
        
        return $summaryFields;
    }

    /**
     * Returns the link to remove this position from the list.
     * 
     * @return string
     */
    public function RemoveLink() : string
    {
        return Tools::PageByIdentifierCode(ProductListPage::IDENTIFIER_PRODUCT_LIST_PAGE)->Link('removeitem') . '/' . $this->ProductListID . '/' . $this->ID;
    }

    /**
     * Returns the link to add this position to the cart.
     * 
     * @return string
     */
    public function AddToCartLink() : string
    {
        return Director::makeRelative('sc-action/addToCart') . '/' . $this->ProductID . '/1';
    }

    /**
     * Returns the link to add this position to the cart.
     * 
     * @return string
     */
    public function AddToCartAndRemoveFromListLink() : string
    {
        return Director::makeRelative("silvercart-product-list/addToCartAndRemoveFromList/{$this->ProductID}/{$this->ProductListID}");
    }
}