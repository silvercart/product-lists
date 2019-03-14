<% if $ProductListPositions %>
<table class="table responsive-table">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th style="width: 60%;">{$ProductListPositions.first.Product.singular_name}</th>
            <th class="text-right">{$ProductListPositions.first.Product.fieldLabel('AvailabilityStatus')}</th>
            <th class="text-right">{$ProductListPositions.first.Product.fieldLabel('Price')}</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <% loop $ProductListPositions %>
            <% include SilverCart/ProductLists/Model/Pages/ProductListPagePosition %>
        <% end_loop %>
    </tbody>
    <tfoot>
    <td colspan="5">
        <% if $CurrentPage.showPricesGross %>
        <small><%t SilverCart\Model\Pages\Page.AllPricesInclVat 'All prices incl. VAT' %></small>
        <% else_if $CurrentPage.showPricesNet %>
        <small><%t SilverCart\Model\Pages\Page.AllPricesExclVat 'All prices excl. VAT' %></small>
        <% end_if %>
    </td>
    </tfoot>
</table>
<% else %>
<div class="alert alert-info"><%t SilverCart\ProductLists\Model\Product\ProductList.ThisListIsEmpty 'This list is empty.' %></div>
<% end_if %>