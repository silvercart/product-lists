<% if $CurrentMember.AllowMultipleProductLists %>
<form class="form form-inline mb-4" action="{$CurrentPage.Link('update')}/{$ID}" method="post">
    <div class="input-group input-group-lg w-100">
        <div class="input-group-prepend">
            <span class="input-group-text"><label for="Title">{$fieldLabel('Title')}</label></span>
        </div>
        <input type="text" class="form-control" placeholder="{$fieldLabel('Title')}" name="Title" id="Title" value="{$Title}">
        <div class="input-group-append">
            <button class="btn btn-outline-primary" type="submit"><%t SilverCart\Model\Pages\Page.SAVE 'Save' %></button>
        </div>
    </div>
</form>
<hr>
<% end_if %>
<div class="text-right mb-3">
<% loop $ListActions %>
    <a class="btn btn-outline-primary" href="{$CurrentPage.Link('execute')}/{$ActionHash}/{$Up.ID}" title="{$ButtonTitle}"><span class="fa fa-{$FontAwesomeIcon}"></span> {$ButtonTitle}</a>
<% end_loop %>
</div>
<% if $ProductListPositions %>
    <% include SilverCart/ProductLists/Model/Pages/ProductListDetailTable %>
    <% if $ListActions %>
<hr>
<div class="text-right">
    <% loop $ListActions %>
    <a class="btn btn-outline-primary" href="{$CurrentPage.Link('execute')}/{$ActionHash}/{$Up.ID}" title="{$ButtonTitle}"><span class="fa fa-{$FontAwesomeIcon}"></span> {$ButtonTitle}</a>
    <% end_loop %>
</div>
    <% end_if %>
<% end_if %>