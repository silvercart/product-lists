<% if SilvercartProduct %>
    <% control SilvercartProduct %>
        <div class="silvercart-product-group-page-box-list compactlist clearfix $EvenOdd $FirstLast $productAddCartFormObj.FormName">
            <div class="silvercart-product-group-page-box-list_content">
                <div class="subcolumns overflow-visible clearfix">
                    <div class="c10l silvercart-product-group-page-box-image">
                        <div class="subcl">
                            <% if getSilvercartImages %>
                                <% control getSilvercartImages.First %>
                                    <a href="$ProductLink" title="<% sprintf(_t('SilvercartPage.SHOW_DETAILS_FOR','details'),$Image.Title) %>" class="open-in-modal" rel="{$Image.Title}">$Image.SetRatioSize(60,60)</a>
                                <% end_control %>
                            <% end_if %>
                        </div>
                    </div>
                    <div class="c74l">
                        <div class="subcl">
                            <div class="silvercart-product-title">
                                <h3>
                                    <a href="$Link" title="<% sprintf(_t('SilvercartPage.SHOW_DETAILS_FOR','details'),$Title.HTML) %>" class="open-in-modal" rel="{$Title}">$Title.HTML</a>
                                    <span class="silvercart-product-page-box-price float_right">
                                        $fieldLabel(Price) <strong class="silvercart-price">$Price.Nice</strong> 
                                        <% control CurrentPage %>
                                            <% if showPricesGross %>
                                                <small>(<% sprintf(_t('SilvercartPage.INCLUDING_TAX', 'incl. %s%% VAT'),$TaxRate) %>, <% control PageByIdentifierCode(SilvercartShippingFeesPage) %><a href="$Link" title="<% sprintf(_t('SilvercartPage.GOTO', 'go to %s page'),$Title.XML) %>"><% _t('SilvercartPage.PLUS_SHIPPING','plus shipping') %></a><% end_control %>)</small>
                                            <% else_if showPricesNet %>
                                                <small>(<% _t('SilvercartPage.EXCLUDING_TAX', 'plus VAT') %>, <% control PageByIdentifierCode(SilvercartShippingFeesPage) %><a href="$Link" title="<% sprintf(_t('SilvercartPage.GOTO', 'go to %s page'),$Title.XML) %>"><% _t('SilvercartPage.PLUS_SHIPPING','plus shipping') %></a><% end_control %>)</small>
                                            <% end_if %>
                                        <% end_control %>
                                    </span>
                                </h3>
                            </div>
                            <div class="silvercart-product-text-info">
                                <div class="subcolumns">
                                    <div class="c66l">
                                        {$getHtmlEncodedShortDescription}
                                    </div>
                                    <div class="c33r">
                                        <small class="right float_left"><strong>{$Availability}</strong></small>
                                        <small class="right float_right"><% _t('SilvercartProduct.PRODUCTNUMBER_SHORT') %>: <strong>$ProductNumberShop</strong></small>
                                        <% if PluggedInProductMetaData %>
                                            <% control PluggedInProductMetaData %>
                                        <br/><small class="right float_right">$MetaData</small>
                                            <% end_control %>
                                        <% end_if %>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="c16r">
                        <div class="subcr">
                            <div class="silvercart-button-small right">
                                <div class="silvercart-button_content">
                                    <a href="{$Link}" title="<% sprintf(_t('SilvercartPage.SHOW_DETAILS_FOR','details'),$Title) %>" rel="{$Title}"><% _t('SilvercartPage.DETAILS','Details') %></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <% if PluggedInProductListAdditionalData %>
                <div class="silvercart-product-list-additional-data">
                    <% control PluggedInProductListAdditionalData %>
                        $AdditionalData
                    <% end_control %>
                </div>
                <% end_if %>
            </div>
        </div>
    <% end_control %>
<% end_if %>
