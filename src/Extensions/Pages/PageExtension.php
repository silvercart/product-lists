<?php

namespace SilverCart\ProductLists\Extensions\Pages;

use SilverStripe\CMS\Controllers\ModelAsController;
use SilverStripe\ORM\DataExtension;

/**
 * 
 * @package SilverCart
 * @subpackage SubPackage
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 29.08.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class PageExtension extends DataExtension
{
    /**
     * Adds some content to display in the header navigation right before the
     * checkout selection item is rendered.
     * 
     * @param string &$content Content to update
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 29.08.2018
     */
    public function updateHeaderNavBeforeCartSelectContent(&$content)
    {
        $ctrl     = ModelAsController::controller_for($this->owner);
        $content .= $ctrl->renderWith(self::class . '_HeaderNavBeforeCartSelectContent');
    }
}