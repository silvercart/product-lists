<?php

use SilverCart\ProductLists\Control\Actions\{
    ProductListAction,
    ProductListConvertToCartAction,
    ProductListDeleteAction,
    ProductListDuplicateAction,
    ProductListSetAsDefaultAction
};

ProductListAction::add(ProductListConvertToCartAction::class);
ProductListAction::add(ProductListDeleteAction::class);
ProductListAction::add(ProductListDuplicateAction::class);
ProductListAction::add(ProductListSetAsDefaultAction::class);