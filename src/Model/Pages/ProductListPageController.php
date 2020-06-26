<?php

namespace SilverCart\ProductLists\Model\Pages;

use SilverCart\Model\Customer\Customer;
use SilverCart\Model\Pages\MyAccountHolderController;
use SilverCart\ProductLists\Model\Product\ProductList;
use SilverCart\ProductLists\Model\Product\ProductListPosition;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Core\Convert;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Security\Member;

/**
 * Controller of page to display product lists.
 *
 * @package SilverCart
 * @subpackage ProductLists_Model_Pages
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2018 pixeltricks GmbH
 * @since 24.08.2018
 * @license see license file in modules base directory
 */
class ProductListPageController extends MyAccountHolderController
{
    /**
     * A list of allowed actions
     *
     * @var array
     */
    private static $allowed_actions = [
        'detail',
        'update',
        'execute',
        'removeitem',
    ];
    /**
     * The current context list.
     *
     * @var ProductList
     */
    protected $currentList = null;
    
    /**
     * Returns the current context list.
     * 
     * @return ProductList
     */
    public function getCurrentList() : ?ProductList
    {
        return $this->currentList;
    }

    /**
     * Sets the current context list.
     * 
     * @param ProductList $currentList List to set.
     * 
     * @return ProductListPageController
     */
    public function setCurrentList(ProductList $currentList) : ProductListPageController
    {
        $this->currentList = $currentList;
        return $this;
    }

    /**
     * Action to show a lists details.
     * Returns the redered details.
     * 
     * @param HTTPRequest $request Request to handle
     * 
     * @return HTTPResponse
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.08.2018
     */
    public function detail(HTTPRequest $request) : HTTPResponse
    {
        $params = $request->allParams();
        $listID = (int) $params['ID'];
        $list   = ProductList::get()->byID($listID);
        $this->setCurrentList($list);
        return HTTPResponse::create($this->render(), 200);
    }

    /**
     * Action to update a lists details.
     * Directs to the lists details.
     * 
     * @param HTTPRequest $request Request to handle
     * 
     * @return HTTPResponse
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 25.04.2013
     */
    public function update(HTTPRequest $request) : HTTPResponse
    {
        $params = $request->allParams();
        $listID = (int) $params['ID'];
        $list   = ProductList::get()->byID($listID);
        $list->Title = Convert::raw2sql($request->postVar('Title'));
        $list->write();
        return $this->redirect($this->Link('detail') . '/' . $listID);
    }

    /**
     * Action to execute a list action.
     * Directs to the lists details when the list action did not a redirect.
     * 
     * @param HTTPRequest $request Request to handle
     * 
     * @return HTTPResponse
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 25.04.2019
     */
    public function execute(HTTPRequest $request) : ?HTTPResponse
    {
        $params = $request->allParams();
        $hash   = $params['ID'];
        $listID = (int) $params['OtherID'];
        $list   = ProductList::get()->byID($listID);
        if ($list instanceof ProductList) {
            foreach ($list->getListActions() as $action) {
                if ($action->getActionHash() == $hash) {
                    $action->handleList($list);
                    break;
                }
            }
        }
        if (!$this->redirectedTo()) {
            return $this->redirectBack();
        }
        return null;
    }

    /**
     * Action to delete a lists position.
     * 
     * @param HTTPRequest $request Request to handle
     * 
     * @return HTTPResponse
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.08.2018
     */
    public function removeitem(HTTPRequest $request) : ?HTTPResponse
    {
        $params = $request->allParams();
        $listID = (int) $params['ID'];
        $itemID = (int) $params['OtherID'];
        $list   = ProductList::get()->byID($listID);
        $item   = ProductListPosition::get()->byID($itemID);
        $member = Customer::currentUser();
        if ($member instanceof Member
            && $list instanceof ProductList
            && $list->MemberID == $member->ID
            && $item instanceof ProductListPosition
            && $item->ProductListID == $list->ID
        ) {
            $item->delete();
        }
        if (!$this->redirectedTo()) {
            return $this->redirectBack();
        }
        return null;
    }
    
    /**
     * Returns the actions for the current list
     * 
     * @param ProductList $list List to get actions for
     * 
     * @return ArrayList
     */
    public function getListActions(ProductList $list = null) : ArrayList
    {
        if (is_null($list)) {
            $list = $this->getCurrentList();
        }
        if ($list instanceof ProductList) {
            $actions = $list->getListActions();
        } else {
            $actions = ArrayList::create();
        }
        return $actions;
    }
}