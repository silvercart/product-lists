<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilvercartProductList.
 *
 * @package SilvercartProductList
 * @subpackage Pages
 */

/**
 * Page to display product lists.
 *
 * @package SilvercartProductList
 * @subpackage Pages
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2013 pixeltricks GmbH
 * @since 24.04.2013
 * @license see license file in modules base directory
 */
class SilvercartProductListPage extends SilvercartMyAccountHolder {
    
    /**
     * Returns the lists of the current member.
     * 
     * @return SS_List
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function SilvercartProductLists() {
        if (Member::currentUserID()) {
            $lists = SilvercartProductList::get_by_member(Member::currentUser());
        } else {
            $lists = new ArrayList();
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
    public function hasSummary() {
        return true;
    }
    
    /**
     * Returns the summary of this page.
     * 
     * @return string
     */
    public function getSummary() {
        return $this->renderWith('SilvercartProductListTable');
    }
    
    /**
     * Returns the summary of this page.
     * 
     * @return string
     */
    public function getSummaryTitle() {
        return _t('SilvercartProductListPage.YOUR_LISTS');
    }

    /**
     * Creates the default records if not done yet.
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 25.04.2013
     */
    public function requireDefaultRecords() {
        $page = SilvercartTools::PageByIdentifierCode('SilvercartProductListPage');
        if (!($page instanceof SilvercartProductListPage)) {
            $rootPage = SilvercartTools::PageByIdentifierCode('SilvercartMyAccountHolder');
            $page = new SilvercartProductListPage();
            $page->Title            = _t('SilvercartProductListPage.DEFAULT_TITLE');
            $page->URLSegment       = _t('SilvercartProductListPage.DEFAULT_URLSEGMENT', 'lists');
            $page->Status           = "Published";
            $page->ShowInMenus      = true;
            $page->ShowInSearch     = false;
            $page->IdentifierCode   = "SilvercartProductListPage";
            $page->ParentID         = $rootPage->ID;
            $page->write();
            $page->publish("Stage", "Live");
        }
    }
    
}

/**
 * Controller of page to display product lists.
 *
 * @package SilvercartProductList
 * @subpackage Pages
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2013 pixeltricks GmbH
 * @since 24.04.2013
 * @license see license file in modules base directory
 */
class SilvercartProductListPage_Controller extends SilvercartMyAccountHolder_Controller {
    
    /**
     * A list of allowed actions
     *
     * @var array
     */
    public static $allowed_actions = array(
        'detail',
        'update',
        'execute',
        'removeitem',
    );
    
    /**
     * The current context list.
     *
     * @var SilvercartProductList
     */
    protected $currentList = null;
    
    /**
     * Returns the current context list.
     * 
     * @return SilvercartProductList
     */
    public function getCurrentList() {
        return $this->currentList;
    }

    /**
     * Sets the current context list.
     * 
     * @param SilvercartProductList $currentList List to set.
     * 
     * @return void
     */
    public function setCurrentList($currentList) {
        $this->currentList = $currentList;
    }

    /**
     * Action to show a lists details.
     * Returns the redered details.
     * 
     * @param SS_HTTPRequest $request Request to handle
     * 
     * @return string
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 25.04.2013
     */
    public function detail(SS_HTTPRequest $request) {
        $params = $request->allParams();
        $listID = (int) $params['ID'];
        $list   = DataObject::get_by_id('SilvercartProductList', $listID);
        $this->setCurrentList($list);
        return $this->render();
    }

    /**
     * Action to update a lists details.
     * Directs to the lists details.
     * 
     * @param SS_HTTPRequest $request Request to handle
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 25.04.2013
     */
    public function update(SS_HTTPRequest $request) {
        $params = $request->allParams();
        $listID = (int) $params['ID'];
        $list   = DataObject::get_by_id('SilvercartProductList', $listID);
        $list->Title = Convert::raw2sql($request->postVar('Title'));
        $list->write();
        $this->redirect($this->Link('detail') . '/' . $listID);
    }

    /**
     * Action to execute a list action.
     * Directs to the lists details when the list action did not a redirect.
     * 
     * @param SS_HTTPRequest $request Request to handle
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 25.04.2013
     */
    public function execute(SS_HTTPRequest $request) {
        $params = $request->allParams();
        $action = $params['ID'];
        $listID = (int) $params['OtherID'];
        $list   = SilvercartProductList::get()->byID($listID);
        $actionHandler = new $action();
        $actionHandler->handleList($list);
        $this->redirect($this->Link('detail') . '/' . $listID);
    }

