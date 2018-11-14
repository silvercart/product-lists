<?php

namespace SilverCart\ProductLists\Extensions\Forms;

use Extension;
use SilvercartProductAddCartFormDetail;

/**
 * Extension for AddToCartForm.
 *
 * @package SilverCart
 * @subpackage ProductLists_Extensions_Forms
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 24.08.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules base directory
 */
class AddToCartFormExtension extends Extension
{
    /**
     * Adds content to insert after the form fields right before the closing 
     * </form> tag.
     * 
     * @param string &$afterFormContent Content to update
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.08.2018
     */
    public function updateAfterFormContent(&$afterFormContent)
    {
        if ($this->owner instanceof SilvercartProductAddCartFormDetail) {
            $afterFormContent .= $this->owner->renderWith("SilvercartProductListsAddToCartFormExtension");
        }
    }
}