$(document).ready(function(){
    $('.gallery-item').click(function(){
        var tag = $(this).attr('data-tag');
        var item = $(this).attr('data-item');
        
        $('#galleryBox').addClass('hidden');
        $('#loadingBox').removeClass('hidden');
        
        $.ajax({
            url: '/photo_gallery/item/' + tag,
            type: 'POST',
            data: {'item': item},
            success: function(data){
                $('#loadingBox').addClass('hidden');
                
                $('#galleryBox').html(data);
                $('#galleryBox').removeClass('hidden');
            }
        });
    });
});