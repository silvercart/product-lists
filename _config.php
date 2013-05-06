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

Director::addRules(
        100,
        array(
            'silvercart-product-list/$Action/$ID/$OtherID' => 'SilvercartProductListActionHandler',
        )
);

Object::add_extension('Member',                                 'SilvercartProductListCustomer');
Object::add_extension('SilvercartProduct',                      'SilvercartProductListProduct');
Object::add_extension('SilvercartMyAccountHolder_Controller',   'SilvercartProductListMyAccountHolder_Controller');

RequirementsEngine::registerThemedCssFile('SilvercartProductList');

SilvercartProductListAction::add('SilvercartProductListConvertToCartAction');
SilvercartProductListAction::add('SilvercartProductListDeleteAction');
SilvercartProductListAction::add('SilvercartProductListDuplicateAction');
SilvercartProductListAction::add('SilvercartProductListSetAsDefaultAction');