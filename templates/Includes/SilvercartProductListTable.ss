<% if SilvercartProductLists %>
<table class="table table-striped silvercart-product-list-table">
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
                <a class="btn btn-small" href="{$Link}" title="<% _t('SilvercartProductList.SHOW_DETAILS') %>"><span><% _t('SilvercartProductList.SHOW_DETAILS_SHORT') %></span></a>
            <% if ListActions %>
                <% control ListActions %>
                    <a class="btn btn-small {$LowerActionName}" href="{$Link}{$ActionName}/{$CurrentPage.CurrentList.ID}" title="{$ButtonTitle}"><span>{$ButtonTitleShort}</span></a>
                <% end_control %>
            <% end_if %>
            </td>
        </tr>
    <% end_control %>
    </tbody>
</table>
<% else %>
    <div class="alert alert-info"><% _t('NO_LIST_AVAILABLE') %></div>
<% end_if %>