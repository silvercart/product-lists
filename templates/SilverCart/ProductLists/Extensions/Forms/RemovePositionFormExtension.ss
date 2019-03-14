<% if $CurrentMember.AllowMultipleProductLists %>
    <% if $CurrentMember.isRegisteredCustomer %>
        <% with $Position.Product %>
<div class="btn-group btn-group-xs">
    <a href="{$AddToDefaultListLink(true)}" class="btn btn-link pr-0"><span class="fa fa-check"></span> <%t SilverCart\ProductLists\Model\Product\ProductList.RememberForLater 'remember for later' %></a>
    <button type="button" class="btn btn-link pl-1 dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="sr-only"><%t SilverCart\ProductLists\Model\Product\ProductList.ShowLists 'Show lists' %></span>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{$AddToNewListLink(true)}"><span class="fa fa-plus"></span> <%t SilverCart\ProductLists\Model\Product\ProductList.CreateNewList 'Create a new list' %></a>
        <% if $ProductLists %>
        <div class="dropdown-divider"></div>
            <% loop $ProductLists %>
        <a class="dropdown-item" href="{$AddProductLink($Up.ID, true)}"><% if $IsDefault %><span class="fa fa-star"></span> <% end_if %>{$Title}</a>
            <% end_loop %>
        <% end_if %>
    </div>
</div>
        <% end_with %>
    <% else %>
        <% with $Position.Product %>
<div class="btn-group btn-group-xs">
    <a href="{$AddToNewListLink(true)}" class="btn btn-link pr-0"><span class="fa fa-check"></span> <%t SilverCart\ProductLists\Model\Product\ProductList.RememberForLater 'remember for later' %></a>
    <button type="button" class="btn btn-link pl-1 dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="sr-only"><%t SilverCart\ProductLists\Model\Product\ProductList.ShowLists 'Show lists' %></span>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{$AddToNewListLink(true)}"><span class="fa fa-info"></span> <%t SilverCart\ProductLists\Model\Product\ProductList.AccountRequired 'To add products to a list, you have to login or register an account. Click here to login or create an account.' %></a>
    </div>
</div>
        <% end_with %>
    <% end_if %>
<% else %>
<div class="btn-group btn-group-xs">
    <% if $CurrentMember.isRegisteredCustomer %>
        <% with $Position.Product %>
    <a href="{$AddToDefaultListLink(true)}" class="btn btn-link pr-0"><span class="fa fa-check"></span> <%t SilverCart\ProductLists\Model\Product\ProductList.RememberForLater 'remember for later' %></a>
        <% end_with %>
    <% else %>
        <% with $Position.Product %>
    <a href="{$AddToNewListLink(true)}" class="btn btn-link pr-0"><span class="fa fa-check"></span> <%t SilverCart\ProductLists\Model\Product\ProductList.RememberForLater 'remember for later' %></a>
        <% end_with %>
    <% end_if %>
</div>
<% end_if %>