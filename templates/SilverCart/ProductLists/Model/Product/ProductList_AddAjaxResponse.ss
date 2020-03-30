<div class="modal fade" tabindex="-1" role="dialog" id="cart-modal-{$List.ID}-{$Product.ID}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <% if $CurrentUser.AllowMultipleProductLists %>
                <h4 class="modal-title"><span class="text-success fa fa-check"></span> <%t SilverCart.ProductAddedToList 'The product was added to your list "{list}".' list=$List.Title %></h4> 
            <% else %>
                <h4 class="modal-title"><span class="text-success fa fa-check"></span> <%t SilverCart.ProductAddedToListSingle 'The product was added to your list.' %></h4> 
            <% end_if %>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            <% with $Product %>
                <div class="row">
                    <div class="col-2 text-center">
                        <% if $ListImage %>
                            <img class="img-fluid" src="{$ListImage.Pad(100,80).URL}" alt="{$Title}" />
                        <% end_if %>
                    </div>
                    <div class="col-6">
                        <div class="silvercart-product-title">
                            <h3 class="mt-0">{$Title.HTML}</h3>
                        </div>
                    </div>
                    <div class="col-4 text-right text-lg">
                        {$PriceNice}
                    </div>
                </div>
            <% end_with %>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-gray" data-dismiss="modal"><%t SilverCart\Model\Pages\Page.CONTINUESHOPPING 'Continue shopping' %> <span class="fa fa-angle-double-right"></span></button>
                <a class="btn btn-primary" href="{$List.Link}"><%t SilverCart.GoToList 'Go to list' %> <span class="fa fa-angle-double-right"></span></a>
            </div>
        </div>
    </div>
</div>