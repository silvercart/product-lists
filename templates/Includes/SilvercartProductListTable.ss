<% if SilvercartProductLists %>
<table class="silvercart-table full silvercart-product-list-table">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th><% _t('COL_NAME') %></th>
            <th class="right"><% _t('COL_COUNT') %></th>
            <th class="right"><% _t('COL_CREATED') %></th>
            <th class="right"><% _t('COL_LASTEDITED') %></th>
            <th class="right">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <% control SilvercartProductLists %>
        {$setAsCurrentList}
        <tr>
            <td><a href="{$Link}"><% if IsDefault %><span class="silvercart-default-productlist">&nbsp;</span><% else %>&nbsp;<% end_if %></a></td>
            <td><a href="{$Link}">{$Title}</a></td>
            <td class="right"><a href="{$Link}">{$SilvercartProductListPositions.Count}</a></td>
            <td class="right"><a href="{$Link}">{$CreatedNice}</a></td>
            <td class="right"><a href="{$Link}">{$LastEditedNice}</a></td>
            <td class="right">
                <div class="silvercart-button-small edit">
                    <div class="silvercart-button-small_content">
                        <a href="{$Link}" title="<% _t('SilvercartProductList.SHOW_DETAILS') %>"><span><% _t('SilvercartProductList.SHOW_DETAILS_SHORT') %></span></a>
                    </div>
                </div>
            <% if ListActions %>
                <% control ListActions %>
                <div class="silvercart-button-small {$LowerActionName}">
                    <div class="silvercart-button-small_content">
                        <a href="{$Link}{$ActionName}/{$CurrentPage.CurrentList.ID}" title="{$ButtonTitle}"><span>{$ButtonTitleShort}</span></a>
                    </div>
                </div>
                <% end_control %>
            <% end_if %>
            </td>
        </tr>
    <% end_control %>
    </tbody>
</table>
<% else %>
    <h3><% _t('NO_LIST_AVAILABLE') %></h3>
<% end_if %>