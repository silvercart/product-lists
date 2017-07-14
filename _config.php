<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilvercartProductList.
 *
 * @package SilvercartProductList
 * @subpackage Config
 * @ignore
 */

if (class_exists('RequirementsEngine')) {
    RequirementsEngine::registerThemedCssFile('SilvercartProductList');
}

SilvercartProductListAction::add('SilvercartProductListConvertToCartAction');
SilvercartProductListAction::add('SilvercartProductListDeleteAction');
SilvercartProductListAction::add('SilvercartProductListDuplicateAction');
SilvercartProductListAction::add('SilvercartProductListSetAsDefaultAction');