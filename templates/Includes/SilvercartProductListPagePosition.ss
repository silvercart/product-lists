<% if SilvercartProduct %>
    <% control SilvercartProduct %>
<div class="row-fluid silvercart-product-group-page-box-list compactlist clearfix {$EvenOdd} {$FirstLast} {$productAddCartFormObj.FormName}">
    <div class="span1 silvercart-product-group-page-box-image">
            <% if $ListImage %>
                <a href="{$Link}" title="<% sprintf(_t('SilvercartPage.SHOW_DETAILS_FOR','details'),$Title) %>"><img class="img-fluid" src="{$ListImage.Pad(60,60).URL}" alt="{$Title}" /></a>
            <% end_if %>
    </div>
    <div class="span9">
        <div class="silvercart-product-title">
            <h3><a href="{$Link}" title="<% sprintf(_t('SilvercartPage.SHOW_DETAILS_FOR','details'),$Title.HTML) %>" class="open-in-modal" rel="{$Title}">{$Title.HTML}</a></h3>
        </div>
        <div class="silvercart-product-text-info">
            <div class="row-fluid">
                <div class="span6">
                    {$getHtmlEncodedShortDescription}
                </div>
                <div class="span6 clearfix">
                    <span class="silvercart-product-page-box-price pull-right">
                        $fieldLabel(Price): <strong class="silvercart-price">{$Price.Nice}</strong> 
                        <% with $CurrentPage %>
                            <% if $showPricesGross %>
                                <small>(<% sprintf(_t('SilvercartPage.INCLUDING_TAX', 'incl. %s%% VAT'),$TaxRate) %>, <% with $PageByIdentifierCode(SilvercartShippingFeesPage) %><a href="{$Link}" title="<% sprintf(_t('SilvercartPage.GOTO', 'go to %s page'),$Title.XML) %>"><% _t('SilvercartPage.PLUS_SHIPPING','plus shipping') %></a><% end_with %>)</small>
                            <% else_if showPricesNet %>
                                <small>(<% _t('SilvercartPage.EXCLUDING_TAX', 'plus VAT') %>, <% with $PageByIdentifierCode(SilvercartShippingFeesPage) %><a href="{$Link}" title="<% sprintf(_t('SilvercartPage.GOTO', 'go to %s page'),$Title.XML) %>"><% _t('SilvercartPage.PLUS_SHIPPING','plus shipping') %></a><% end_with %>)</small>
                            <% end_if %>
                        <% end_with %>
                    </span>
                    <small class="right pull-right margin-side"><strong>{$Availability}</strong></small>
                    <small class="right pull-right"><% _t('SilvercartProduct.PRODUCTNUMBER_SHORT') %>: <strong>{$ProductNumberShop}</strong></small>
                    <% if $PluggedInProductMetaData %>
                        <% control $PluggedInProductMetaData %>
                    <br/><small class="right pull-right">$MetaData</small>
                        <% end_control %>
                    <% end_if %>
                </div>
            </div>
        </div>
    </div>
    <div class="span2">
        <a class="btn btn-small btn-default pull-right" href="{$Link}" title="<% sprintf(_t('SilvercartPage.SHOW_DETAILS_FOR','details'),$Title) %>" rel="{$Title}"><% _t('SilvercartPage.DETAILS','Details') %></a>
    </div>

        <% if PluggedInProductListAdditionalData %>
        <div class="silvercart-product-list-additional-data">
            <% control PluggedInProductListAdditionalData %>
                $AdditionalData
            <% end_control %>
        </div>
        <% end_if %>
</div>
    <% end_control %>
<% end_if %>
