<% if $CurrentMember.AllowMultipleProductLists %>
<div class="dropdown">
    <a id="product-list-dropdown" class="btn dropdown-toggle text-left" data-toggle="dropdown" title="<%t SilverCart\ProductLists\Model\Pages\ProductListPage.DEFAULT_TITLE 'My lists' %>">
        <span class="d-block text-truncate"><%t SilverCart\ProductLists\Model\Product\ProductList.My 'My' %></span>
        <strong><%t SilverCart\ProductLists\Model\Product\ProductList.PLURALNAME_SHORT 'Lists' %></strong>
        <span class="caret"></span>
    </a>
    <div class="dropdown-menu" aria-labelledby="product-list-dropdown">
    <% with $PageByIdentifierCode('SilvercartProductListPage') %>
        <a class="dropdown-item" href="{$Link}" title="{$Title}">{$MenuTitle}</a>
        <% if $ProductLists %>
        <div class="dropdown-divider"></div>
            <% loop $ProductLists %>
        <a class="dropdown-item" href="{$Link}" title="{$Title}"><% if $IsDefault %><span class="fa fa-star"></span> <% end_if %>{$Title}</a>
            <% end_loop %>
        <% end_if %>
    <% end_with %>
    </div>
</div>
<% else %>
    <% with $PageByIdentifierCode('SilvercartProductListPage') %>
<a href="{$Link}" class="btn text-left" title="<%t SilverCart\ProductLists\Model\Pages\ProductListPage.DEFAULT_TITLE 'My lists' %>">
    <span class="d-block text-truncate"><%t SilverCart\ProductLists\Model\Product\ProductList.My 'My' %></span>
    <strong><%t SilverCart\ProductLists\Model\Product\ProductList.SINGULARNAME_SHORT 'List' %></strong>
    <span class="fa fa-heart text-muted"></span>
</a>
    <% end_with %>
<% end_if %>