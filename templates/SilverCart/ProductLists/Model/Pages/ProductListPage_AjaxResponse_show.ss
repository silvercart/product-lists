<div class="modal fade" tabindex="-1" role="dialog" id="product-lists-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="fas fa-bars"></span> {$Title}</h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body p-0">
            <% if $CurrentMember.AllowMultipleProductLists %>
                <% include SilverCart/ProductLists/Model/Pages/ProductListTableSmall %>
            <% else %>
                <% if $DefaultList %>
                    <% with $DefaultList %>
                        <% include SilverCart/ProductLists/Model/Pages/ProductListDetail %>
                    <% end_with %>
                <% else %>
                    <div class="alert alert-info"><%t SilverCart\ProductLists\Model\Product\ProductList.ThisListIsEmpty 'This list is empty.' %></div>
                <% end_if %>
            <% end_if %>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-gray" data-dismiss="modal"><%t SilverCart\Model\Pages\Page.CONTINUESHOPPING 'Continue shopping' %> <span class="fa fa-angle-double-right"></span></button>
            </div>
        </div>
    </div>
</div>