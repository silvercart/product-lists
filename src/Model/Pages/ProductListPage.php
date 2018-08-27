<?php

namespace SilverCart\ProductLists\Model\Pages;

use SilverCart\Dev\Tools;
use SilverCart\Model\Pages\MyAccountHolder;
use SilverCart\ProductLists\Model\Product\ProductList;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\Security\Member;
use SilverStripe\Versioned\Versioned;
use SilverStripe\View\ArrayData;

/**
 * Page to display product lists.
 *
 * @package SilverCart
 * @subpackage ProductLists_Model_Pages
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2018 pixeltricks GmbH
 * @since 23.08.2018
 * @license see license file in modules base directory
 */
class ProductListPage extends MyAccountHolder
{
    /**
     * Returns the lists of the current member.
     * 
     * @return SS_List
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function ProductLists()
    {
        if (Member::currentUserID()) {
            $lists = ProductList::get_by_member(Member::currentUser());
        } else {
            $lists = ArrayList::create();
        }
        return $lists;
    }
    
    /**
     * Returns whether this page has a summary.
     * 
     * @return boolean
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 29.04.2013
     */
    public function hasSummary()
    {
        return true;
    }
    
    /**
     * Returns the summary of this page.
     * 
     * @return string
     */
    public function getSummary()
    {
        return $this->renderWith(ProductListPage::class . 'Table');
    }
    
    /**
     * Returns the summary of this page.
     * 
     * @return string
     */
    public function getSummaryTitle()
    {
        return _t(ProductListPage::class . '.YOUR_LISTS', 'Your Lists');
    }

    /**
     * Creates the default records if not done yet.
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 25.04.2013
     */
    public function requireDefaultRecords()
    {
        $page = Tools::PageByIdentifierCode('SilvercartProductListPage');
        if (!($page instanceof ProductListPage)) {
            $rootPage = Tools::PageByIdentifierCode('SilvercartMyAccountHolder');
            if (!$rootPage instanceof MyAccountHolder) {
                return;
            }
            $page = ProductListPage::create();
            $page->Title          = _t(ProductListPage::class . '.DEFAULT_TITLE', 'My Lists');
            $page->URLSegment     = _t(ProductListPage::class . '.DEFAULT_URLSEGMENT', 'lists');
            $page->ShowInMenus    = true;
            $page->ShowInSearch   = false;
            $page->IdentifierCode = "SilvercartProductListPage";
            $page->ParentID       = $rootPage->ID;
            $page->write();
            $page->copyVersionToStage(Versioned::DRAFT, Versioned::LIVE);
        }
    }
    
    /**
     * Adds the add/edit address title to the bradcrumbs by context.
     *
     * @param int    $maxDepth       maximum depth level of shown pages in breadcrumbs
     * @param string $stopAtPageType name of pagetype to stop at
     * @param bool   $showHidden     true, if hidden pages should be displayed in breadcrumbs
     * 
     * @return ArrayList
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.08.2018
     */
    public function getBreadcrumbItems($maxDepth = 20, $stopAtPageType = false, $showHidden = false)
    {
        $items = parent::getBreadcrumbItems($maxDepth, $stopAtPageType, $showHidden);
        $ctrl  = Controller::curr();
        if ($ctrl->getCurrentList() instanceof ProductList) {
            $title = DBText::create();
            $title->setValue($ctrl->getCurrentList()->Title);
            $items->push(ArrayData::create([
                'MenuTitle' => $title,
                'Title'     => $title,
                'Link'      => $this->Link('detail/' . $ctrl->getCurrentList()->ID),
            ]));
        }
        return $items;
    }
}