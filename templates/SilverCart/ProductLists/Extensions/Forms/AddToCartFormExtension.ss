<% if $CurrentMember.AllowMultipleProductLists %>
    <% if $CurrentMember.isRegisteredCustomer %>
        <% with $Product %>
<div class="btn-group btn-group-sm mt-2 float-right">
    <a href="{$AddToDefaultListLink}" class="btn btn-outline-primary" title="<%t SilverCart\ProductLists\Model\Product\ProductList.AddThisProduct 'Add this product to a list' %>"><span class="fa fa-heart"></span> <%t SilverCart\ProductLists\Model\Product\ProductList.AddToList 'Add to list' %></a>
    <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="sr-only"><%t SilverCart\ProductLists\Model\Product\ProductList.ShowLists 'Show lists' %></span>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{$AddToNewListLink}"><span class="fa fa-plus"></span> <%t SilverCart\ProductLists\Model\Product\ProductList.CreateNewList 'Create a new list' %></a>
        <% if $ProductLists %>
        <div class="dropdown-divider"></div>
            <% loop $ProductLists %>
        <a class="dropdown-item" href="{$AddProductLink($Up.ID)}"><% if $IsDefault %><span class="fa fa-star"></span> <% end_if %>{$Title}</a>
            <% end_loop %>
        <% end_if %>
    </div>
</div>
        <% end_with %>
    <% else %>
        <% with $Product %>
<div class="btn-group btn-group-sm mt-2 float-right">
    <a href="{$AddToNewListLink}" class="btn btn-outline-primary" title="<%t SilverCart\ProductLists\Model\Product\ProductList.AddThisProduct 'Add this product to a list' %>"><span class="fa fa-heart"></span> <%t SilverCart\ProductLists\Model\Product\ProductList.AddToList 'Add to list' %></a>
    <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="sr-only"><%t SilverCart\ProductLists\Model\Product\ProductList.ShowLists 'Show lists' %></span>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{$AddToNewListLink}"><span class="fa fa-info"></span> <%t SilverCart\ProductLists\Model\Product\ProductList.AccountRequired 'To add products to a list, you have to login or register an account. Click here to login or create an account.' %></a>
    </div>
</div>
        <% end_with %>
    <% end_if %>
<% else %>
<div class="btn-group btn-group-sm mt-2 float-right">
    <% if $CurrentMember.isRegisteredCustomer %>
        <% with $Product %>
    <a href="{$AddToDefaultListLink}" class="btn btn-secondary btn-add-to-list" title="<%t SilverCart\ProductLists\Model\Product\ProductList.AddThisProduct 'Add this product to a list' %>"><span class="fa fa-heart"></span> <%t SilverCart\ProductLists\Model\Product\ProductList.AddToList 'Add to list' %></a>
        <% end_with %>
    <% else %>
        <% with $Product %>
    <a href="{$AddToNewListLink}" class="btn btn-secondary" title="<%t SilverCart\ProductLists\Model\Product\ProductList.AddThisProduct 'Add this product to a list' %>"><span class="fa fa-heart"></span> <%t SilverCart\ProductLists\Model\Product\ProductList.AddToList 'Add to list' %></a>
        <% end_with %>
    <% end_if %>
</div>
<% end_if %>