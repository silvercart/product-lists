$(document).ready(function() {
    $('.silvercart-add-to-product-list-dropdown').click(function() {
        var uri       = document.baseURI ? document.baseURI : '/',
            productID = $(this).data('product-id'),
            list      = $('ul', $(this).parent('div'));
                console.log('asd');
        var result    = $.ajax({
            url:        uri + 'silvercart-product-list/getLists/',
            dataType:   'json',
            async:      false,
            success:    function(data) {
                console.log(data);
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
    });
});
