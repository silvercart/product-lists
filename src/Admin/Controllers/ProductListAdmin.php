<?php

namespace SilverCart\ProductLists\Admin\Controllers;

use SilverCart\Admin\Controllers\ModelAdmin;
use SilverCart\ProductLists\Model\Product\ProductList;

/**
 * ModelAdmin for ProductList.
 * 
 * @package SilverCart
 * @subpackage ProductLists\Admin\Controllers
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2022 pixeltricks GmbH
 * @since 03.05.2022
 * @license see license file in modules root directory
 */
class ProductListAdmin extends ModelAdmin
{
    /**
     * The code of the menu under which this admin should be shown.
     * 
     * @var string
     */
    private static $menuCode = 'customer';
    /**
     * The section of the menu under which this admin should be grouped.
     * 
     * @var string
     */
    private static $menuSortIndex = 100;
    /**
     * The URL segment
     *
     * @var string
     */
    private static $url_segment = 'silvercart-product-lists';
    /**
     * The menu title
     *
     * @var string
     */
    private static $menu_title = 'Product Lists';
    /**
     * Menu icon
     * 
     * @var string
     */
    private static $menu_icon = null;
    /**
     * Menu icon CSS class
     * 
     * @var string
     */
    private static $menu_icon_class = 'font-icon-p-list';
    /**
     * Managed models
     *
     * @var array
     */
    private static $managed_models = [
        ProductList::class,
    ];
}