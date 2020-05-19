$(document).ready(function(){
    $('#galleryList').click(function(){
        var tag = $(this).attr('data-tag');
        $('.gallery-tag[data-tag="' + tag + '"]').trigger('click');
    });
});