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
     * @return DataObjectSet
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function SilvercartProductLists() {
        if (Member::currentUserID()) {
            $lists = SilvercartProductList::get_by_member(Member::currentUser());
        } else {
            $lists = new DataObjectSet();
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
        Director::redirect($this->Link('detail') . '/' . $listID);
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
        $list   = DataObject::get_by_id('SilvercartProductList', $listID);
        $actionHandler = new $action();
        $actionHandler->handleList($list);
        if (!Director::redirected_to()) {
            Director::redirect($this->Link('detail') . '/' . $listID);
        }
    }

    /**
     * manipulates the defaul logic of building the pages breadcrumbs if a
     * product detail view is requested.
     *
     * @param int    $maxDepth       maximum depth level of shown pages in breadcrumbs
     * @param bool   $unlinked       true, if the breadcrumbs should be displayed without links
     * @param string $stopAtPageType name of pagetype to stop at
     * @param bool   $showHidden     true, if hidden pages should be displayed in breadcrumbs
     *
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.04.2013
     */
    public function Breadcrumbs($maxDepth = 20, $unlinked = false, $stopAtPageType = false, $showHidden = false) {
        if ($this->getCurrentList() instanceof SilvercartProductList) {
            $parts      = $this->BreadcrumbParts($maxDepth, $unlinked, $stopAtPageType, $showHidden);
            $partsArray = array();
            foreach ($parts as $part) {
                if (empty($part->Link)) {
                    $partsArray[] = Convert::raw2xml($part->Title);
                } else {
                    if ($unlinked) {
                        $partsArray[] = Convert::raw2xml($part->Title);
                    } else {
                        $partsArray[] = "<a href=\"" . $part->Link . "\">" . Convert::raw2xml($part->Title) . "</a>";
                    }
                }
            }
            
            return implode(Page::$breadcrumbs_delimiter, $partsArray);
        }
        return parent::Breadcrumbs($maxDepth, $unlinked, $stopAtPageType, $showHidden);
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
     * @return DataObjectSet
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
     * @return DataObjectSet
     */
    public function getListActions(SilvercartProductList $list = null) {
        if (is_null($list)) {
            $list = $this->getCurrentList();
        }
        $registered_actions = SilvercartProductListAction::get_registered_actions();
        $actions            = new DataObjectSet();
        foreach ($registered_actions as $action) {
            $actionObject = new $action();
            if ($actionObject->canView($list)) {
                $actions->push($actionObject);
            }
        }
        return $actions;
    }
    
}