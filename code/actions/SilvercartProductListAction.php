<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilvercartProductList.
 *
 * @package SilvercartProductList
 * @subpackage Actions
 */

/**
 * Base class for a action to execute on a SilvercartProductList.
 *
 * @package SilvercartProductList
 * @subpackage Actions
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2013 pixeltricks GmbH
 * @since 01.03.2013
 * @license see license file in modules base directory
 */
class SilvercartProductListAction extends Controller {
    
    /**
     * Button title of the action
     *
     * @var string
     */
    protected $buttontitle = null;
    
    /**
     * Button title of the action
     *
     * @var string
     */
    protected $buttontitleshort = null;
    
    /**
     * Title of the action
     *
     * @var string
     */
    protected $title = null;
    
    /**
     * A list of registered actions
     *
     * @var array
     */
    public static $registered_actions = array();
    
    /**
     * A list of blacklisted actions
     *
     * @var array
     */
    public static $blacklisted_actions = array();
    
    /**
     * Returns the linkt to execute the action.
     * If $action is given, the alternative action will be used instead.
     * 
     * @param string $action Alternative action to use
     * 
     * @return string
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.04.2013
     */
    public function Link($action = 'execute') {
        return SilvercartTools::PageByIdentifierCode('SilvercartProductListPage')->Link($action) . '/' . $this->ID;
    }

    /**
     * Returns the button title
     * 
     * @return string
     */
    public function getButtonTitle() {
        if (is_null($this->buttontitle)) {
            $this->buttontitle = _t($this->class . '.BUTTONTITLE', $this->class);
        }
        return $this->buttontitle;
    }

    /**
     * Returns the button title
     * 
     * @return string
     */
    public function getButtonTitleShort() {
        if (is_null($this->buttontitleshort)) {
            $this->buttontitleshort = _t($this->class . '.BUTTONTITLESHORT', $this->class);
        }
        return $this->buttontitleshort;
    }

    /**
     * Returns the title
     * 
     * @return string
     */
    public function getTitle() {
        if (is_null($this->title)) {
            $this->title = _t($this->class . '.TITLE', $this->class);
        }
        return $this->title;
    }

    /**
     * Returns the title
     * 
     * @return string
     */
    public function getActionName() {
        return $this->class;
    }

    /**
     * Returns the title
     * 
     * @return string
     */
    public function getLowerActionName() {
        return strtolower($this->getActionName());
    }
    
    /**
     * Adds an action to the registered ones.
     * 
     * @param string $action Action to add
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.04.2013
     */
    public static function add($action) {
        if (!in_array($action, self::$registered_actions) &&
            !in_array($action, self::$blacklisted_actions)) {
            self::$registered_actions[] = $action;
        }
    }
    
    /**
     * Adds an action to the registered ones.
     * 
     * @param string $action Action to add
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.04.2013
     */
    public static function register_action($action) {
        self::add($action);
    }
    
    /**
     * Returns a list of registered actions.
     * 
     * @return array
     */
    public static function get_registered_actions() {
        return self::$registered_actions;
    }
    
    /**
     * Removes an action out of the registered ones.
     * Adds an action to the blacklisted ones.
     * 
     * @param string $action Action to add
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.04.2013
     */
    public static function remove($action) {
        if (!in_array($action, self::$blacklisted_actions)) {
            self::$blacklisted_actions[] = $action;
        }
        if (in_array($action, self::$registered_actions)) {
            $flipped_registered_actions = array_flip(self::$registered_actions);
            unset(self::$registered_actions[$flipped_registered_actions[$action]]);
        }
    }
    
    /**
     * Removes an action out of the registered ones.
     * Adds an action to the blacklisted ones.
     * 
     * @param string $action Action to add
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.04.2013
     */
    public static function blacklist_action($action) {
        self::remove($action);
    }
    
    /**
     * Returns a list of blacklisted actions.
     * 
     * @return array
     */
    public static function get_blacklisted_actions() {
        self::$blacklisted_actions;
    }
    
}

/**
 * Interface for a SilvercartProductListAction
 *
 * @package SilvercartProductList
 * @subpackage Actions
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2013 pixeltricks GmbH
 * @since 01.03.2013
 * @license see license file in modules base directory
 */
interface SilvercartProductListActionInterface {
    
    /**
     * Returns whether the given member can execute this action.
     * 
     * @param SilvercartProductList $list   List to check permission for
     * @param Member                $member Member to check permission for
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.04.2013
     */
    public function canExecute(SilvercartProductList $list, Member $member = null);
    
    /**
     * Returns whether the given member can view this action.
     * 
     * @param SilvercartProductList $list   List to check permission for
     * @param Member                $member Member to check permission for
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.04.2013
     */
    public function canView(SilvercartProductList $list, Member $member = null);
    
    /**
     * Handles the given list.
     * 
     * @param SilvercartProductList $list List to handle
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.04.2013
     */
    public function handleList(SilvercartProductList $list);
    
}