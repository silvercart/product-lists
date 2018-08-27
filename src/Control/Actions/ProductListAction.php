<?php

namespace SilverCart\ProductLists\Control\Actions;

use SilverCart\Dev\Tools;
use SilverStripe\Control\Controller;

/**
 * Base class for a action to execute on a ProductList.
 *
 * @package SilverCart
 * @subpackage ProductLists_Control_Actions
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2018 pixeltricks GmbH
 * @since 24.08.2018
 * @license see license file in modules base directory
 */
class ProductListAction extends Controller
{
    /**
     * font awesome icon of the action
     *
     * @var string
     */
    private static $font_awesome_icon = null;
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
    public static $registered_actions = [];
    /**
     * A list of blacklisted actions
     *
     * @var array
     */
    public static $blacklisted_actions = [];
    
    /**
     * Returns whether this action is visible
     * 
     * @return boolean
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 25.07.2013
     */
    public function isVisible()
    {
        return true;
    }
    
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
    public function Link($action = 'execute')
    {
        return Tools::PageByIdentifierCode('SilvercartProductListPage')->Link($action) . '/' . $this->ID;
    }

    /**
     * Returns the button title
     * 
     * @return string
     */
    public function getButtonTitle()
    {
        if (is_null($this->buttontitle)) {
            $this->buttontitle = _t(static::class . '.BUTTONTITLE', static::class);
        }
        return $this->buttontitle;
    }

    /**
     * Returns the button title
     * 
     * @return string
     */
    public function getButtonTitleShort()
    {
        if (is_null($this->buttontitleshort)) {
            $this->buttontitleshort = _t(static::class . '.BUTTONTITLESHORT', static::class);
        }
        return $this->buttontitleshort;
    }

    /**
     * Returns the title
     * 
     * @return string
     */
    public function getTitle()
    {
        if (is_null($this->title)) {
            $this->title = _t(static::class . '.TITLE', static::class);
        }
        return $this->title;
    }

    /**
     * Returns the title
     * 
     * @return string
     */
    public function getActionHash()
    {
        return sha1(static::class);
    }

    /**
     * Returns the font awesome icon.
     * 
     * @return string
     */
    public function getFontAwesomeIcon()
    {
        return $this->config()->get('font_awesome_icon');
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
    public static function add($action)
    {
        if (!in_array($action, self::$registered_actions)
            && !in_array($action, self::$blacklisted_actions)
        ) {
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
    public static function register_action($action)
    {
        self::add($action);
    }
    
    /**
     * Returns a list of registered actions.
     * 
     * @return array
     */
    public static function get_registered_actions()
    {
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
    public static function remove($action)
    {
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
    public static function blacklist_action($action)
    {
        self::remove($action);
    }
    
    /**
     * Returns a list of blacklisted actions.
     * 
     * @return array
     */
    public static function get_blacklisted_actions()
    {
        self::$blacklisted_actions;
    }
}