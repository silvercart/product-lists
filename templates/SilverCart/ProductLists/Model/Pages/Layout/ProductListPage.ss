<div class="row">
    <section id="content-main" class="col-12 col-md-9">
        <% include SilverCart/Model/Pages/BreadCrumbs %>
    <% if $CurrentRegisteredCustomer %>
        <article>
            <header><h1>{$Title}</h1></header>
            {$Content}
        <% if $CurrentMember.AllowMultipleProductLists %>
            <% include SilverCart/ProductLists/Model/Pages/ProductListTable %>
        <% else %>
            <% if $DefaultList %>
                <% with $DefaultList %>
                    <% include SilverCart/ProductLists/Model/Pages/ProductListDetail %>
                <% end_with %>
            <% else %>
                <div class="alert alert-info"><%t SilverCart\ProductLists\Model\Product\ProductList.ThisListIsEmpty 'This list is empty.' %></div>
            <% end_if %>
        <% end_if %>
        <% if $Form %>
            {$Form}
        <% end_if %>
        </article>
    <% else %>
        <% include SilverCart/Model/Pages/MyAccountLoginOrRegister %>
    <% end_if %>
    <% if $WidgetSetContent.exists %>
        <section class="sc-widget-holder">
            {$InsertWidgetArea('Content')}
        </section>
    <% end_if %>
    </section>
    <aside class="col-12 col-md-3">
        <% if $CurrentRegisteredCustomer %>
            {$SubNavigation}
        <% end_if %>
        {$InsertWidgetArea('Sidebar')}
    </aside>
</div>