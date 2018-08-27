<?php

namespace SilverCart\ProductLists\Extensions\Pages;

use SilverStripe\Core\Extension;
use SilverCart\ProductLists\Model\Product\ProductList;

/**
 * Extension for SilverCart PageController.
 *
 * @package SilverCart
 * @subpackage ProductLists_Extensions_Pages
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 23.08.2018
 * @license see license file in modules root directory
 * @copyright 2018 pixeltricks GmbH
 */
class PageControllerExtension extends Extension
{
    /**
     * Adds in session stored products to the default list or a new list.
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 27.08.2018
     */
    public function onAfterInit()
    {
        ProductList::add_products_from_session();
    }
    
    /**
     * Adds some JS files.
     * 
     * @param array &$jsFiles JS files
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.07.2018
     */
    public function updateRequireExtendedJavaScript(&$jsFiles)
    {
        $jsFiles = array_merge(
            $jsFiles,
            [
                'silvercart/product-lists:client/js/ProductList.js',
            ]
        );
    }
}