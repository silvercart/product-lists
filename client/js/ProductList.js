var silvercart = silvercart ? silvercart : [];
silvercart.productList = [];
silvercart.productList.main = function() {
    var property = {
            loadingListsInProgress: false,
            addingToListInProgress: false,
        },
        selector = {
            btnAddToList: 'a.btn-add-to-list, .btn-add-to-list a',
            btnShowList:  '.btn-show-product-list',
        },
        private = {
            btnAddToListClick: function(event)
            {
                event.preventDefault();
                if (property.addingToListInProgress) {
                    return false;
                }
                property.addingToListInProgress = true;
                var btn    = $(this),
                    target = btn.attr('href');
                $.post($(this).attr('href'), {ajax: 1})
                    .done(function (data) {
                        var response = $.parseJSON(data);
                        $('body').append(response.ModalHTML);
                        $(response.ModalSelector).modal();
                        $(response.ModalSelector).on('hidden.bs.modal', function () {
                            $(response.ModalSelector).remove();
                        });
                        property.addingToListInProgress = false;
                        btn.removeAttr('disabled');
                        btn.removeClass('disabled');
                        $('.spinner-border', btn).remove();
                        $('.spinner-grow', btn).remove();
                    });
                return false;
            },
            btnShowListClick: function(event)
            {
                event.preventDefault();
                if (property.loadingListsInProgress) {
                    return false;
                }
                property.loadingListsInProgress = true;
                var btn    = $(this),
                    target = btn.attr('href');
                $.post($(this).attr('href'), {ajax: 1})
                    .done(function (data) {
                        var response = $.parseJSON(data);
                        $('body').append(response.ModalHTML);
                        $(response.ModalSelector).modal();
                        $(response.ModalSelector).on('hidden.bs.modal', function () {
                            $(response.ModalSelector).remove();
                        });
                        property.loadingListsInProgress = false;
                        btn.removeAttr('disabled');
                        btn.removeClass('disabled');
                        $('.spinner-border', btn).remove();
                        $('.spinner-grow', btn).remove();
                    });
                return false;
            },
        },
        public = {
            init: function()
            {
                $(document).on('click', selector.btnAddToList, private.btnAddToListClick);
                $(document).on('click', selector.btnShowList, private.btnShowListClick);
                silvercart.productList.dropdown().init();
            }
        };
    return public;
};
silvercart.productList.dropdown = function() {
    var property = {},
        selector = {
            btnAddToList: '.silvercart-add-to-product-list-dropdown',
        },
        private = {
            btnAddToListClick: function()
            {
                var uri       = document.baseURI ? document.baseURI : '/',
                    productID = $(this).data('product-id'),
                    list      = $('ul', $(this).parent('div'));
                var result    = $.ajax({
                    url:        uri + 'silvercart-product-list/getLists/',
                    dataType:   'json',
                    async:      false,
                    success:    function(data) {
                        $('li', list).each(function() {
                            $(this).remove();
                        });
                        var newTitle = '';
                        $.each(data, function(id, title) {
                            if (id === 'new') {
                                newTitle = title;
                            } else {
                                list.append('<li><a href="' + uri + 'silvercart-product-list/addToList/' + productID + '/' + id + '">' + title + '</a></li>');
                            }
                        });
                        list.prepend('<li><a href="' + uri + 'silvercart-product-list/addToList/' + productID + '/new">' + newTitle + '</a></li>' + '<li class="divider"></li>');
                    }
                });
            },
        },
        public = {
            init: function()
            {
                if ($(selector.btnAddToList).length === 0) {
                    return;
                }
                $(document).on('click', selector.btnAddToList, private.btnAddToListClick);
            }
        };
    return public;
};
$(document).ready(function() {
    silvercart.productList.main().init();
});