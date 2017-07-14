<div class="row">
    <div class="span9">
        <div id="silvercart-breadcrumbs-id" class="silvercart-breadcrumbs clearfix">
            <p>{$getBreadcrumbs}</p>
        </div>
    <% if $CurrentRegisteredCustomer %>
        <% if $CurrentList %>
            <% with $CurrentList %>
            <form class="form form-inline margin-top" action="$CurrentPage.Link(update)/$ID" method="post">
                <div class="input-prepend input-append">
                    <span class="add-on"><label for="Title">{$fieldLabel(Title)}</label></span>
                    <input class="span6" name="Title" id="Title" type="text" value="{$Title}">
                    <button class="btn" type="submit"><% _t('SilvercartPage.SAVE') %></button>
                </div>
            </form>
            <hr>
                <% if $SilvercartProductListPositions %>
                    <% loop $SilvercartProductListPositions %>
                        <% include SilvercartProductListPagePosition %>
                    <% end_loop %>
                <% end_if %>
            <% end_with %>
            <% if $ListActions %>
            <hr>
            <div class="btn-toolbar">
                <% loop $ListActions %>
                    <a class="btn btn-default" href="$CurrentPage.Link(execute)/{$ActionName}/{$CurrentPage.CurrentList.ID}" title="{$ButtonTitle}">{$ButtonTitle}</a>
                <% end_loop %>
            </div>
            <% end_if %>
        <% else %>
            <h3><% _t('NO_LIST_AVAILABLE') %></h3>
        <% end_if %>
    <% else %>
        <% include SilvercartMyAccountLoginOrRegister %>
    <% end_if %>
    </div>
    <aside class="span3">
        <% if $CurrentRegisteredCustomer %>
            {$SubNavigation}
        <% end_if %>
        {$InsertWidgetArea(Sidebar)}
    </aside>
</div>