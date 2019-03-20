<% if $Product %>
    <% with $Product %>
    <tr>
        <td><% if $ListImage %><a href="{$Link}" title="<%t SilverCart\Model\Pages\Page.SHOW_DETAILS_FOR 'Show details for {title}' title=$Title %>"><img class="img-fluid img-responsive" src="{$ListImage.Pad(62,62).URL}" alt="{$Title}" /></a><% end_if %></td>
        <td data-title="{$singular_name}"><a href="{$Link}" title="<%t SilverCart\Model\Pages\Page.SHOW_DETAILS_FOR 'Show details for {title}' title=$Title %>">{$Title.HTML}</a>
            <% if $ShortDescription %><br/><span class="text-muted">{$ShortDescription}</span><% end_if %>
            <% if $ProductNumberShop %><br/><span>{$fieldLabel('ProductNumberShort')}: {$ProductNumberShop}</span><% end_if %>
        </td>
        <td class="text-right" data-title="{$fieldLabel('AvailabilityStatus')}">{$Availability('badge', 'badge-availability')}</td>
        <td class="text-right" data-title="{$fieldLabel('Price')}">{$Price.Nice}</td>
        <td class="text-right">
            <div class="btn-group">
                <a class="btn btn-sm btn-outline-primary" href="{$Up.RemoveLink}" title="<%t SilverCart\Model\Pages\Page.REMOVE_FROM_CART 'remove' %>" data-toggle="tooltip"><span class="fa fa-trash"></span></a>
                <a class="btn btn-sm btn-outline-primary" href="{$Up.AddToCartLink}" title="<%t SilverCart\Model\Product\Product.ADD_TO_CART 'add to cart' %>" data-toggle="tooltip"><span class="fa fa-shopping-cart"></span></a>
            </div>
        </td>
    </tr>
    <% end_with %>
<% end_if %>
