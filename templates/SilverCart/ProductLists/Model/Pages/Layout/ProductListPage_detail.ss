<div class="row">
    <section id="content-main" class="col-12 col-md-9">
        <% include SilverCart/Model/Pages/BreadCrumbs %>
    <% if $CurrentRegisteredCustomer %>
        <article>
        <% if $CurrentList %>
            <% with $CurrentList %>
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
            <div class="text-right mb-3">
                <% loop $ListActions %>
                <a class="btn btn-outline-primary" href="{$CurrentPage.Link('execute')}/{$ActionHash}/{$Up.ID}" title="{$ButtonTitle}"><span class="fa fa-{$FontAwesomeIcon}"></span> {$ButtonTitle}</a>
                <% end_loop %>
            </div>
                <% if $ProductListPositions %>
            <table class="table">
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
                    <small><%t SilverCart.PricesIncludeVat 'All prices incl. VAT' %></small>
                    <% else_if $CurrentPage.showPricesNet %>
                    <small><%t SilverCart.PricesExcludeVat 'All prices excl. VAT' %></small>
                    <% end_if %>
                </td>
                </tfoot>
            </table>
                <% end_if %>
            <% end_with %>
            <% if $ListActions %>
            <hr>
            <div class="text-right">
                <% loop $ListActions %>
                <a class="btn btn-outline-primary" href="{$CurrentPage.Link('execute')}/{$ActionHash}/{$Up.ID}" title="{$ButtonTitle}"><span class="fa fa-{$FontAwesomeIcon}"></span> {$ButtonTitle}</a>
                <% end_loop %>
            </div>
            <% end_if %>
        <% else %>
            <h3><%t NO_LIST_AVAILABLE 'You don\'t have any lists yet.' %></h3>
        <% end_if %>
        </article>
    <% else %>
        <% include SilverCart/Model/Pages/MyAccountLoginOrRegister %>
    <% end_if %>
    </section>
    <aside class="col-12 col-md-3">
        <% if $CurrentRegisteredCustomer %>
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
        {$InsertWidgetArea(Sidebar)}
    </aside>
</div>