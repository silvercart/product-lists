<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilvercartProductList.
 *
 * @package SilvercartProductList
 * @subpackage i18n
 */

i18n::include_locale_file('silvercart_product_lists', 'en_US');

global $lang;

if (array_key_exists('de_DE', $lang) && is_array($lang['de_DE'])) {
    $lang['de_DE'] = array_merge($lang['en_US'], $lang['de_DE']);
} else {
    $lang['de_DE'] = $lang['en_US'];
}

$lang['de_DE']['SilvercartProductList']['PLURALNAME']                           = 'Artikellisten';
$lang['de_DE']['SilvercartProductList']['SINGULARNAME']                         = 'Artikelliste';
$lang['de_DE']['SilvercartProductList']['DUPLICATION']                          = 'Kopie';
$lang['de_DE']['SilvercartProductList']['EDIT']                                 = 'Liste bearbeiten';
$lang['de_DE']['SilvercartProductList']['EDIT_SHORT']                           = 'B';
$lang['de_DE']['SilvercartProductList']['SHOW_DETAILS']                         = 'Details anzeigen';
$lang['de_DE']['SilvercartProductList']['SHOW_DETAILS_SHORT']                   = 'Details';
$lang['de_DE']['SilvercartProductList']['ISDEFAULT']                            = 'Als Standard verwenden';
$lang['de_DE']['SilvercartProductList']['TITLE']                                = 'Name';
$lang['de_DE']['SilvercartProductList']['TITLE_DEFAULT']                        = 'Liste vom %s Uhr';
$lang['de_DE']['SilvercartProductList']['TITLE_DEFAULT_DATEFORMAT']             = 'd.m.Y H:i';

$lang['de_DE']['SilvercartProductListPosition']['PLURALNAME']                   = 'Artikellisten-Positionen';
$lang['de_DE']['SilvercartProductListPosition']['SINGULARNAME']                 = 'Artikellisten-Position';

$lang['de_DE']['SilvercartProductListPage']['PLURALNAME']                       = 'Artikellisten-Seiten';
$lang['de_DE']['SilvercartProductListPage']['SINGULARNAME']                     = 'Artikellisten-Seite';
$lang['de_DE']['SilvercartProductListPage']['DEFAULT_TITLE']                    = 'Meine Listen';
$lang['de_DE']['SilvercartProductListPage']['DEFAULT_URLSEGMENT']               = 'listen';
$lang['de_DE']['SilvercartProductListPage']['YOUR_LISTS']                       = 'Ihre Merklisten';

$lang['de_DE']['SilvercartProductListTable.ss']['COL_COUNT']                    = 'Anzahl Artikel';
$lang['de_DE']['SilvercartProductListTable.ss']['COL_CREATED']                  = 'Erstellt am';
$lang['de_DE']['SilvercartProductListTable.ss']['COL_LASTEDITED']               = 'Zuletzt geändert am';
$lang['de_DE']['SilvercartProductListTable.ss']['COL_NAME']                     = 'Name';
$lang['de_DE']['SilvercartProductListTable.ss']['NO_LIST_AVAILABLE']            = 'Noch keine Listen vorhanden';

$lang['de_DE']['SilvercartProductListDeleteAction']['TITLE']                    = 'Löschen';
$lang['de_DE']['SilvercartProductListDeleteAction']['BUTTONTITLE']              = 'Liste löschen';
$lang['de_DE']['SilvercartProductListDeleteAction']['BUTTONTITLESHORT']         = '-';

$lang['de_DE']['SilvercartProductListDuplicateAction']['TITLE']                 = 'Duplizieren';
$lang['de_DE']['SilvercartProductListDuplicateAction']['BUTTONTITLE']           = 'Liste duplizieren';
$lang['de_DE']['SilvercartProductListDuplicateAction']['BUTTONTITLESHORT']      = '+';

$lang['de_DE']['SilvercartProductListSetAsDefaultAction']['TITLE']              = 'Als Standard verwenden';
$lang['de_DE']['SilvercartProductListSetAsDefaultAction']['BUTTONTITLE']        = 'Liste als Standard verwenden';
$lang['de_DE']['SilvercartProductListSetAsDefaultAction']['BUTTONTITLESHORT']   = 'D';