    /**
     * Action to delete a lists position.
     * 
     * @param SS_HTTPRequest $request Request to handle
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.08.2018
     */
    public function removeitem(SS_HTTPRequest $request)
    {
        $params = $request->allParams();
        $listID = (int) $params['ID'];
        $itemID = (int) $params['OtherID'];
        $list   = SilvercartProductList::get()->byID($listID);
        $item   = SilvercartProductListPosition::get()->byID($itemID);
        $member = SilvercartCustomer::currentUser();
        if ($member instanceof Member
         && $list instanceof SilvercartProductList
         && $list->MemberID == $member->ID
         && $item instanceof SilvercartProductListPosition
         && $item->SilvercartProductListID == $list->ID
        ) {
            $item->delete();
        }
        $this->redirectBack();
    }

    /**
     * manipulates the defaul logic of building the pages breadcrumbs if a
     * product detail view is requested.
     *
     * @param Controller $context        the current controller
     * @param int        $maxDepth       maximum depth level of shown pages in breadcrumbs
     * @param bool       $unlinked       true, if the breadcrumbs should be displayed without links
     * @param string     $stopAtPageType name of pagetype to stop at
     * @param bool       $showHidden     true, if hidden pages should be displayed in breadcrumbs
     *
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function ContextBreadcrumbs($context, $maxDepth = 20, $unlinked = false, $stopAtPageType = false, $showHidden = false) {
        $breadcrumbs = parent::ContextBreadcrumbs($context, $maxDepth, $unlinked, $stopAtPageType, $showHidden);
        if ($this->getCurrentList() instanceof SilvercartProductList) {
            $parts = explode(" &raquo; ", $breadcrumbs);
            $listPage = array_pop($parts);
            $parts[] = ("<a href=\"" . $this->Link() . "\">" . $listPage . "</a>");
            $parts[] = $this->getCurrentList()->Title;
            $breadcrumbs = implode(" &raquo; ", $parts);
        }
        return $breadcrumbs;
    }

    /**
     * manipulates the parts the pages breadcrumbs if a product detail view is 
     * requested.
     *
     * @param int    $maxDepth       maximum depth level of shown pages in breadcrumbs
     * @param bool   $unlinked       true, if the breadcrumbs should be displayed without links
     * @param string $stopAtPageType name of pagetype to stop at
     * @param bool   $showHidden     true, if hidden pages should be displayed in breadcrumbs
     * 
     * @return ArrayList
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function BreadcrumbParts($maxDepth = 20, $unlinked = false, $stopAtPageType = false, $showHidden = false) {
        $parts = parent::BreadcrumbParts($maxDepth, $unlinked, $stopAtPageType, $showHidden);
        
        if ($this->getCurrentList() instanceof SilvercartProductList) {
            $parts->push(
                    new ArrayData(
                            array(
                                'Title' => $this->getCurrentList()->Title,
                                'Link'  => '',
                            )
                    )
            );
        }
        
        return $parts;
    }
    
    /**
     * Returns the actions for the current list
     * 
     * @param SilvercartProductList $list List to get actions for
     * 
     * @return ArrayList
     */
    public function getListActions(SilvercartProductList $list = null) {
        if (is_null($list)) {
            $list = $this->getCurrentList();
        }
        $registered_actions = SilvercartProductListAction::get_registered_actions();
        $actions            = new ArrayList();
        foreach ($registered_actions as $action) {
            $actionObject = new $action();
            if ($actionObject->canView($list) &&
                $actionObject->isVisible()) {
                $actions->push($actionObject);
            }
        }
        return $actions;
    }
    
}

/**
 * Extension for SilvercartPage
 * 
 * @package SilvercartProductList
 * @subpackage Pages
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2017 pixeltricks GmbH
 * @since 14.07.2017
 * @license see license file in modules base directory
 */
class SilvercartProductListPage_ControllerExtension extends DataExtension {
    
    /**
     * Updates the JS requirements.
     * 
     * @param array &$jsFiles JS file list to update
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 14.07.2017
     */
    public function updatedJSRequirements(&$jsFiles) {
        $jsFiles[] = 'silvercart_product_lists/js/SilvercartProductList.js';
    }
    
}