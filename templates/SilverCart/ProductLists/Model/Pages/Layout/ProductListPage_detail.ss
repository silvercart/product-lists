<div class="row">
    <section id="content-main" class="col-12 col-md-9">
        <% include SilverCart/Model/Pages/BreadCrumbs %>
    <% if $CurrentRegisteredCustomer %>
        <article>
        <% if $CurrentList %>
            <% with $CurrentList %>
                <% include SilverCart/ProductLists/Model/Pages/ProductListDetail %>
            <% end_with %>
        <% else %>
            <h3><%t NO_LIST_AVAILABLE 'You don\'t have any lists yet.' %></h3>
        <% end_if %>
        </article>
    <% else %>
        <% include SilverCart/Model/Pages/MyAccountLoginOrRegister %>
    <% end_if %>
    </section>
    <aside class="col-12 col-md-3">
        <% if $CurrentRegisteredCustomer && $CurrentRegisteredCustomer.AllowMultipleProductLists %>
        <nav class="widget">
            <ul class="nav flex-column">
            <% loop $ProductLists %>
                <li class="{$FirstLast}">
                    <div class="nav-item">
                        <a href="{$Link}" class="nav-link highlight <% if $isCurrentList %>active<% end_if %>" title="{$Title}">{$Title}</a>
                    </div>
                </li>
            <% end_loop %>
            </ul>
        </nav>
            {$SubNavigation}
        <% end_if %>
        {$InsertWidgetArea('Sidebar')}
    </aside>
</div>