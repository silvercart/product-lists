<div id="col1">
    <div id="col1_content" class="clearfix">
    <% include SilvercartBreadCrumbs %>
        
    <% if CurrentList %>
        <% control CurrentList %>
        <form class="yform full" action="$CurrentPage.Link(update)/$ID" method="post">
            <div class="subcolumns">
                <div class="c90l">
                    <div class="type-text big">
                        <label for="Title">{$fieldLabel(Title)}</label>
                        <input name="Title" id="Title" type="text" value="{$Title}">
                    </div>
                </div>
                <div class="c10r">
                    <div class="type-button">
                        <br/>
                        <input type="submit" value="<% _t('SilvercartPage.SAVE') %>">
                    </div>
                </div>
            </div>
        </form>
            <% if SilvercartProductListPositions %>
                <% control SilvercartProductListPositions %>
                    <% include SilvercartProductListPagePosition %>
                <% end_control %>
            <% end_if %>
        <% end_control %>
        <% if ListActions %>
        <hr>
            <% control ListActions %>
        <div class="silvercart-button float_right">
            <div class="silvercart-button_content">
                <a href="$CurrentPage.Link(execute)/{$ActionName}/{$CurrentPage.CurrentList.ID}" title="{$ButtonTitle}">{$ButtonTitle}</a>
            </div>
        </div>
            <% end_control %>
        <% end_if %>
    <% else %>
        <h3><% _t('NO_LIST_AVAILABLE') %></h3>
    <% end_if %>
    </div>
</div>
<div id="col3">
    <div id="col3_content" class="clearfix">
        <% if CurrentRegisteredCustomer %>
            $SubNavigation
        <% end_if %>
        $InsertWidgetArea(Sidebar)
    </div>
    <div id="ie_clearing"> &#160; </div>
</div>
