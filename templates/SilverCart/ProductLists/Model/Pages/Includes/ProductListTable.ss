<% if $CurrentMember.AllowMultipleProductLists %>
    <% if $ProductLists %>
<table class="table table-striped responsive-table">
    <thead>
        <tr>
            <th><%t SilverCart\ProductLists\Model\Pages\Includes\ProductListTable.COL_NAME 'Name' %></th>
            <th class="text-right"><%t SilverCart\ProductLists\Model\Pages\Includes\ProductListTable.COL_COUNT 'Product count' %></th>
            <th class="text-right"><%t SilverCart\ProductLists\Model\Pages\Includes\ProductListTable.COL_CREATED 'Created' %></th>
            <th class="text-right"><%t SilverCart\ProductLists\Model\Pages\Includes\ProductListTable.COL_LASTEDITED 'Last update' %></th>
            <th class="text-right">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <% loop $ProductLists %>
        {$setAsCurrentList}
        <tr>
            <td class="text-right text-sm-left" data-title="<%t SilverCart\ProductLists\Model\Pages\Includes\ProductListTable.COL_NAME 'Name' %>"><a href="{$Link}"><% if $IsDefault %><span class="fa fa-star"></span> <% end_if %>{$Title}</a></td>
            <td class="text-right" data-title="<%t SilverCart\ProductLists\Model\Pages\Includes\ProductListTable.COL_COUNT 'Product count' %>"><a href="{$Link}">{$ProductListPositions.count}</a></td>
            <td class="text-right" data-title="<%t SilverCart\ProductLists\Model\Pages\Includes\ProductListTable.COL_CREATED 'Created' %>"><a href="{$Link}">{$CreatedNice}</a></td>
            <td class="text-right" data-title="<%t SilverCart\ProductLists\Model\Pages\Includes\ProductListTable.COL_LASTEDITED 'Last update' %>"><a href="{$Link}">{$LastEditedNice}</a></td>
            <td class="text-right">
                <div class="btn-group">
                    <a class="btn btn-outline-primary btn-sm" href="{$Link}" title="<%t SilverCart\ProductLists\Model\Product\ProductList.SHOW_DETAILS 'Show details' %>" data-toggle="tooltip"><span class="fa fa-search"></span><span class="sr-only"><%t SilverCart\ProductLists\Model\ProductList.SHOW_DETAILS_SHORT 'Details' %></span></a>
            <% if $ListActions %>
                <% loop $ListActions %>
                    <a class="btn btn-outline-primary btn-sm" href="{$Link}{$ActionHash}/{$Up.ID}" title="{$ButtonTitle}" data-toggle="tooltip"><span class="fa fa-{$FontAwesomeIcon}"></span><span class="sr-only">{$ButtonTitle}</span></a>
                <% end_loop %>
            <% end_if %>
                </div>
            </td>
        </tr>
    <% end_loop %>
    </tbody>
</table>
    <% else %>
        <div class="alert alert-info"><%t SilverCart\ProductLists\Model\Pages\Includes\ProductListTable.NO_LIST_AVAILABLE 'You don\'t have any lists yet.' %></div>
    <% end_if %>
<% end_if %>