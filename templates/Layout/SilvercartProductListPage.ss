<div id="col1">
    <div id="col1_content" class="clearfix">
        <% include SilvercartBreadCrumbs %>

    <% if CurrentRegisteredCustomer %>
        <h2>$Title</h2>

        $Content
        
        $InsertWidgetArea(Content)
        
        <% include SilvercartProductListTable %>
    <% else %>
        <% include SilvercartMyAccountLoginOrRegister %>
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
