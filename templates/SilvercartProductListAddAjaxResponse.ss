<div class="modal fade" tabindex="-1" role="dialog" id="cart-modal-{$List.ID}-{$Product.ID}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><span class="text-success fa fa-check"></span> <%t SilverCart.ProductAddedToList 'The product was added to your list "{list}".' list=$List.Title %></h4> 
            </div>
            <div class="modal-body">
            <% with $Product %>
                <div class="row">
                    <div class="col-xs-2">
                        <% if $ListImage %>
                            <img class="img-responsive" src="{$ListImage.Pad(100,80).URL}" alt="{$Title}" />
                        <% end_if %>
                    </div>
                    <div class="col-xs-4">
                        <div class="silvercart-product-title">
                            <h3 class="mt-0">{$Title.HTML}</h3>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <span class="text-lg">{$Price.Nice}</span>
                    </div>
                </div>
            <% end_with %>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-gray float-left pull-left" data-dismiss="modal"><%t SilvercartPage.CONTINUESHOPPING 'Continue shopping' %> <span class="fa fa-angle-double-right"></span></button>
                <a class="btn btn-primary" href="{$List.Link}"><%t SilverCart.GoToList 'Go to list' %> <span class="fa fa-angle-double-right"></span></a>
            </div>
        </div>
    </div>
</div>